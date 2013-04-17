<?php
require_once('event.php');
if(!isset($event)) return;

if(isset($_POST['action'])):
	if($_POST['action'] == 'sendEmail'):
		
		$sql = "SELECT `uid`,`subject`,`body`,`images` FROM `messagesTemplates` WHERE `projectID` = '1' AND `msgType` = 'massTemplate' LIMIT 1";
		$result = $db->query($sql);
		if($result && $template = $result->fetch_assoc()):	
			$sql = "SELECT `uid`,CONCAT(`firstName`,' ',`lastName`) AS `name`,`email` FROM `guests` WHERE `eventID` = '".$eventID."'";
			if($_POST['emailRecipients'] == 2)
				$sql .= " AND 'invitedBy' = '".getCurrentUserID()."'";
				
			$result = $db->query($sql);
			if($result && $result->num_rows > 0):
				while($guest = $result->fetch_assoc()):
					$guestID = $guest['uid'];
					$recipient_name = $guest['name'];
					$recipient_email = $guest['email'];
					$subject = (!empty($_POST['subject']))?stripslashes($_POST['subject']):$template['subject'];
					$body = stripslashes($_POST['body']);
					
					$subject = $messageManager->prepareMessage($subject,$guestID,$eventID);
					$body = $messageManager->prepareMessage($template['body'],$guestID,$eventID,array('{subject}'=>$subject,'{msgBody}'=>$body));
					
					$sendEmail = $messageManager->send_email($recipient_name,$recipient_email,$subject,$body,$template['images']);
				endwhile;
				$errors[] = array('type'=>'success','icon'=>'icon-ok','msg'=>'Message sent successfully.');
			else:
				$errors[] = array('type'=>'error','icon'=>'icon-exclamation-point','msg'=>'No guests found.');
			endif;
		endif;
	elseif($_POST['action'] == 'sendSMS'):
		$messageManager = new MessageManager();
		
		$sql = "SELECT CONCAT(`firstName`,' ',`lastName`) AS `name`,`mobile` FROM `guests` WHERE `eventID` = '".$eventID."'";
		if($_POST['smsRecipients'] == 2)
			$sql .= " AND 'invitedBy' = '".getCurrentUserID()."'";
			
		$result = $db->query($sql);
		if($result && $result->num_rows > 0):
			while($guest = $result->fetch_assoc()):
				$messageManager->sendSMS($guest['mobile'],$_POST['body'],$eventID);
			endwhile;
			$errors[] = array('type'=>'success','icon'=>'icon-ok','msg'=>'SMS messages sent successfully.');
		else:
			$errors[] = array('type'=>'error','icon'=>'icon-exclamation-point','msg'=>'No guests found.');
		endif;
	endif;
endif;

$site['pageTitle'] = date("n/j",strtotime($event['start'])) . " " . $event['title'] . ' - Messaging';
$site['js'][] = 'wysihtml5-0.3.0.min.js';
$site['js'][] = 'advanced.js';