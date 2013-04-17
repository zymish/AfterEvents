<?php
require_once('../includes/startup.php');
$output = array(
	'result' => '0',
	'msg'	 => 'Missing required data.'
);

$eventID = intval($_REQUEST['eventID']);
$guestID = intval($_REQUEST['guestID']);

if(!empty($eventID) && !empty($guestID)):
	$event = $eventManager->getEventByID($eventID);
	$guest = $guestManager->getGuestByID($guestID);
	
	$sql = "SELECT `uid`,`subject`,`body`,`images` FROM `messagesTemplates` WHERE `projectID` = '".$event['projectID']."' AND `msgType` = 'guestInvite' LIMIT 1";
	$result = $db->query($sql);
	if($result && $template = $result->fetch_assoc())
	{
		$subject = $messageManager->prepareMessage($template['subject'],$guestID,$eventID);
		$body = $messageManager->prepareMessage($template['body'],$guestID,$eventID,array('{subject}'=>$subject));
		$messageManager->send_email($guest['firstName']." ".$guest['lastName'], $guest['email'], $subject, $body,$template['images']);
		
		$output['result'] = '1';
		$output['msg'] = 'Email Successfully Sent';
	}
	if($db->error) error_log($db->error);
endif;
			
echo json_encode($output);