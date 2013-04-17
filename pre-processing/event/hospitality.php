<?php
require_once('event.php');
if(!isset($event)) return;

if(isset($_POST,$_POST['action'],$_POST['eventID']))
{
	foreach($_POST as $key => $value)
		$_POST[$key] = (is_array($value))?$value:$db->real_escape_string($value);
	
	$_POST['eventID'] = intval($_POST['eventID']);
	$_POST['staffID'] = intval($_POST['staffID']);
	
	if($_POST['action'] == 'newType')
	{
		$data = array(
			'name'			=> $_POST['name'],
			'description'	=> $_POST['description'],
			'price'			=> $_POST['price'],
			'slug'			=> strtolower(str_replace(array(' ','_','-','"',"'",'\\','/',''),'',$_POST['name'])),
			'eventID'		=> $eventID
		);
			if($ticketManager->newAddonType($data)) $errors[] = array('type'=>'success','icon'=>'icon-film','msg'=>'Hospitality type successfully created.');
			else $errors[] = array('type'=>'error','icon'=>'icon-hdd','msg'=>'There was a database error.');
	}
	
	if(in_array($_POST['action'],array('add','remove')))
	{
		if(!checkPermission(array($projectID,'events',$eventID,'hospitality','assign')))
				$errors[] = array('type'=>'error','icon'=>'icon-lock','msg'=>'You do not have permission to edit hospitality for this event.');
		else if(!empty($_POST['staffID']))
		{
			$sql  = "SELECT `staffInfo` FROM `eventStaff` WHERE `uid` = '".$_POST['staffID']."' LIMIT 1";
			$result = $db->query($sql);
			
			if(!$result || $result->num_rows != 1)
				$errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>'Could not find contact to add hospitality');
			else
			{
				$user = $result->fetch_assoc();
				$user['staffInfo'] = json_decode($user['staffInfo'],true);
				if(!isset($user['staffInfo']['addons']))
					$user['staffInfo']['addons'] = array();
					
				foreach($_POST['addons'] as $id => $value)
				{
					if(!isset($user['staffInfo']['addons'][$id]))
						$user['staffInfo']['addons'][$id] = 0;
					
					if($_POST['action'] == 'remove') $value *= -1;
					$user['staffInfo']['addons'][$id] += intval($value);
				}
				
				$sql = "UPDATE `eventStaff` SET `staffInfo` = '".json_encode($user['staffInfo'])."' WHERE `uid` = '".$_POST['staffID']."' LIMIT 1";
				$result = $db->query($sql);
				logActivity(getCurrentUserID(true),$eventID,'Edit Staff Addons','editStaffAddons',"SQL: ".$sql);
				if($db->error) $errors[] = array('type'=>'error','icon'=>'icon-hdd','msg'=>$db->error);
				else $errors[] = array('type'=>'success','icon'=>'icon-film','msg'=>'Staff member addon allocation successfully adjusted.');
			}
		}else $errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>'Missing staffID to add tickets to.');
	}
}

// hospitality request form processing BEGIN
if(intval($_POST['quantity']) > 0 && !empty($_POST['business_unit'])) {
	$sql = "SELECT `subject`,`body`,`images` FROM `messagesTemplates` WHERE `projectID` = '".$projectID."' AND `msgType` = 'hospitalityRequest' LIMIT 1";
	$result = $db->query($sql);
	$template = $result->fetch_assoc();
	if($template)
	{
		$extraFields = array(
			'{quantity}' => $_POST['quantity'],
			'{type}' => $_POST['type'],
			'{special_requests}' => $_POST['request'],
			'{bu}' => $_POST['business_unit'],
			'{person_requesting}' => $_POST['person_requesting'],
			'{invoice_to}' => $_POST['invoice_to'],
			'{address}' => $_POST['billing_address'],
			'{city}' => $_POST['city'],
			'{state}' => $_POST['state'],
			'{postal}' => $_POST['postal'],
			'{country}' => $_POST['country'],
			'{payment_method}' => $_POST['payment_method'],
			'{po_number}' => $_POST['po_number']
		);
		
		$subject = $messageManager->prepareUserMessage($template['subject'],getCurrentUserID(),$eventID,$extraFields);
		$extraFields['{subject}'] = $subject;
		$body = $messageManager->prepareUserMessage($template['body'],getCurrentUserID(),$eventID,$extraFields);
		
		if($messageManager->send_email("Stephanie Edmondson", "stephanie.edmondson@ncompassonline.com", $subject, $body,$template['images']))
		{
			$errors[] = array('type'=>'success','icon'=>'icon-beer','msg'=>'Your hospitality request has been successfully submitted.');
			if($messageManager->send_email($_SESSION['user']['name'], $_SESSION['user']['email'], $subject, $body,$template['images']))
				$errors[] = array('type'=>'success','icon'=>'icon-envelope','msg'=>"A copy of this request has also been sent to: ".$_SESSION['user']['email']);
		}else $errors[] = array('type'=>'error','icon'=>'icon-hdd','msg'=>'There was an issue submitting your request. Please try again.');
	}
//	if($db->error) error_log($db->error);
}

$addons = $ticketManager->getAddons($eventID);
if(!$addons || sizeof($addons) == 0)
{
	$data = array('eventID' => $eventID,'name'=>'Hospitality','description'=>'Shared Hospitality');
	$ticketManager->NewAddonType($data);
	
	$addons = $ticketManager->getAddons($eventID);
}

$staff = $staffManager->getEventStaffByGroup($eventID);

$site['pageTitle'] = date("n/j",strtotime($event['start'])) . " " . $event['title'] . ' - Hospitality';