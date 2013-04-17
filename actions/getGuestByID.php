<?php
require_once('../includes/startup.php');

$output = array(
	'result' => '0',
	'msg'	 => 'Missing Required Data.'
);

if(isset($_REQUEST['guestID'],$_SESSION['user']))
{	
	$guest = $guestManager->getGuestByID($_REQUEST['guestID']);
	if($guest)
	{
		$output['guest'] = $guest;
		$output['groups'] = $guestManager->getGuestGroupsByUserID($guest['invitedByID'],$guest['eventID']);
		$output['result'] = '1';
		unset($output['msg']);
	}else $output['msg'] = 'Unable to Find Guest.';
}

echo json_encode($output);