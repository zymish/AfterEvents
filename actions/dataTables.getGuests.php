<?php
require_once('../includes/startup.php');

foreach($_GET as $key => $value)
	$_GET[$key] = $db->real_escape_string($value);

$aColumns = array( '','guests`.`lastName','guests`.`firstName','ticketsNo','ticketType','guests`.`rsvp','eventStaff`.`staffInfo' ,'guests`.`notes' );

$output = array(
	"sEcho"=>$_GET['sEcho'],
	"iTotalRecords"=>0,
	"iTotalDisplayRecords"=>0,
	"aaData"=>array()
);

$sql  = "SELECT `guests`.`uid`, `guests`.`eventID`, `guests`.`invitedBy`, `guests`.`ticketsNo`, `guests`.`firstName`,`guests`.`lastName`, `guests`.`email`, `guests`.`mobile`, `guests`.`ticketTypeID`, `guests`.`addons`, `guests`.`notes`, `guests`.`extraData`, `guests`.`rsvp`, ";
$sql .= "CONCAT(`users`.`firstName`,' ',`users`.`lastName`) AS `invitedByName`, `ticketTypes`.`name` as `ticketType`, `eventStaff`.`staffInfo` ";
$sql .= "FROM `guests` LEFT JOIN `users` ON `guests`.`invitedBy` = `users`.`uid`" ;
$sql .= "LEFT JOIN `ticketTypes` ON `guests`.`ticketTypeID` = `ticketTypes`.`uid` ";
// $sql .= "LEFT JOIN `guestGroups` ON `guests`.`groupID` = `guestGroups`.`uid` ";
$sql .= "LEFT JOIN `eventStaff` ON `guests`.`invitedBy` = `eventStaff`.`userID` ";
$sql .= "WHERE `guests`.`eventID` = '".$_GET['eventID']."' ";
if(isset($_GET['sSearch']) && !empty($_GET['sSearch']))
{
	$sql .= "AND (	`guests`.`firstName` LIKE '%".$_GET['sSearch']."%' OR
	 				`guests`.`lastName` LIKE '%".$_GET['sSearch']."%' OR
	 		 CONCAT(`guests`.`firstName`,' ',`guests`.`lastName`) LIKE '%".$_GET['sSearch']."%' OR 
			 		`users`.`firstName` LIKE '%".$_GET['sSearch']."%' OR
	 				`users`.`lastName` LIKE '%".$_GET['sSearch']."%' OR
	 		 CONCAT(`users`.`firstName`,' ',`users`.`lastName`) LIKE '%".$_GET['sSearch']."%' OR  
					`guests`.`notes` LIKE '%".$_GET['sSearch']."%') ";
}
if(isset($_GET['invitedBy']) && !empty($_GET['invitedBy']))
{
	$sql .= "AND `guests`.`invitedBy` = '".$_GET['invitedBy']."' ";
}

$sql .= " GROUP BY `guests`.`uid` ";

$result = $db->query($sql);
if($result):
	$output['iTotalRecords'] = $result->num_rows;
	$output['iTotalDisplayRecords'] = $result->num_rows;
endif;
//ORDERING
if(isset($_GET['iSortCol_0']))
{
	$sOrder = " ORDER BY  ";
	for($i=0;$i<intval($_GET['iSortingCols']); $i++)
	{
		if ($_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" && !empty($aColumns[ intval( $_GET['iSortCol_'.$i] ) ]))
		{
			$sOrder .= "`".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."` ".($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
		}
	}
	
	$sOrder = substr_replace( $sOrder, "", -2 );
	if ( $sOrder == " ORDER BY" )
	{
		$sOrder = "";
	}
	
	$sql .= $sOrder;
}


//LIMIT

if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	$sql .= " LIMIT ".intval($_GET['iDisplayStart']).", ".intval($_GET['iDisplayLength']);

$result = $db->query($sql);
if($result)
while($row = $result->fetch_assoc())
{
	$row['extraData'] = json_decode($row['extraData'],true);
	$row['addons'] = json_decode($row['addons'],true);
	$row['staffInfo'] = json_decode($row['staffInfo'],true);
	real_display_array($row);
	$guest = array(
		"<div class='btn-group'><button class='btn btn-warning btn-small' title='Edit Guest' onclick='editGuest(".$row['uid'].")'><i class='icon-edit'></i></button><button class='btn btn-info btn-small' title='Resend Invitation' onclick='resendInviteConfirm(".$row['uid'].")'><i class='icon-envelope'></i></div>",
		stripslashes($row['lastName']),
    	stripslashes($row['firstName']),
		$row['ticketsNo'],
		$row['ticketType'],
		"<i class='icon-".(($row['rsvp'] == '')?"minus":(($row['rsvp'] == '1')?"check":"check-empty"))."'></i>",
        // $row['groupName'],
		stripslashes($row['staffInfo']['businessUnit']),
        //"<i class='icon-".((isset($row['addons']['hospitality']) && $row['addons']['hospitality'] == '1')?"check":"check-empty")."'></i>",
		stripslashes($row['notes'])
//"<div class='btn-group'><button class='btn btn-info btn-small' title='View Guest Info' onclick='viewGuest(".$row['uid'].")'><i class='icon icon-search'></i></button><button class='btn btn-warning btn-small' title='Edit Guest' onclick='editGuest(".$row['uid'].")'><i class='icon icon-edit'></i></button><i class='icon icon-envelope'></i></button><button class='btn btn-danger btn-small' onclick='bootboxRemoveGuest(".$row['uid'].")'><i class='icon icon-remove'></i></button></div>"
	);
	$output['aaData'][] = $guest;
}
echo json_encode($output);