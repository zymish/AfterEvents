<?php
require_once('event.php');
if(!isset($event)) return;

if(!checkPermission(array($projectID,'events',$eventID,'tickets','view')))
{
	$errors[] = array('type'=>'error','icon'=>'icon-lock','msg'=>'You do not have permission to view ticketing for this event.');
	$site['page'][PAGE_INDEX] = 'event/overview';
	include_once("pre-processing/" . $site['page'][PAGE_INDEX].'.php');
	return;
}

//Ticket Editing
if(isset($_POST,$_POST['action'],$_POST['eventID']))
{
	if(in_array($_POST['action'],array('editType','newType')))
	{
		$data = array(
			'name' => $_POST['name'],
			'description' => $_POST['description'],
			'price' => $_POST['price'],
			'total' => $_POST['total'],
			'eventID'=>$eventID
		);
		
		if($_POST['action'] == 'newType')
		{
			if($ticketManager->newTicketType($data)) $errors[] = array('type'=>'success','icon'=>'icon-film','msg'=>'Ticket Type Successfully created.');
			else $errors[] = array('type'=>'error','icon'=>'icon-hdd','msg'=>'There was a database error.');
		}else
		{
			if($ticketManager->editTicketType($_POST['ticketTypeID'],$data)) $errors[] = array('type'=>'success','icon'=>'icon-film','msg'=>'Ticket Type Successfully edited.');
			else $errors[] = array('type'=>'error','icon'=>'icon-hdd','msg'=>'There was a database error.');
		}
	}
	elseif(in_array($_POST['action'],array('add','remove')))
	{
		if(!checkPermission(array($projectID,'events',$eventID,'tickets','assign')))
				$errors[] = array('type'=>'error','icon'=>'icon-lock','msg'=>'You do not have permission to edit ticketing for this event.');
		else if(!empty($_POST['staffID']))
		{
			$sql  = "SELECT `staffInfo` FROM `eventStaff` WHERE `uid` = '".intval($_POST['staffID'])."' LIMIT 1";
			$result = $db->query($sql);
			
			if(!$result || $result->num_rows != 1)
				$errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>'Could Not Find Staff Member to add tickets');
			else
			{
				$user = $result->fetch_assoc();
				$user['staffInfo'] = json_decode($user['staffInfo'],true);
				if(!isset($user['staffInfo']['tickets']))
					$user['staffInfo']['tickets'] = array();
				
				//Get Ticket Types
				$ticketTypes = $ticketManager->getTicketTypes($eventID);
				
				foreach($_POST['tickets'] as $id => $value)
				{
					if(!isset($user['staffInfo']['tickets'][$id]))
						$user['staffInfo']['tickets'][$id] = 0;
					
					if($ticketTypes[$id]['total'] < $ticketTypes[$id]['assigned'] + intval($value))
					{
						$errors[] = array('type'=>'error','icon'=>'icon-film','msg'=>'Assigning '.intval($value).' '.$ticketTypes[$id]['name'].' tickets would surpass the total of '.$ticketTypes[$id]['total'].'.');	
						break;
					}
					$user['staffInfo']['tickets'][$id] += intval($value);
				}
				if(!isset($errors[0]))
				{
					$sql = "UPDATE `eventStaff` SET `staffInfo` = '".json_encode($user['staffInfo'])."' WHERE `uid` = '".intval($_POST['staffID'])."' LIMIT 1";
					logActivity(getCurrentUserID(true),$eventID,'Edit Staff Tickets','editStaffTickets',"SQL: ".$sql);
					$result = $db->query($sql);
					if($db->error){
						$errors[] = array('type'=>'error','icon'=>'icon-hdd','msg'=>'There was a Database Error.  Please Try Again.');
						error_log("Edit Staff Allocations had a SQL Error: ".$db->error);
					}
					else $errors[] = array('type'=>'success','icon'=>'icon-film','msg'=>'Staff member ticket allocation successfully adjusted.');
				}
			}
		}else $errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>'Missing StaffID to add tickets to.');
	}
}

//Get Ticket Types
$ticketTypes = $ticketManager->getTicketTypes($eventID);
if(!$ticketTypes || sizeof($ticketTypes) == 0)
{
	$data = array('eventID' => $eventID,'name'=>'P1','description'=>'P1 Tickets');
	$ticketManager->NewTicketType($data);
	$data = array('eventID' => $eventID,'name'=>'P2','description'=>'P2 Tickets');
	$ticketManager->NewTicketType($data);
	
	$ticketTypes = $ticketManager->getTicketTypes($eventID);
}

$totalTickets = 0;
$assignedTickets = 0;
if(is_array($ticketTypes))
foreach($ticketTypes as $type):
	$totalTickets += $type['total'];
	$assignedTickets += $type['assigned'];
endforeach;

$staff = $staffManager->getEventStaffByGroup($eventID);

$site['pageTitle'] = date("n/j",strtotime($event['start'])) . " " . $event['title'] . ' - Ticketing';
$site['js'][] = 'bootstrap-datepicker.js';
$site['css'][] = 'datepicker.css';