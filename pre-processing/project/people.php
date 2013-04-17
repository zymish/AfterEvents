<?php
$staff = array();
$sql = "SELECT DISTINCT(`eventStaffGroups`.`title`) FROM `eventStaffGroups` ";
$sql .= "LEFT JOIN `events` ON `eventStaffGroups`.`eventID` = `events`.`uid` ";
$sql .= "WHERE `events`.`projectID` = '".$projectID."'";
$result = $db->query($sql);
if($result)
while($row = $result->fetch_assoc()) $staff[$row['title']] = array();

$sql  = "SELECT `eventStaff`.`uid`, `eventStaff`.`userID`, `eventStaff`.`staffInfo`, `eventStaff`.`staffGroupID`, ";
$sql .= "`users`.`firstName`, `users`.`lastName`, `users`.`email`, `users`.`mobile`, ";
$sql .= "`eventStaffGroups`.`title` ";
$sql .= "FROM `eventStaff` ";
$sql .= "LEFT JOIN `eventStaffGroups` ON `eventStaffGroups`.`uid` = `eventStaff`.`staffGroupID` ";
$sql .= "LEFT JOIN `events` ON `events`.`uid` = `eventStaff`.`eventID` ";
$sql .= "LEFT JOIN `users` ON `eventStaff`.`userID` = `users`.`uid` WHERE `events`.`projectID` = '".$projectID."' GROUP BY `eventStaff`.`userID` ORDER BY `staffGroupID` ASC";
$result = $db->query($sql);

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
	$staff[$row['title']][] = $user;
}

$sql = "SELECT `eventStaffGroups`.`uid`, `eventStaffGroups`.`title` FROM `eventStaffGroups` ";
$sql .= "LEFT JOIN `events` ON `events`.`uid` = `eventStaffGroups`.`eventID` ";
$sql .= "WHERE `events`.`projectID` = '".$projectID."' ORDER BY `order` ASC, `title` ASC";
$results = $db->query($sql);

$staffGroups = array();
if($results)
while($group = $results->fetch_assoc())
{
	$staffGroups[] = $group;
}

if($_POST['action'] == "editStaff")
	{	
		if(!checkPermission(array($projectID,'staff','edit')) && !checkPermission(array($projectID,'events',$eventID,'staff','groups',$_POST['groupID'],'edit')))
			$errors[] = array('type'=>'error','icon'=>'icon-lock','msg'=>'You do not have permission to edit contacts under that group.');
		
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

$site['pageTitle'] = 'All Tour Contacts';