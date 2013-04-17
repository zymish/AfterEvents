<?php if(!isset($_POST)) exit;
require_once('../includes/startup.php');

$data = json_decode(stripslashes($_POST['mandrill_events']),true);

if(is_array($data)):
	foreach($data as $item):
		$event = $item['event'];
		/* Posible Events:
			
            send - message has been sent
            hard_bounce - message has hard bounced
            soft_bounce - message has soft bounced
            open - recipient opened a message; will only occur when open tracking is enabled
            click - recipient clicked a link in a message; will only occur when click tracking is enabled
            spam - recipient marked a message as spam
            unsub - recipient unsubscribed
            reject - message was rejected
			
		*/
		$msg = $item['msg'];
		$subject = $db->real_escape_string($msg['subject']);
		$state = $db->real_escape_string($msg['state']);
		$to = $db->real_escape_string($msg['email']);
		$opens = (is_array($msg['opens']))?sizeof($msg['opens']):0;
		$clicks = (is_array($msg['clicks']))?sizeof($msg['clicks']):0;
		
		$sql = "SELECT `uid` FROM `messagesSent` WHERE `type` = 'email' AND `subject` = '".$subject."' AND `to` = '".$to."' LIMIT 1";
		$result = $db->query($sql);
		if($result && $result->num_rows == 1 && $id = $result->fetch_assoc()):
			$id = $id['uid'];
			$sql = "UPDATE `messagesSent` SET `status` = '".$state."', `opens` = '".$opens."', `clicks` = '".$clicks."' WHERE `uid` = '".$id."'";
			$db->query($sql);
		endif;
	endforeach;
endif;