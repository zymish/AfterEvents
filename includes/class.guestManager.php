<?php
/* class.guestManager.php
.---------------------------------------------------------------------------.
	Build By Strider Agostinelli (strider@boundlessether.com)
'---------------------------------------------------------------------------'
*/

class guestManager {

	function generateUID()
	{
		global $db;
		$i = 4;
		$regID = '';
		do
		{
			if(!empty($regID)) $i++;
			$regID = randString(rand($i,$i+5));
			
			$sql = "SELECT `regID` FROM `guests` WHERE `regID` = '".$db->real_escape_string($regID)."'";
			$result = $db->query($sql);
		}while($result && $result->num_rows > 0);
		return $regID;
	}
	
	function getGuestGroupsByUserID($userID,$eventID)
	{
		global $db;
		$userID = intval($userID);
		$eventID = intval($eventID);
		
		$groups = array();
		$sql = "SELECT * FROM `guestGroups` WHERE `eventID` = '".$eventID."' AND `createdBy` = '".$userID."' ORDER BY `name` ASC";
		$result = $db->query($sql);
		if($result)
		while($row = $result->fetch_assoc())
			$groups[] = $row;
			
		return $groups;
	}
	
	function getGuestByRegID($regID)
	{
		global $db;
		$sql = "SELECT `uid` FROM `guests` WHERE `regID` = '".$regID."'";
		$result = $db->query($sql);
		if($result && $result->num_rows == 1) :
			$guest = $result->fetch_assoc();
			return $this->getGuestByID($guest['uid']);
		endif;
		return false;
	}

	function getGuestByID($guestID,$getGroup = false)
	{
		global $db,$errors;
		
		$guestID = intval($guestID);
		if(empty($guestID)) return false;
		
		$sql  = "SELECT `guests`.`uid` as `guestID`, `guests`.`regID`, `guests`.`eventID`, `guests`.`ticketsNo`, `guests`.`invitedBy` as `invitedByID`, `guests`.`firstName`, `guests`.`lastName`, `guests`.`email`, `guests`.`mobile`, `guests`.`responsible`, `guests`.`ticketTypeID`, `guests`.`addons`, `guests`.`notes`, `guests`.`extraData`, `guests`.`rsvp`, ";
		// $sql .= "`guests`.`groupID`, ";
		$sql .= "CONCAT(`users`.`firstName`,' ',`users`.`lastName`) AS `invitedBy`, `users`.`email` as invitedEmail, `ticketTypes`.`name` as `ticketType`, ";
		$sql .= "`events`.`title` AS `eventName`";
		// $sql .= ", `guestGroups`.`name` as `groupName`";
		$sql .= " FROM `guests` LEFT JOIN `users` ON `guests`.`invitedBy` = `users`.`uid` ";
		$sql .= "LEFT JOIN `ticketTypes` ON `guests`.`ticketTypeID` = `ticketTypes`.`uid` ";
		$sql .= "LEFT JOIN `events` on `events`.`uid` = `guests`.`eventID` ";
		// $sql .= "LEFT JOIN `guestGroups` on `guests`.`groupID` = `guestGroups`.`uid` ";
		$sql .= "WHERE `guests`.`uid` = '".$guestID."' LIMIT 2";
		
		$result = $db->query($sql);
		if($result && $result->num_rows == 1) $guest = $result->fetch_assoc();	
		else return false;
		
		$guest['addons'] = json_decode($guest['addons'],true);
		$guest['extraData'] = json_decode($guest['extraData'],true);
		real_display_array($guest);
		
		if($getGroup)
		{
			
		}
		return $guest;
	}
	function inviteNewGuest($data,$noEmail = false)
	{
		global $db,$errors;
		//Check Data
		if(!is_array($data) || !isset($data['eventID'],$data['invitedBy']))
		{
			$errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>'Missing required data.');
			return false;	
		}
		$data['eventID'] = intval($data['eventID']);
		$data['invitedBy'] = intval($data['invitedBy']);
		$data['ticketTypeID'] = intval($data['ticketTypeID']);
		$data['ticketsNo'] = intval($data['ticketsNo']);
		$data['email'] = emailStrip($data['email']);
		
		if(empty($data['email']))
		{
			$errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>'Email Missing. '.$data['firstName'].' '.$data['lastName'].' was not added.');
			return false;
		}
		if(empty($data['eventID']))
		{
			$errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>'Invalid event data.');
			return false;
		}
		if(empty($data['invitedBy']))
		{
			$errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>'Invalid invitedBy data.');
			return false;
		}
		if(empty($data['ticketsNo']))
		{
			$data['ticketsNo'] = 1;
		}
		
		$sql = "SELECT `staffInfo` FROM `eventStaff` WHERE `userID` = '".$data['invitedBy']."' AND `eventID` = '".$data['eventID']."' LIMIT 2";
		$result = $db->query($sql);
		
		if(!$result || $result->num_rows != 1)
		{
			$errors[] = array('type'=>'error','icon'=>'icon-user','msg'=>'You are not a staff member for this event.');
			return false;
		}
		$staffInfo = $result->fetch_assoc();
		$staffInfo = json_decode($staffInfo['staffInfo'],true);
		
		
		if(!empty($data['ticketTypeID']))
		{
			$hasTickets = false;
			$sql = "SELECT SUM( `ticketsNo` ) AS `used` FROM `guests` WHERE `eventID` = '".$data['eventID']."' AND `invitedBy` = '".$data['invitedBy']."' AND `ticketTypeID` = '".$data['ticketTypeID']."'";
			$result = $db->query($sql);
			if($result)
			{
				$row = $result->fetch_assoc();
				
				if(isset($staffInfo['tickets'],$staffInfo['tickets'][$data['ticketTypeID']]))
					if($staffInfo['tickets'][$data['ticketTypeID']] - $row['used'] >= $data['ticketsNo'])
						$hasTickets = true;
						
			}
			if(!$hasTickets){
				$errors[] = array('type'=>'warning','icon'=>'icon-film','msg'=>'You have none of this ticket type left.');
				return false;	
			}
		}
		
		$addons = array();
		$extraData = array();
		
		if($data['hospitality'] == '1'){
			$addons['hospitality'] = '1';
			
			$hasTickets = false;
			$sql = "SELECT `addons`,`ticketsNo` FROM `guests` WHERE `eventID` = '".$data['eventID']."' AND `invitedBy` = '".intval(getCurrentUserID())."'";
	
			$result = $db->query($sql);
			if($result)
			while($row = $result->fetch_assoc())
			{
				$row = json_decode($row['addons'],true);
				if(is_array($row))
				foreach($row as $key => $value)
					$staffInfo['addons'][$key] -= (!empty($value))?$row['ticketsNo']:0;
			}
			
			if(isset($staffInfo['addons'],$staffInfo['addons']['hospitality']))
				if($staffInfo['addons']['hospitality'] >= $data['ticketsNo'])
					$hasTickets = true;
					
			if(!$hasTickets){
				$errors[] = array('type'=>'warning','icon'=>'icon-film','msg'=>'You have no hospitality packages left.');
				return false;	
			}
		}
		if(!empty($data['company'])) $extraData['company'] = $data['company'];
		
		$data['addons'] = json_encode($addons);
		$data['extraData'] = json_encode($extraData);
		$data = real_escape_array($data);
		
		$i = 4;
		$regID = '';
		do
		{
			if(!empty($regID)) $i++;
			$regID = randString(rand($i,$i+5));
			
			$sql = "SELECT `regID` FROM `guests` WHERE `regID` = '".$db->real_escape_string($regID)."'";
			$result = $db->query($sql);
		}while($result && $result->num_rows > 0);
		
		$sql  = "INSERT INTO `guests` (`eventID`, `invitedBy`, `regID`, `firstName`, `lastName`, `email`, `mobile`,";
		if($data['rsvp'] == '1'):
			$sql .= "`rsvp`,";
		endif;
		$sql .= " `ticketTypeID`, `ticketsNo`, `addons`, `responsible`, `extraData`, `created`, `notes`)";
		$sql .= "VALUES('".$data['eventID']."','".$data['invitedBy']."','".$regID."',";
		$sql .= "'".$data['firstName']."','".$data['lastName']."',";
		$sql .= "'".$data['email']."','".$data['mobile']."',";
		if($data['rsvp'] == '1'):
			$sql .= "'".$data['rsvp']."',";
		endif;
		$sql .= "'".$data['ticketTypeID']."','".$data['ticketsNo']."','".$data['addons']."','".$data['responsible']."','".$data['extraData']."',";
		$sql .= "NOW(),'".$data['notes']."')";
		
		$result = $db->query($sql);
		if($db->error)
		{
			$errors[] = array('type'=>'error','icon'=>'icon-hdd','msg'=>$db->error);
			return false;
		}
		$guestID = $db->insert_id;
		
		if(!$noEmail)
		{
			$sql = "SELECT `uid`,`subject`,`body`,`images` FROM `messagesTemplates` WHERE `projectID` = '1' AND `msgType` = 'guestInvite' LIMIT 1";
			$result = $db->query($sql);
			if($result && $template = $result->fetch_assoc())
			{
				global $messageManager;
				$subject = $messageManager->prepareMessage($template['subject'],$guestID,$data['eventID']);
				$body = $messageManager->prepareMessage($template['body'],$guestID,$data['eventID'],array('{subject}'=>$subject));
				$messageManager->send_email($data['firstName']." ".$data['lastName'], $data['email'], $subject, $body,$template['images']);
			}
			if($db->error) error_log($db->error);
		}
		return $guestID;
	}
	function createNewGuestGroup($data)
	{
		global $db,$errors;
		//Check Data
		if(!is_array($data) || !isset($data['eventID'],$data['createdBy'],$data['name']))
		{
			$errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>'Missing required data.');
			return false;	
		}
		$data['eventID'] = intval($data['eventID']);
		$data['createdBy'] = intval($data['createdBy']);
		$data = real_escape_array($data);
		
		if(empty($data['eventID']))
		{
			$errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>'Invalid event data.');
			return false;
		}
		if(empty($data['createdBy']))
		{
			$errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>'Invalid invitedBy data.');
			return false;
		}
		// if(empty($data['name']))
		// {
			// $errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>'New group name is missing.');
			// return false;
		// }
		
		// $sql = "SELECT `uid` FROM `guestGroups` WHERE `eventID` = '".$data['eventID']."' AND `createdBy` = '".$data['createdBy']."' AND `name` = '".$data['name']."'";
		// $result = $db->query($sql);
		
		// if($result && $result->num_rows != 0)
		// {
			// $row = $result->fetch_assoc();
			// return $row['uid'];
		// }
		
		// $sql = "INSERT INTO `guestGroups` (`eventID`,`createdBy`,`name`)VALUES('".$data['eventID']."','".$data['createdBy']."','".$data['name']."')";
		// $result = $db->query($sql);
		// if($db->error)
		// {
			// $errors[] = array('type'=>'error','icon'=>'icon-hdd','msg'=>$db->error);
			// return false;
		// }
		// return $db->insert_id;
	}
	function editGuest($guestID,$data)
	{
		global $db,$errors;
		//Check Data
		$guestID = intval($guestID);
		if(!is_array($data) || empty($guestID))
			return false;
		
		$guest = $this->getGuestByID($guestID);
		if(!$guest) return false;
		
		if(isset($data['extraData']))
		{
			if(is_array($data['extraData']) && is_array($guest['extraData']))
				$data['extraData'] = real_array_merge($guest['extraData'],$data['extraData']);
			$data['extraData'] = json_encode($data['extraData']);
		}
		if(isset($data['addons']))
		{
			if(is_array($data['addons']) && is_array($guest['addons']))
				$data['addons'] = real_array_merge($guest['addons'],$data['addons']);
			
			$data['addons'] = json_encode($data['addons']);
		}
		
		if(isset($data['email']))$data['email'] = emailStrip($data['email']);
		$data = real_escape_array($data);
		$sql  = "UPDATE `guests` SET ";
		
		$i = 0;
		foreach($data as $field => $value):
			$sql .= (($i++ > 0)?",":"")."`".$field."` = '".$value."'";
		endforeach;
		
		$sql .= " WHERE `uid` = '".$guestID."' LIMIT 1";
		logActivity(getCurrentUserID(true),$guest['eventID'],'Edit Guest','editGuest',"SQL: ".$sql);
		$result = $db->query($sql);
		if($db->error)
		{
			$errors[] = array('type'=>'error','icon'=>'icon-hdd','msg'=>$db->error);
			error_log($db->error);
			return false;
		}
		
		return true;
	}
	function removeGuest($guestID)
	{
		global $db,$errors;
		//Check Data
		$guestID = intval($guestID);
		if(empty($guestID))
			return false;
		
		$guest = $this->getGuestByID($guestID);
		if(!$guest) return false;	
		
		$sql = "DELETE FROM `guests` WHERE `uid` = '".$guestID."' LIMIT 1";
		logActivity(getCurrentUserID(true),$guest['eventID'],'Remove Guest','removeGuest',"SQL: ".$sql."\n\nGuestData: ".print_r($guest,true));
		$result = $db->query($sql);
		if($db->error)
		{
			error_log($db->error);
			return false;
		}
		
		return true;
	}
}
?>
