<?php
require_once('../includes/startup.php');

foreach($_GET as $key => $value)
	$_GET[$key] = $db->real_escape_string($value);

$_GET['eventID'] = intval($_GET['eventID']);

$sql = "SELECT `uid`,`name`,`description`,`total`,`price` FROM `ticketTypes` WHERE `eventID` = '".$_GET['eventID']."' ORDER BY `name` ASC";
$result = $db->query($sql);
$ticketTypes = array();
if($result) while($row = $result->fetch_assoc())
{
	foreach($row as $key => $value)
		$row[$key] = htmlentities($value);
	$ticketTypes[] = $row;
}

$aColumns = array( 'staffName', 'eventStaff`.`extraData');
foreach($ticketTypes as $value)
	$aColumns[] = $value['uid'];

$aColumns[] = '';

$output = array(
	"sEcho"=>$_GET['sEcho'],
	"iTotalRecords"=>0,
	"iTotalDisplayRecords"=>0,
	"aaData"=>array()
);

$sql  = "SELECT `eventStaff`.`uid`, `eventStaff`.`staffInfo`, `eventStaffGroups`.`title` AS `staffGroup`, ";
$sql .= "CONCAT(`users`.`firstName`,' ',`users`.`lastName`) as `staffName` ";
$sql .= "FROM `eventStaff` LEFT JOIN `users` ON `eventStaff`.`userID` = `users`.`uid` LEFT JOIN `eventStaffGroups` on `eventStaffGroups`.`uid` = `eventStaff`.`staffGroupID`";
$sql .= "WHERE `eventStaff`.`eventID` = '".$_GET['eventID']."' AND `eventStaff`.`userID` > 0";

if(isset($_GET['sSearch']) && !empty($_GET['sSearch']))
{
	$sql .= "AND (	`users`.`firstName` LIKE '%".$_GET['sSearch']."%' OR
	 				`users`.`lastName` LIKE '%".$_GET['sSearch']."%' OR
	 		 CONCAT(`users`.`firstName`,' ',`users`.`lastName`) LIKE '%".$_GET['sSearch']."%') ";
}

//ORDERING
if(isset($_GET['iSortCol_0']))
{
	$sOrder = " ORDER BY  ";
	for($i=0;$i<intval($_GET['iSortingCols']); $i++)
	{
		if(intval($_GET['iSortCol_'.$i]) >= 2) continue;
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
	
	$row['staffInfo'] = json_decode($row['staffInfo'],true);
	$staff = array(
		$row['staffInfo']['businessUnit']
	);
	
	$total = 0;
	if(is_array($ticketTypes))
	foreach($ticketTypes as $value)
	{	
		$staff[] = intval($row['staffInfo']['tickets'][$value['uid']]);
		$total += intval($row['staffInfo']['tickets'][$value['uid']]);
	}
	$staff[] = $total;
		
	$staff[] = '<div class="btn-group"><button class="btn btn-small btn-success" title="Add Tickets" onClick="addTicketsModal(\''.intval($row['uid']).'\')"><i class="icon-plus"></i></button></div>';//<button class="btn btn-small btn-info" title="View Contact Information" onClick="viewStaffModal(\''.intval($row['uid']).'\')"><i class="icon-envelope"></i></button><button class="btn btn-small btn-primary" title="View Invited Guests" disabled><i class="icon-search"></i></button><button class="btn btn-small btn-danger" title="Remove Tickets" onClick="removeTicketsModal(\''.intval($row['uid']).'\')"><i class="icon-minus"></i></button>
	
	$output['aaData'][] = $staff;
	$output['iTotalRecords']++;
	$output['iTotalDisplayRecords']++;
}

echo json_encode($output);