<?php

/* class messageManager
 * author: Strider Agostinelli
 * relies on Swift Mailer 4.3.0
 */

class messageManager {
    
    function send_email($recipient_name, $recipient_email, $subject, $html, $images = array()) {
        global $db,$projectID,$eventID;
		
		require_once(dirname(__FILE__) . '/swiftMailer/swift_required.php');
        
        $from = array(MANDRILL_SENDER_EMAIL => MANDRILL_SENDER_NAME);
        $to = array(emailStrip($recipient_email) => trim($recipient_name));
		
        $transport = Swift_SmtpTransport::newInstance(MANDRILL_HOST, MANDRILL_PORT);
        $transport->setUsername(MANDRILL_SMTP_USER);
        $transport->setPassword(MANDRILL_SMTP_PASS);
        $swift = Swift_Mailer::newInstance($transport);
		
		$uniqID = '5780';
		$sql = "SELECT `uniqID` FROM `messagesSent` ORDER BY `uniqID` DESC LIMIT 1";
		$result = $db->query($sql);
		while($result && $result->num_rows == 1):
			$uniqID = $result->fetch_assoc();
			$uniqID = intval($uniqID['uniqID'])+1;
			$sql = "SELECT `uniqID` FROM `messagesSent` WHERE `uniqID` = '".$uniqID."' ORDER BY `uniqID` DESC LIMIT 1";
			$result = $db->query($sql);
		endwhile;
        
		$sql  = "INSERT INTO `messagesSent` (`uniqID`,`projectID`,`eventID`,`to`,`from`,`fromID`,`deliveryType`,`subject`,`body`,`created`) VALUES";
		$sql .= "('".$uniqID."','".$projectID."','".$eventID."','".$db->real_escape_string($recipient_email)."','".MANDRILL_SENDER_EMAIL."','".getCurrentUserID()."','email','".$db->real_escape_string($subject." [BBPAK-".$uniqID."]")."','".$db->real_escape_string($html)."',NOW())";
		
		$db->query($sql);
		
		$message = new Swift_Message($subject." [BBPAK-".$uniqID."]");
        $message->setFrom($from);
		
		if(!is_array($images))
			$images = json_decode($images,true);
		
		if(is_array($images))
        foreach($images as $image_name => $image_file) {
            $html = preg_replace("/\{$image_name\}/", $message->embed(Swift_Image::fromPath(SITE_PATH."$image_file")), $html);
        }

        $message->setBody($html,'text/html');
        $message->setTo($to);
		

        if ($recipients = $swift->send($message, $failures)) {
            return true;
        } else {
			error_log(print_r($failures,true));
            return false;
        }
    }
	
	function sendSMS($to,$body,$eventID = 0)
	{
		require_once(dirname(__FILE__) . '/Twilio.php');
		$from = TWILIO_FROM;
		preg_match_all('!\d+!', $to, $to);
		$to = implode('',$to[0]);
		if(strlen($to) != 10) return $to;
		
		$client = new Services_Twilio(TWILIO_SID, TWILIO_AUTH);
		$message = $client->account->sms_messages->create(
		  $from, // From a valid Twilio number
		  $to, // Text this number
		  htmlentities($body)
		);
		
		logActivity(getCurrentUserID(true),$eventID,'SMS Sent','smsOut',$to." : ".$message->sid . " : ".$body);
		return true;
	}
	
	function prepareRecoveryMessage($text,$userID = 0,$extraFields = array())
	{
		$user = array();
		$userID = intval($userID);
		
		global $db, $errors,$userManager;
		if(!empty($userID))
		{
			$user = $userManager->getUserByID($userID); 
		}
		$find = array(
			'{firstName}',
			'{lastName}',
			'{email}',
			'{newPass}',
			'{siteURL}'
		);
		$replace = array(
			$user['firstName'],
			$user['lastName'],
			$user['email'],
			base64_decode(base64_decode($user['password'])),
			SITE_ROOT,
		);
		if(is_array($extraFields))
		foreach($extraFields as $key => $value)
		{
			$find[] = $key;
			$replace[] = $value;	
		}
		return str_replace($find,$replace,$text);
	}
	
	function prepareUserMessage($text,$userID = 0,$eventID = 0,$extraFields = array())
	{
		$user = array();
		$event = array();
		$userID = intval($userID);
		$eventID = intval($eventID);
		
		global $db,$errors,$userManager;
		if(!empty($userID))
		{
			$user = $userManager->getUserByID($userID);
		}
		if(!empty($eventID))
		{
			$sql = "SELECT `title`,`description`,`start`,`venueID` FROM `events` WHERE `uid` = '".$eventID."' LIMIT 1";
			$result = $db->query($sql);
			if($result && $result->num_rows == 1) $event = $result->fetch_assoc();
		}
		
		$find = array(
			'{firstName}',
			'{lastName}',
			'{email}',
			'{regID}',
			'{regURL}',
			'{siteURL}',
			'{eventName}',
			'{eventInfo}',
			'{eventDate}',
			'{venueName}',
			'{venueAddress}',
			'{venueCity}',
			'{venueState}',
			'{venueZipcode}',
			'{venueCountry}',
			'{venuePhone}',
			'{venueWebsite}'
		);
		$replace = array(
			$user['firstName'],
			$user['lastName'],
			$user['email'],
			$user['regID'],
			USER_REG_URL.'?regID='.$user['regID'],
			SITE_ROOT,
			$event['title'],
			$event['description'],
			date('F jS',strtotime($event['start'])),
			$venue['name'],
			$venue['address'],
			$venue['city'],
			$venue['state'],
			$venue['zipcode'],
			$venue['country'],
			$venue['phone'],
			$venue['website']
		);
		if(is_array($extraFields))
		foreach($extraFields as $key => $value)
		{
			$find[] = $key;
			$replace[] = $value;	
		}
		
		return str_replace($find,$replace,$text);
	}
	
	function prepareMessage($text,$guestID = 0,$eventID = 0,$extraFields = array())
	{
		$event = array();
		$guest = array();
		$guestID = intval($guestID);
		$eventID = intval($eventID);
		
		global $db,$errors,$guestManager;
		if(!empty($guestID))
		{
			$guest = $guestManager->getGuestByID($guestID);
		}
		if(!empty($eventID))
		{
			$sql = "SELECT `title`,`description`,`start`,`venueID` FROM `events` WHERE `uid` = '".$eventID."' LIMIT 1";
			$result = $db->query($sql);
			if($result && $result->num_rows == 1) $event = $result->fetch_assoc();
		}
		if(!empty($event['venueID']))
		{
			$sql = "SELECT `uid`, `name`, `address`, `address2`, `city`, `state`, `zipcode`, `country`, `phone`, `website` FROM `venues` WHERE `uid` = '".$event['venueID']."' LIMIT 1";
			$result = $db->query($sql);
			if($result) $venue = $result->fetch_assoc();
		}
		
		$find = array(
			'{firstName}',
			'{lastName}',
			'{email}',
			'{mobile}',
			'{regID}',
			'{regURL}',
			'{guestNotes}',
			'{eventName}',
			'{eventInfo}',
			'{eventDate}',
			'{venueName}',
			'{venueAddress}',
			'{venueCity}',
			'{venueState}',
			'{venueZipcode}',
			'{venueCountry}',
			'{venuePhone}',
			'{venueWebsite}'
		);
		$replace = array(
			$guest['firstName'],
			$guest['lastName'],
			$guest['email'],
			$guest['mobile'],
			$guest['regID'],
			GUEST_REG_URL.'?invite='.$guest['regID'],
			$guest['notes'],
			$event['title'],
			$event['description'],
			date('F jS',strtotime($event['start'])),
			$venue['name'],
			$venue['address'],
			$venue['city'],
			$venue['state'],
			$venue['zipcode'],
			$venue['country'],
			$venue['phone'],
			$venue['website']
		);
		if(is_array($extraFields))
		foreach($extraFields as $key => $value)
		{
			$find[] = $key;
			$replace[] = $value;	
		}
		
		return str_replace($find,$replace,$text);
	}
}

?>