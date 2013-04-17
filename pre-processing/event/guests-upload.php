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

$ticketManager = new ticketManager;
$ticketTypes = $ticketManager->getTicketTypes($eventID);

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
}
else
{
	$errors[] = array('type'=>'error','icon'=>'icon-lock','msg'=>'You are not a Staff Member for this Event, and therefore are unable to invite guests.');
	$site['page'][PAGE_INDEX] = 'event/guests';
	include_once("pre-processing/" . $site['page'][PAGE_INDEX].'.php');
	return;
}

$numTickets = 0;

//DATA PROCESSING
if(isset($_POST,$_POST['action']))
{
	if($_POST['action'] == "uploadCSV")
	{
		if (isset($_FILES["file"]))
		{
			$fieldNames = array(
				1=>'firstName',
				2=>'lastName',
				3=>'email',
				4=>'ticketsNo',
				5=>'mobile',
				6=>'company',
				7=>'notes'
			);
			
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('CP1251');
			$data->read($_FILES["file"]["tmp_name"]);
			
			$guests = array();
			$start = false;
			$end = false;
			for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
				$temp = array();
				for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
					if(!isset($fieldNames[$j])) continue;
					if($data->sheets[0]['cells'][$i][$j] == 'Start Data Here')
					{
						$i++;
						$start = true;	
					}else if($data->sheets[0]['cells'][$i][$j] == 'End Data Here')
					{
						$end = true;
						break;
					}
					if($start)$temp[$fieldNames[$j]] = htmlentities($data->sheets[0]['cells'][$i][$j]);
				}
				if($end)break;
				
				if(!empty($temp['email']) && $temp['email'] != 'email'):
					$temp['email'] = trim($temp['email']);
					$guests[$i] = $temp;
					$numTickets += intval($temp['ticketsNo']);
				endif;
			}
			
			if(is_array($guests))
			foreach($guests as $guest) {
				if(!empty($groups)) {
					foreach($groups as $key => $value) {
						if($key === $guest['group']) {
							$groups[$guest['group']]++;
						} else {
							$groups[$guest['group']] = "1";
						}
					}
				} else {
					$groups[$guest['group']] = "1";
				}
			}
			
		}else
			$errors[] = array('type'=>'error','icon'=>'icon-hdd','msg'=>'Missing Uploaded File.  Please Try Again.');
	}
	elseif($_POST['action'] == 'addGuests')
	{
		$noEmail = $_POST['noEmail'];
		$guestManager = new guestManager;
		if(is_array($_POST['row']))
		foreach($_POST['row'] as $row):
			$groupID = 0;
			$typeID = 0;
			/*
			if(!empty($row['group']))
			{
				$data = array(
					'eventID' 	=> $eventID,
					'createdBy' => getCurrentUserID(),
					'name'		=> $row['group']
				);
				$groupID = $guestManager->createNewGuestGroup($data);
			}
			*/
			if(is_array($ticketTypes))
			foreach($ticketTypes as $key => $type)
			{
				if($type['left'] > 0)
				{
					$typeID = $type['uid'];
					$ticketTypes[$key]['left']--;
					break;	
				}
			}
			
			$data = array(
				'eventID'	=> $eventID,
				'invitedBy'	=> getCurrentUserID(),
				'firstName'	=> $row['firstName'],
				'lastName'	=> $row['lastName'],
				'email'		=> $row['email'],
				'mobile'	=> $row['mobile'],
				'ticketsNo'	=> $row['ticketsNo'],
				'company'	=> $row['extraData']['company'],
				'birthdate'	=> $row['birthdate'],
				'notes'		=> $row['notes'],
				'groupID'	=> intval($groupID),
				'ticketTypeID'	=> intval($typeID)
			);
			if(empty($typeID))
				$errors[] = array('type'=>'error','icon'=>'icon-film','msg'=>$row['firstName'].' '.$row['lastName'].' was not invited.  You have run out of tickets.');
			else
			{
				if($noEmail == 'noEmail'):
					$data['rsvp'] = 1;
					$result = $guestManager->inviteNewGuest($data,true);
				else:
					$result = $guestManager->inviteNewGuest($data);
				endif;
				
				if($result) $totalGuests++;
			}
		endforeach;
		
		$errors[] = array('type'=>'success','icon'=>'icon-group','msg'=>'<strong>'.intval($totalGuests) . '</strong> Guests have been uploaded successfully!');
		$site['page'][PAGE_INDEX] = 'event/guests-assignTickets';
		require('guests-assignTickets.php');
		return;
	}
}

$site['pageTitle'] = date("n/j",strtotime($event['start'])) . " " . $event['title'] . ' - Invite New Guests'.(($_REQUEST['email'] == 'noEmail')?" (No Email Confirmation)":"");
$site['js'][] = 'bootstrap-datepicker.js';
$site['js'][] = 'jquery.dataTables.min.js';
$site['css'][] = 'datepicker.css';
$site['css'][] = 'jquery.dataTables.css';