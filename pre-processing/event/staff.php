<?php
require_once('event.php');
if(!isset($event)) return;

if(!checkPermission(array($projectID,'events',$eventID,'staff','view')))
{
	$errors[] = array('type'=>'error','icon'=>'icon-lock','msg'=>'You do not have permission to view brand ambassadors for this event.');
	$site['page'][PAGE_INDEX] = 'event/overview';
	include_once("pre-processing/" . $site['page'][PAGE_INDEX].'.php');
	return;
}

//DATA PROCESSING
if(isset($_POST,$_POST['action'],$_POST['eventID']))
{
	$_POST = real_escape_array($_POST);
	
	$_POST['groupID'] = intval($_POST['groupID']);
	$_POST['userID'] = intval($_POST['userID']);
	$_POST['staffID'] = intval($_POST['staffID']);
	
	if($_POST['action'] == "removeStaff")
	{
		if(!checkPermission(array($projectID,'events',$eventID,'staff','remove')) &&
			!checkPermission(array($projectID,'events',$eventID,'staff','groups',$_POST['groupID'],'remove')))
				$errors[] = array('type'=>'error','icon'=>'icon-lock','msg'=>'You do not have permission to remove brand ambassadors from this event.');
		else if(!empty($_POST['staffID']))
		{
			if(!$staffManager->removeStaff($_POST['staffID'])) $errors[] = array('type'=>'error','icon'=>'icon-hdd','msg'=>'There was an issue deleting this contact.');
			else $errors[] = array('type'=>'success','icon'=>'icon-minus-sign','msg'=>'Contact removed successfully.');
		}else $errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>'Missing ID of contact to be removed.');
	}
	else
	{	
		if(empty($_POST['groupID']))
			$errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>'Invalid group given for contact. Please try again.');
				
		if(empty($_POST['email']))
			$errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>'Invalid email address given for contact. Please try again.');
		
		if($eventID != $_POST['eventID'])
			$errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>'EventID does not match. Please try again.');
		
		$staffInfo = array(
			'firstName'				=> $_POST['firstName'],
			'lastName'				=> $_POST['lastName'],
			'email'					=> $_POST['email'],
			'mobile'					=> $_POST['mobile'],
			'gender'				=> $_POST['gender'],
			'dressSize'			=> $_POST['dressSize'],
			'shirtSize'				=> $_POST['shirtSize'],
			'pantsSize'			=> $_POST['pantsSize'],
			'shoeSize'				=> $_POST['shoeSize'],
			'emergencyName'	=> $_POST['emergencyName'],
			'emergencyPhone'	=> $_POST['emergencyPhone'],
			'timeIn'					=> $_POST['timeIn'],
			'timeOut'				=> $_POST['timeOut'],
			'paperwork'			=> $_POST['paperwork'],
			'onSiteTraining'		=> $_POST['onSiteTraining'],
			'deviceIssued'		=> $_POST['deviceIssued'],
			'uniformIssued'		=> $_POST['uniformIssued'],
			'uniformReturned'	=> $_POST['uniformReturned'],
			'staffNo'					=> $_POST['staffNo'],
			'onDutyMan'			=> $_POST['onDutyMan']
			
		);
	}
	
	if($_POST['action'] == "newStaff")
	{
		if(!checkPermission(array($projectID,'events',$eventID,'staff','create')) &&
			!checkPermission(array($projectID,'events',$eventID,'staff','groups',$_POST['groupID'],'create')))
				$errors[] = array('type'=>'error','icon'=>'icon-lock','msg'=>'You do not have permission to add brand ambassadors for this event.');
		if(!isset($errors[0]))
		{
			if($_POST['needsLogin'])
			{
				$data = array(
					'firstName'		=> $_POST['firstName'],
					'lastName'		=> $_POST['lastName'],
					'mobile'		=> $_POST['mobile'],
					'email'			=> $_POST['email'],
					'eventID'		=> $eventID
				);
				$sql = "SELECT `uid` FROM `users` WHERE `email` = '".$db->real_escape_string($_POST['email'])."' LIMIT 2";
				$result = $db->query($sql);
				if($result && $result->num_rows == 1):
					$userID = $result->fetch_assoc();
					$userID = $userID['uid'];
				else:
					$userID = $userManager->inviteUser($data);
				endif;
				
				$data = real_array_merge($data,array(
					'userID'		=> $userID,
					'staffInfo' 	=> json_encode($staffInfo),
					'staffGroupID'	=> $_POST['groupID']
				));
				
				if($staffManager->addStaff($data) === false) $errors[] = array('type'=>'error','icon'=>'icon-hdd','msg'=>'There was an error creating this contact.');
				else $errors[] = array('type'=>'success','icon'=>'icon-save','msg'=>'New contact added successfully. They will be sent an email asking them to register.');
				
			} else {
				$data = array(
					'eventID'		=> $eventID,
					'userID'		=> $_POST['userID'],
					'staffInfo' 	=> json_encode($staffInfo),
					'staffGroupID'	=> $_POST['groupID']
					);
				
				if($staffManager->addStaff($data) === false) $errors[] = array('type'=>'error','icon'=>'icon-hdd','msg'=>'There was an error creating this contact.');
				else $errors[] = array('type'=>'success','icon'=>'icon-save','msg'=>'New contact added successfully.');
			}
		}
	}
	else if($_POST['action'] == "editStaff")
	{	
		if(!checkPermission(array($projectID,'events',$eventID,'staff','edit')) && !checkPermission(array($projectID,'events',$eventID,'staff','groups',$_POST['groupID'],'edit')))
			$errors[] = array('type'=>'error','icon'=>'icon-lock','msg'=>'You do not have permission to edit brand ambassadors.');
		
		if(empty($_POST['staffID']))
			$errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>'Missing ID of contact to edit. Please try again.');
		
		if(!isset($errors[0]))
		{
			$data = array(
				'userID' => $_POST['userID'],
				'staffInfo' => $staffInfo,
				'staffGroupID' => $_POST['groupID']
			);
			
			if($staffManager->editStaff($_POST['staffID'],$data) === false) $errors[] = array('type'=>'error','icon'=>'icon-hdd','msg'=>'There was an error editing this contact');
			else $errors[] = array('type'=>'success','icon'=>'icon-save','msg'=>'Contact edited successfully.');
		}
	}
}


$sql  = "SELECT `eventStaff`.`uid`, `eventStaff`.`userID`, `eventStaff`.`staffInfo`, `eventStaff`.`staffGroupID`, ";
$sql .= "`users`.`firstName`, `users`.`lastName`, `users`.`email`, `users`.`mobile` ";
$sql .= "FROM `eventStaff` LEFT JOIN `users` ON `eventStaff`.`userID` = `users`.`uid` WHERE `eventID` = '".$eventID."' ORDER BY `staffGroupID` ASC";
$result = $db->query($sql);

$staff = array();

if($result)
while($row = $result->fetch_assoc())
{	
	$row['staffInfo'] = json_decode($row['staffInfo'],true);
	$user = array(
		'staffID'					=> $row['uid'],
		'staffGroupID'			=> $row['staffGroupID'],
		'userID'					=> $row['userID'],
		'firstName'				=> (isset($row['staffInfo']['firstName']) && !empty($row['staffInfo']['firstName']))?$row['staffInfo']['firstName']:$row['firstName'],
		'lastName'				=> (isset($row['staffInfo']['lastName']) && !empty($row['staffInfo']['lastName']))?$row['staffInfo']['lastName']:$row['lastName'],
		'email'					=> (isset($row['staffInfo']['email']) && !empty($row['staffInfo']['email']))?$row['staffInfo']['email']:$row['email'],
		'mobile'					=> (isset($row['staffInfo']['mobile']) && !empty($row['staffInfo']['mobile']))?$row['staffInfo']['mobile']:$row['mobile'],
		'gender'				=> (isset($row['staffInfo']['gender']) && !empty($row['staffInfo']['gender']))?$row['staffInfo']['gender']:$row['gender'],
		'dressSize'			=> (isset($row['staffInfo']['dressSize']) && !empty($row['staffInfo']['dressSize']))?$row['staffInfo']['dressSize']:$row['dressSize'],
		'shirtSize'				=> (isset($row['staffInfo']['shirtSize']) && !empty($row['staffInfo']['shirtSize']))?$row['staffInfo']['shirtSize']:$row['shirtSize'],
		'pantsSize'			=> (isset($row['staffInfo']['pantsSize']) && !empty($row['staffInfo']['pantsSize']))?$row['staffInfo']['pantsSize']:$row['pantsSize'],
		'shoeSize'				=> (isset($row['staffInfo']['shoeSize']) && !empty($row['staffInfo']['shoeSize']))?$row['staffInfo']['shoeSize']:$row['shoeSize'],
		'emergencyName'	=> (isset($row['staffInfo']['emergencyName']) && !empty($row['staffInfo']['emergencyName']))?$row['staffInfo']['emergencyName']:$row['emergencyName'],
		'emergencyPhone'	=> (isset($row['staffInfo']['emergencyPhone']) && !empty($row['staffInfo']['emergencyPhone']))?$row['staffInfo']['emergencyPhone']:$row['emergencyPhone'],
		'timeIn'					=> (isset($row['staffInfo']['timeIn']) && !empty($row['staffInfo']['timeIn']))?$row['staffInfo']['timeIn']:$row['timeIn'],
		'timeOut'				=> (isset($row['staffInfo']['timeOut']) && !empty($row['staffInfo']['timeOut']))?$row['staffInfo']['timeOut']:$row['timeOut'],
		'paperwork'			=> (isset($row['staffInfo']['paperwork']) && !empty($row['staffInfo']['paperwork']))?$row['staffInfo']['paperwork']:$row['paperwork'],
		'onSiteTraining'		=> (isset($row['staffInfo']['onSiteTraining']) && !empty($row['staffInfo']['onSiteTraining']))?$row['staffInfo']['onSiteTraining']:$row['onSiteTraining'],
		'deviceIssued'		=> (isset($row['staffInfo']['deviceIssued']) && !empty($row['staffInfo']['deviceIssued']))?$row['staffInfo']['deviceIssued']:$row['deviceIssued'],
		'uniformIssued'		=> (isset($row['staffInfo']['uniformIssued']) && !empty($row['staffInfo']['uniformIssued']))?$row['staffInfo']['uniformIssued']:$row['uniformIssued'],
		'unfiormReturned'	=> (isset($row['staffInfo']['uniformReturned']) && !empty($row['staffInfo']['uniformReturned']))?$row['staffInfo']['uniformReturned']:$row['uniformReturned'],
		'staffNo'					=> (isset($row['staffInfo']['staffNo']) && !empty($row['staffInfo']['staffNo']))?$row['staffInfo']['staffNo']:$row['staffNo'],
		'onDutyMan'			=> (isset($row['staffInfo']['onDutyMan']) && !empty($row['staffInfo']['onDutyMan']))?$row['staffInfo']['onDutyMan']:$row['onDutyMan']
		
	);
	
	$staff[$user['staffGroupID']][] = $user;
}

$sql = "SELECT `uid`, `title` FROM `eventStaffGroups` WHERE `eventID` = '".$eventID."' AND `title` = 'Brand Ambassador' ORDER BY `order` ASC";
$results = $db->query($sql);
if($results && $results->num_rows == 0)
{
	$sql = "INSERT INTO `eventStaffGroups` (`eventID`,`title`,`order`,`defaultPermissions`) VALUES('".$eventID."','Brand Ambassador','1','1'); ";
	$db->query($sql);
	
	$errors[] = array('type'=>'info','icon'=>'icon-sitemap','msg'=>'Default contact groups have been created. Refresh the page to see the changes.');
	
	$sql = "SELECT `uid`, `title` FROM `eventStaffGroups` WHERE `eventID` = '".$eventID."' ORDER BY `order` ASC, `title` ASC";
	$results = $db->query($sql);
}

$staffGroups = array();
if($results)
while($group = $results->fetch_assoc())
{
	$staffGroups[] = $group;
}

$site['pageTitle'] = date("n/j",strtotime($event['start'])) . " " . $event['title'] . ' - Staff';