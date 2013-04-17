<?php
require_once('event.php');
if(!isset($event)) return;

if(!checkPermission(array($projectID,'events',$eventID,'guests','view')))
{
	$errors[] = array('type'=>'error','icon'=>'icon-lock','msg'=>'You do not have permission to view guests for this event.');
	$site['page'][PAGE_INDEX] = 'event/overview';
	include_once("pre-processing/" . $site['page'][PAGE_INDEX].'.php');
	return;
}

//DATA PROCESSING
if(isset($_POST,$_POST['action'],$_POST['eventID']))
{
	foreach($_POST as $key => $value)
		$_POST[$key] = $db->real_escape_string($value);
	
	$_POST['userID'] = intval($_POST['userID']);
	$_POST['guestID'] = intval($_POST['guestID']);
	
	if($_POST['action'] == "removeGuest")
	{
		if(!checkPermission(array($projectID,'events',$eventID,'guests','remove')))
			$errors[] = array('type'=>'error','icon'=>'icon-lock','msg'=>'You do not have permission to remove guests from this event.');
		else if(!empty($_POST['guestID']))
		{
			$sql = "DELETE FROM `guests` WHERE `uid` = '".$_POST['guestID']."' LIMIT 1";
			$db->query($sql);
			if($db->error) $errors[] = array('type'=>'error','icon'=>'icon-hdd','msg'=>$db->error);
			else $errors[] = array('type'=>'success','icon'=>'icon-minus-sign','msg'=>'Guest removed successfully.');
		}else $errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>'Missing guestID of guest to be removed.');
	}
	else
	{					
		if(empty($_POST['email']))
			$errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>'Invalid email address given for guest. Please try again.');
		
		if($eventID != $_POST['eventID'])
			$errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>'EventID does not match.  Please try again.');
		
		$guestInfo = array(
			'firstName' => $_POST['firstName'],
			'lastName' => $_POST['lastName'],
			'email' => $_POST['email'],
			'mobile' => $_POST['mobile'],
			'company' => $_POST['company']
		);
		if(!empty($_POST['userID']))
		{
			$sql = "SELECT `firstName`,`lastName`,`email`,`mobile`,`ticketsNo` FROM `users` WHERE `uid` = '".$_POST['userID']."' LIMIT 1";
			$result = $db->query($sql);
			if($db->error) $errors[] = array('type'=>'error','icon'=>'icon-hdd','msg'=>$db->error);
			
			if($result && $result->num_rows == 1)
			{
				$user = $result->fetch_assoc();
				foreach($user as $key => $value)
					if($user[$key] == $staffInfo[$key]) unset($staffInfo[$key]);
			}
		}
		
		$guestInfo = json_encode($guestInfo);
	}
}

$ticketTypes = $ticketManager->getTicketTypes($eventID);

$site['pageTitle'] = date("n/j",strtotime($event['start'])) . " " . $event['title'] . ' - Guests';
$site['js'][] = 'bootstrap-datepicker.js';
$site['js'][] = 'jquery.dataTables.min.js';
$site['css'][] = 'datepicker.css';
$site['css'][] = 'jquery.dataTables.css';