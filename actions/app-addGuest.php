<?php
require_once('app-authConnect.php');
if($output['result'] == '0')
{
	echo json_encode($output);
	return;
}

$output['result'] = 0;
$sql = "SELECT `uid`,`projectID`,`title`,`start` FROM `events` WHERE `appID` = '".$db->real_escape_string($_REQUEST['appID'])."'";
$result = $db->query($sql);
if($result && $result->num_rows == 1)
{
	$event = $result->fetch_assoc();
	
	if($guestManager->inviteNewGuest(json_decode($_REQUEST['data'],true),true))
	{
		$output['event'] = $event;
		$output['result'] = 1;
		$output['msg'] = 'Guest added successfully.';
	}else
		$output['msg'] = 'There was an error while uploading the guest.';
	
}else $output['msg'] =  'Invalid AppID.';

echo json_encode($output);
