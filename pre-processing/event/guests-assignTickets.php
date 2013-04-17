<?php
require_once('event.php');
if(!isset($event)) return;

if(!checkPermission(array($projectID,'events',$eventID,'guests','mine','edit')))
{
	$errors[] = array('type'=>'error','icon'=>'icon-lock','msg'=>'You do not have permission to edit guests for this event.');
	$site['page'][PAGE_INDEX] = 'event/overview';
	include_once("pre-processing/" . $site['page'][PAGE_INDEX].'.php');
	return;
}

$ticketTypes = $ticketManager->getTicketTypes($eventID);
$addons = $ticketManager->getAddons($eventID);

if($_POST['action'] == "editGuest")
{	
	if(!checkPermission(array($projectID,'events',$eventID,'guests','mine','edit')))
			$errors[] = array('type'=>'error','icon'=>'icon-lock','msg'=>'You do not have permission to edit guests for this event.');
	
	if(empty($_POST['guestID']))
		$errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>'Missing guestID to edit. Please try again.');
	
	if(!isset($errors[0]))
	{
		$guestID = $_POST['guestID'];
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
			'extraData'=>array('company'=>$_POST['company']),
			'firstName'=>$_POST['firstName'],
			'lastName'=>$_POST['lastName'],
			'email'=>$_POST['email'],
			'mobile'=>$_POST['mobile'],
			'notes'=>$_POST['notes'],
			'responsible'=>$_POST['responsible'],
			'rsvp'=>$_POST['rsvp']
		);
		
		$guestManager->editGuest($guestID, $data);
		if($db->error) $errors[] = array('type'=>'error','icon'=>'icon-hdd','msg'=>$db->error);
		else $errors[] = array('type'=>'success','icon'=>'icon-save','msg'=>'Guest edited successfully');
	}
}

if(isset($_POST,$_POST['action']) && $_POST['action'] == 'assignTickets')
{
	
	if(is_array($_POST['row'])):
		foreach($_POST['row'] as $guestID => $guest)
		{
			$data = array(
				'ticketTypeID' => intval($guest['ticketType']),
				'ticketsNo' => (intval($guest['ticketsNo']) > 0)?intval($guest['ticketsNo']):1,
				'addons' => array()
			);
			if(is_array($addons))
			foreach($addons as $addonID => $addon)
				$data['addons'][$addonID] = (isset($guest['addons'],$guest['addons'][$addonID]))?"1":"0";

			if(!$guestManager->editGuest($guestID,$data))
				$errors[] = array('type'=>'error','icon'=>'icon-hdd','msg'=>'There was an issue with GuestID: '.$guestID);		
		}
		$errors[] = array('type'=>'success','icon'=>'icon-group','msg'=>'Guest Tickets and Addons Updated Successfully.');
	endif;
}else if($_POST['action'] == "removeGuest")
{
	if(!checkPermission(array($projectID,'events',$eventID,'guests','mine','remove')))
		$errors[] = array('type'=>'error','icon'=>'icon-lock','msg'=>'You do not have permission to remove guests from this event.');
	else if(!empty($_POST['guestID']))
	{ 
		if(!$guestManager->removeGuest($_POST['guestID'])) $errors[] = array('type'=>'error','icon'=>'icon-hdd','msg'=>'There was a database error.');
		else $errors[] = array('type'=>'success','icon'=>'icon-minus-sign','msg'=>'Guest removed successfully.');
	}else $errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>'Missing guestID of guest to be removed.');
}

$sql = "SELECT `staffInfo` FROM `eventStaff` WHERE `userID` = '".getCurrentUserID()."' AND `eventID` = '".$eventID."'";
$result = $db->query($sql);
if($result && $result->num_rows == 1)
{
	$user = $result->fetch_assoc();
	$user = json_decode($user['staffInfo'],true);
	
	if(!isset($user['tickets']) || !is_array($user['tickets']))
	{
		$user['tickets'] = array('available' => 0);	
	}
	else
	{
		$user['tickets']['available'] = 0;
		foreach($user['tickets'] as $id => $left)
			$ticketTypes[$id]['left'] = $left;
			
		$sql = "SELECT `ticketTypeID` , SUM( `ticketsNo` ) AS `used` FROM `guests` WHERE `eventID` = '".$eventID."' AND `invitedBy` = '".intval(getCurrentUserID())."' AND `ticketTypeID` != '0' GROUP BY `ticketTypeID`";
		$result = $db->query($sql);
		if($result)
		while($row = $result->fetch_assoc())
		{
			$ticketTypes[$row['ticketTypeID']]['left'] -= $row['used'];
		}
		
		foreach($ticketTypes as $value) $user['tickets']['available'] += intval($value['left']);
	}
	
	if(!isset($user['addons']) || !is_array($user['addons']))
	{
		$user['addons'] = array();	
	}
	else
	{
		foreach($user['addons'] as $id => $total)
			$addons[$id]['left'] = $total;
			
		$sql = "SELECT `addons` FROM `guests` WHERE `eventID` = '".$eventID."' AND `invitedBy` = '".intval(getCurrentUserID())."'";
		$result = $db->query($sql);
		if($result)
		while($row = $result->fetch_assoc())
		{
			$row = json_decode($row['addons'],true);
			if(is_array($row))
			foreach($row as $addonID => $has)
			{
				if($has != '1') continue;
				$addons[$addonID]['left']--;
				$addons[$addonID]['used']++;	
			}
			
		}
	}
}
else
{
	$errors[] = array('type'=>'error','icon'=>'icon-lock','msg'=>'You are not a Staff Member for this Event, and therefore are unable to edit your guests.');
	$site['page'][PAGE_INDEX] = 'event/guests';
	include_once("pre-processing/" . $site['page'][PAGE_INDEX].'.php');
	return;
}

$guests = $staffManager->getUserInvitedGuests(getCurrentUserID(),$eventID);
// $groups = $guestManager->getGuestGroupsByUserID(getCurrentUserID(),$eventID);

$site['pageTitle'] = date("n/j",strtotime($event['start'])) . " " . $event['title'] . ' - Manage Guest Tickets and Hospitality';
$site['js'][] = 'jquery.dataTables.min.js';
$site['css'][] = 'jquery.dataTables.css';