<?php
/* class.userManager.php
.---------------------------------------------------------------------------.
	Build By Strider Agostinelli (strider@boundlessether.com)
'---------------------------------------------------------------------------'
*/

class userManager
{
	function getUserByID($userID)
	{
		global $db,$errors;
		$sql = "SELECT `uid`,`firstName`, `lastName`, `email`, `permissions`, `mobile`, `regID`, `status`, `invitedBy` FROM `users` WHERE `uid` = '".intval($userID)."' LIMIT 2";
		$result = $db->query($sql);
		if($db->error)
		{
			$errors[] = array('type'=>'error','icon'=>'icon-sitemap','msg'=>$db->error);
			return false;	
		}
		
		if($result && $result->num_rows == 1):
			$user = $result->fetch_assoc();
			$user['permissions'] = json_decode($user['permissions'],true);
			return $user;
		endif;
		return false;
	}
	function getUserByRegID($regID)
	{
		global $db;
		$sql = "SELECT `uid`, `firstName`, `lastName`, `email`, `permissions`, `mobile`, `status`, `invitedBy` FROM `users` WHERE `regID` = '".$regID."' LIMIT 2";
		$result = $db->query($sql);
		if($result && $result->num_rows == 1) return $result;
		else return false;
	}
	function generateUniqueRegID()
	{
		global $db;
		$i = 4;
		$regID = '';
		do
		{
			if(!empty($regID)) $i++;
			$regID = randString(rand($i,$i+5));
			$sql = "SELECT `regID` FROM `users` WHERE `regID` = '".$db->real_escape_string($regID)."'";
			$result = $db->query($sql);
		}while($result && $result->num_rows > 0);
		return $regID;
	}
	function editUser($userID,$data)
	{
		global $db,$errors;
		//Check Data
		$userID = intval($userID);
		if(!is_array($data) || empty($userID))
			return false;
		
		$user = $this->getUserByID($userID);
		if(!$user) return false;
		
		$data = real_escape_array($data);
		$sql  = "UPDATE `users` SET ";
		
		$i = 0;
		foreach($data as $field => $value):
			$sql .= (($i++ > 0)?",":"")."`".$field."` = '".$value."'";
		endforeach;
		
		$sql .= " WHERE `uid` = '".$userID."' LIMIT 1";
		$result = $db->query($sql);
		logActivity($userID,0,'Edit User','editUser',"SQL: ".$sql);
		if($db->error)
		{
			error_log($db->error);
			return false;
		}
		return true;
	}
	function inviteUser($data)
	{
		global $db,$errors;
		//Check Data
		$data['invitedBy'] = intval(getCurrentUserID());
		
		if(empty($data['email']))
		{
			$errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>'Email missing. '.$data['firstName'].' '.$data['lastName'].' was not added.');
			return false;
		}
		if(empty($data['invitedBy']))
		{
			$errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>'Invalid invitedBy data.');
			return false;
		}

		$data = real_escape_array($data);
		
		$regID = $this->generateUniqueRegID();
		
		$sql  = "INSERT INTO `users` (`invitedBy`,`regID`,`firstName`,`lastName`,`email`,`mobile`,`created`)";
		$sql .= "VALUES('".$data['invitedBy']."','".$regID."',";
		$sql .= "'".$data['firstName']."','".$data['lastName']."',";
		$sql .= "'".$data['email']."','".$data['mobile']."',";
		$sql .= "NOW())";
		logActivity(getCurrentUserID(true),0,'Invite User','inviteUser',"SQL: ".$sql);
		$result = $db->query($sql);
		if($db->error)
		{
			$errors[] = array('type'=>'error','icon'=>'icon-hdd','msg'=>'There was a database error');
			error_log("SQL Error on invite User: ".$db->error);
			return false;
		}
		$userID = $db->insert_id;
		
		$sql = "SELECT `uid`,`subject`,`body`,`images` FROM `messagesTemplates` WHERE `projectID` = '1' AND `msgType` = 'userReg' LIMIT 1";
		$result = $db->query($sql);
		if($result && $template = $result->fetch_assoc())
		{
			global $messageManager;
			$subject = $messageManager->prepareUserMessage($template['subject'],$userID,$data['eventID']);
			$body = $messageManager->prepareUserMessage($template['body'],$userID,$data['eventID'],array('{subject}'=>$subject));
			$messageManager->send_email($data['firstName']." ".$data['lastName'], $data['email'], $subject, $body,$template['images']);
		}
		if($db->error) error_log($db->error);
		
		return $userID;
	}
}
?>