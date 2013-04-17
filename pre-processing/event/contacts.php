<?php
require_once('event.php');
if(!isset($event)) return;

if(!checkPermission(array($projectID,'events',$eventID,'staff','view')))
{
	$errors[] = array('type'=>'error','icon'=>'icon-lock','msg'=>'You do not have permission to view contacts for this event.');
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
				$errors[] = array('type'=>'error','icon'=>'icon-lock','msg'=>'You do not have permission to remove contacts for this event under that group.');
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
			'firstName'			=> $_POST['firstName'],
			'lastName'			=> $_POST['lastName'],
			'email'				=> $_POST['email'],
			'mobile'			=> $_POST['mobile'],
			'company'			=> $_POST['company'],
			'businessUnit'		=> $_POST['businessUnit'],
			'responsibility'	=> $_POST['responsibility'],
			'notes'				=> $_POST['notes']
		);
	}
	
	if($_POST['action'] == "newStaff")
	{
		if(!checkPermission(array($projectID,'events',$eventID,'staff','create')) &&
			!checkPermission(array($projectID,'events',$eventID,'staff','groups',$_POST['groupID'],'create')))
				$errors[] = array('type'=>'error','icon'=>'icon-lock','msg'=>'You do not have permission to add contacts for this event under that group.');
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
			$errors[] = array('type'=>'error','icon'=>'icon-lock','msg'=>'You do not have permission to edit contacts for this event under that group.');
		
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

$contact = array();

if($result)
while($row = $result->fetch_assoc())
{	
	$row['staffInfo'] = json_decode($row['staffInfo'],true);
	$user = array(
		'staffID'				=> $row['uid'],
		'staffGroupID'		=> $row['staffGroupID'],
		'userID'				=> $row['userID'],
		'firstName'			=> (isset($row['staffInfo']['firstName']) && !empty($row['staffInfo']['firstName']))?$row['staffInfo']['firstName']:$row['firstName'],
		'lastName'			=> (isset($row['staffInfo']['lastName']) && !empty($row['staffInfo']['lastName']))?$row['staffInfo']['lastName']:$row['lastName'],
		'email'				=> (isset($row['staffInfo']['email']) && !empty($row['staffInfo']['email']))?$row['staffInfo']['email']:$row['email'],
		'mobile'				=> (isset($row['staffInfo']['mobile']) && !empty($row['staffInfo']['mobile']))?$row['staffInfo']['mobile']:$row['mobile'],
		'businessUnit'	=> (isset($row['staffInfo']['businessUnit']) && !empty($row['staffInfo']['businessUnit']))?$row['staffInfo']['businessUnit']:'',
		'company'			=> (isset($row['staffInfo']['company']) && !empty($row['staffInfo']['company']))?$row['staffInfo']['company']:'',
		'responsibility'	=> (isset($row['staffInfo']['responsibility']) && !empty($row['staffInfo']['responsibility']))?$row['staffInfo']['responsibility']:'',
		'notes'				=> (isset($row['staffInfo']['notes']) && !empty($row['staffInfo']['notes']))?$row['staffInfo']['notes']:'',
	);
	
	$contact[$user['staffGroupID']][] = $user;
}

$sql = "SELECT `uid`, `title` FROM `eventStaffGroups` WHERE `eventID` = '".$eventID."' ORDER BY `order` ASC, `title` ASC";
$results = $db->query($sql);
if($results && $results->num_rows == 0)
{
	$sql = "INSERT INTO `eventStaffGroups` (`eventID`,`title`,`order`,`defaultPermissions`) VALUES('".$eventID."','NCompass','1','1'); ";
	$sql .= "INSERT INTO `eventStaffGroups` (`eventID`,`title`,`order`,`defaultPermissions`) VALUES('".$eventID."','BlackBerry Global','2','1'); ";
	$sql .= "INSERT INTO `eventStaffGroups` (`eventID`,`title`,`order`,`defaultPermissions`) VALUES('".$eventID."','BlackBerry BU','3','{\"view\":\"1\",\"guests\":{\"view\":\"1\",\"invite\":\"1\",\"mine\":\"1\"},\"messages\":{\"view\":\"1\",\"updates\":{\"view\":\"1\"},\"sent\":{\"view\":\"1\",\"mine\":{\"view\":\"1\"}}}}'); ";
	$sql .= "INSERT INTO `eventStaffGroups` (`eventID`,`title`,`order`,`defaultPermissions`) VALUES('".$eventID."','Security','4','{\"view\":\"1\",\"guests\":{\"view\":\"1\",\"all\":\"1\"}}'); ";
	$sql .= "INSERT INTO `eventStaffGroups` (`eventID`,`title`,`order`,`defaultPermissions`) VALUES('".$eventID."','Photographer','5','{\"view\":\"1\",\"media\":{\"view\":\"1\",\"meetGreet\":\"1\"}}'); ";
	$db->multi_query($sql);
	
	$errors[] = array('type'=>'info','icon'=>'icon-sitemap','msg'=>'Default contact groups have been created. Refresh the page to see the changes.');
	
	$sql = "SELECT `uid`, `title` FROM `eventStaffGroups` WHERE `eventID` = '".$eventID."' ORDER BY `order` ASC, `title` ASC";
	$results = $db->query($sql);
}

$contactGroups = array();
if($results)
while($group = $results->fetch_assoc())
{
	$contactGroups[] = $group;
}

$site['pageTitle'] = date("n/j",strtotime($event['start'])) . " " . $event['title'] . ' - Contacts';