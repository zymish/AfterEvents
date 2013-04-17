<?php
require_once('event.php');
if(!isset($event)) return;

if(!checkPermission(array($projectID,'events',$eventID,'guests','invite')))
{
	$errors[] = array('type'=>'error','icon'=>'icon-lock','msg'=>'You do not have permission to invite guests for this event.');
	$site['page'][PAGE_INDEX] = 'event/overview';
	include_once("pre-processing/" . $site['page'][PAGE_INDEX].'.php');
	return;
}

//DATA PROCESSING
if(isset($_POST,$_POST['action']))
{
	
	if($_POST['action'] == "inviteGuest")
	{	
		$guestManager = new guestManager;
		// $groupID = 0;
		// if($_POST['isGroup'] == 'isGroup')
		// {
			// if($_POST['group'] == '-1')
			// {
				// $data = array(
					// 'eventID' 	=> $eventID,
					// 'createdBy' => getCurrentUserID(),
					// 'name'		=> $_POST['newGroupName']
				// );
				// $groupID = $guestManager->createNewGuestGroup($data);
			// }else
				// $groupID = $_POST['group'];
		// }
		$data = array(
			'eventID'	=> $eventID,
			'invitedBy'	=> getCurrentUserID(),
			'firstName'	=> $_POST['firstName'],
			'lastName'	=> $_POST['lastName'],
			'email'		=> $_POST['email'],
			'mobile'	=> $_POST['mobile'],
			'company'	=> $_POST['company'],
			'notes'		=> $_POST['notes'],
			// 'groupID'	=> intval($groupID),
			'hospitality'	=> $_POST['hospitality'],
			'ticketTypeID'	=> $_POST['ticketTypeID'],
			'ticketsNo' => $_POST['ticketsNo']
		);
		$result = $guestManager->inviteNewGuest($data);
		if($result)
			$errors[] = array('type'=>'success','icon'=>'icon-user','msg'=>$_POST['firstName'].' was successfully Invited.');
	}
}

$sql = "SELECT `uid`, `name`,`total` FROM `ticketTypes` WHERE `eventID` = '".$eventID."' ORDER BY `name` ASC";
$result = $db->query($sql);

$ticketTypes = array();

if($result)
while($row = $result->fetch_assoc()):
	$ticketTypes[$row['uid']] = $row;
endwhile;

// $sql = "SELECT `uid`, `name` FROM `guestGroups` WHERE `eventID` = '".$eventID."' AND `createdBy` = '".intval(getCurrentUserID())."' ORDER BY `name` ASC";
// $result = $db->query($sql);

// $groups = array();

// if($result)
// while($row = $result->fetch_assoc()):
	// $groups[$row['uid']] = $row;
// endwhile;

$hasTickets = false;
$canInvite = false;

$sql = "SELECT `staffInfo` FROM `eventStaff` WHERE `userID` = '".intval(getCurrentUserID())."' AND `eventID` = '".$eventID."' LIMIT 2";
$result = $db->query($sql);

if($result && $result->num_rows == 1)
{
	$canInvite = true;
	$row = $result->fetch_assoc();
	$row = json_decode($row['staffInfo'],true);
	if(isset($row['tickets']) && is_array($row['tickets']))
		foreach($row['tickets'] as $id => $left)
			$ticketTypes[$id]['left'] = $left;
	
	if(isset($row['addons']) && is_array($row['addons']))
		foreach($row['addons'] as $id => $left)
			$addons[$id]['left'] = $left;
	
	$addons['hospitality']['left'] = (isset($addons,$addons['hospitality']))?intval($addons['hospitality']['left']):0;
	
	$sql = "SELECT `ticketTypeID` , SUM( `ticketsNo` ) AS `used` FROM `guests` WHERE `eventID` = '".$eventID."' AND `invitedBy` = '".intval(getCurrentUserID())."' AND `ticketTypeID` != '0' GROUP BY `ticketTypeID`";
	$result = $db->query($sql);
	if($result)
	while($row = $result->fetch_assoc())
	{
		$ticketTypes[$row['ticketTypeID']]['left'] -= $row['used'];
	}
	
	$sql = "SELECT `addons` FROM `guests` WHERE `eventID` = '".$eventID."' AND `invitedBy` = '".intval(getCurrentUserID())."'";
	
	$result = $db->query($sql);
	if($result)
	while($row = $result->fetch_assoc())
	{
		$row = json_decode($row['addons'],true);
		if(is_array($row))
		foreach($row as $key => $value)
			$addons[$key]['left'] -= $value;
	}
	
	foreach($ticketTypes as $value)
		if($value['left'] > 0) $hasTickets = true;
	
	if(!$hasTickets)
		$errors[] = array('type'=>'error','icon'=>'icon-film','msg'=>'You have no tickets left.');
}else{
	$errors[] = array('type'=>'error','icon'=>'icon-user','msg'=>'You are not a staff member for this event.');
}

$site['pageTitle'] = date("n/j",strtotime($event['start'])) . " " . $event['title'] . ' - Guests';
$site['js'][] = 'bootstrap-datepicker.js';
$site['js'][] = 'bootbox.min.js';
$site['css'][] = 'datepicker.css';