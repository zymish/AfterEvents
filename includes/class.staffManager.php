<?php
/* class.staffManager.php
.---------------------------------------------------------------------------.
	Build By Strider Agostinelli (strider@boundlessether.com)
'---------------------------------------------------------------------------'
*/

class staffManager {
	
	function getStaffMemberByID($staffID)
	{
		global $db;
		$staffID = intval($staffID);
		$sql  = "SELECT * FROM `eventStaff` WHERE `uid` = '".$staffID."' LIMIT 2";
		$result = $db->query($sql);
		
		if(!$result || $result->num_rows != 1)
			return false;
			
		return $result->fetch_assoc();
	}
	
	function getStaffByUserID($userID,$eventID)
	{
		global $db;
		$userID = intval($userID);
		$eventID = intval($eventID);
		$sql = "SELECT * FROM `eventStaff` WHERE `userID` = '".$userID."' && `eventID` = '".$eventID."'";
		$result = $db->query($sql);
		
		if(!$result || $result->num_rows != 1)
			return false;
			
		return $result->fetch_assoc();
	}
	
	function getEventStaffByGroup($eventID,$title = 'BlackBerry BU')
	{
		global $db;
		$staff = array();
		$eventID = intval($eventID);
		
		$sql = "SELECT `eventStaff`.`uid` ,`eventStaff`.`staffInfo`,`eventStaff`.`userID` FROM `eventStaff` LEFT JOIN `eventStaffGroups` ON `eventStaff`.`staffGroupID` = `eventStaffGroups`.`uid` WHERE `eventStaff`.`eventID` = '".$eventID."' AND `userID` > '0' AND `eventStaffGroups`.`title` = '".$db->real_escape_string($title)."'";
		$result = $db->query($sql);
		
		if($result)
		while($row = $result->fetch_assoc()):
			$info = json_decode($row['staffInfo'],true);
			$staff[$row['uid']] = $info;
			$staff[$row['uid']]['userID'] = $row['userID'];
		endwhile;
		
		return $staff;
	}
	
	function addStaff($data)
	{
		global $db,$errors;
		
		if(!is_array($data)) return false;
		$data = real_escape_array($data);
		$data['eventID'] = intval($data['eventID']);
		$data['userID'] = intval($data['userID']);
		$data['staffGroupID'] = intval($data['staffGroupID']);
		
		if(empty($data['eventID']) || empty($data['staffGroupID'])) return false;
		$sql  = "INSERT INTO `eventStaff` (`eventID`,`userID`,`staffInfo`,`created`,`addedBy`,`staffGroupID`) ";
		$sql .= "VALUES('".$data['eventID']."','".$data['userID']."','".$data['staffInfo']."','".date('Y-m-d H:i:s')."','".getCurrentUserID()."','".$data['staffGroupID']."')";
		$result = $db->query($sql);
		if($db->error)
		{
			error_log('Error on staffManager->addStaff():' . $db->error);
			return false;	
		}
		
		$this->grantEventPermissions($data['userID'],$data['eventID'],$data['staffGroupID']);
		logActivity(getCurrentUserID(true),$data['eventID'],'New Staff Member Added','newStaff',"SQL: ".$sql);
		return true;
	}
	
	function editStaff($staffID,$data)
	{
		global $db,$errors;
		
		if(!is_array($data) || sizeof($data) < 1) return false;
		
		$staffID = intval($staffID);
		if(empty($staffID)) return false;
		
		if(isset($data['staffGroupID']))
		{
			$data['staffGroupID'] = intval($data['staffGroupID']);
			if(empty($data['staffGroupID'])) return false;
		}
		
		if(isset($data['userID']))
		{
			$data['userID'] = intval($data['userID']);
		}
		$data = real_escape_array($data);
		
		$staff = $this->getStaffMemberByID($staffID);
		if(!$staff) return false;
		
		if(isset($data['staffInfo'])) $data['staffInfo'] = json_encode(real_array_merge($staff['staffInfo'],$data['staffInfo']));
		
		$sql  = "UPDATE `eventStaff` SET ";
		if(isset($data['userID'])) $sql .= (($sql != "UPDATE `eventStaff` SET ")?", ":"")."`userID` = '".$data['userID']."' ";
		if(isset($data['staffInfo'])) $sql .= (($sql != "UPDATE `eventStaff` SET ")?", ":"")."`staffInfo` = '".$data['staffInfo']."' ";
		if(isset($data['staffGroupID'])) $sql .= (($sql != "UPDATE `eventStaff` SET ")?", ":"")."`staffGroupID` = '".$data['staffGroupID']."' ";
		if($sql == "UPDATE `eventStaff` SET ") return false;
		$sql .= " WHERE `uid` = '".$staffID."' LIMIT 1";
		$db->query($sql);
		
		logActivity(getCurrentUserID(true),$staff['eventID'],'Edit Staff','editStaff',"SQL: ".$sql);
		
		if($db->error) return false;
		return true;
	}
	
	function removeStaff($staffID)
	{
		global $db,$errors;
		$staffID = intval($staffID);
		$staff = $this->getStaffMemberByID($staffID);
		if(!$staff) return false;
		
		$sql = "DELETE FROM `eventStaff` WHERE `uid` = '".$staffID."' LIMIT 1";
		logActivity(getCurrentUserID(true),$staff['eventID'],'Remove Staff','removeStaff',"SQL: ".$sql);
		return $db->query($sql);	
	}
	
	function getUserInvitedGuests($userID,$eventID)
	{
		global $db,$errors;
		
		$userID = intval($userID);
		$eventID = intval($eventID);
		if(empty($userID) || empty($eventID)) return false;
		
		$sql  = "SELECT `guests`.`uid`, `guests`.`regID`, `guests`.`invitedBy`, `guests`.`ticketsNo`, `guests`.`firstName`, `guests`.`lastName`, `guests`.`email`, `guests`.`mobile`, `guests`.`ticketTypeID`, `guests`.`addons`, `guests`.`groupID`, `guests`.`notes`, `guests`.`responsible`, `guests`.`extraData`, `guests`.`rsvp`, ";
		$sql .= "`guestGroups`.`name` as `groupName` ";
		$sql .= " FROM `guests` LEFT JOIN `guestGroups` ON `guests`.`groupID` = `guestGroups`.`uid`";
		$sql .= " WHERE `guests`.`invitedBy` = '".$userID."' AND `guests`.`eventID` = '".$eventID."' ORDER BY `guests`.`lastName` ASC, `guests`.`firstName` ASC";
		$result = $db->query($sql);
		if($db->error)
		{
			error_log("SQL ERROR on staffManager->getUserInvitedGuests: ".$db->error);
			return false;	
		}
		return $result;
	}
	
	function grantEventPermissions($userID,$eventID,$staffGroupID)
	{
		global $db,$errors,$userManager,$eventManager;
		
		$staffGroupID = intval($staffGroupID);
		
		$user = $userManager->getUserByID($userID);
		if(!$user)
		{
			//$errors[] = array('type'=>'error','icon'=>'icon-sitemap','msg'=>'User Missing');
			return false;	
		}
		$user['permissions'] = json_decode($user['permissions'],true);
		
		$event = $eventManager->getEventByID($eventID);
		if(!$event)
		{
			//$errors[] = array('type'=>'error','icon'=>'icon-sitemap','msg'=>'Event Missing');
			return false;	
		}
		
		//Don't overwrite someone with admin permissions for events
		if(isset($user['permissions'][$event['projectID']]) && $user['permissions'][$event['projectID']] == "1" ||
			isset($user['permissions'][$event['projectID']]['events']) && $user['permissions'][$event['projectID']]['events'] == "1")
		{
			//$errors[] = array('type'=>'error','icon'=>'icon-sitemap','msg'=>'already an admin');
			return true;
		}
		
		$sql = "SELECT `defaultPermissions` FROM `eventStaffGroups` WHERE `eventID` = '".$eventID."' AND `uid` = '".$staffGroupID."'";
		$result = $db->query($sql);
		if(!$result || $result->num_rows != 1)
		{
			//$errors[] = array('type'=>'error','icon'=>'icon-sitemap','msg'=>'No Defaults');
			return false;	
		}
		
		$permissions = $result->fetch_assoc();
		
		$permissions = ($permissions['defaultPermissions'] == "1")?"1":json_decode($permissions['defaultPermissions'],true);
		$addedPerms = array(
			$event['projectID'] => array(
				"events" => array(
					"view" => "1",
					$eventID => $permissions
				)
			)
		);
		
		$user['permissions'] = real_array_merge($user['permissions'],$addedPerms);
		$data = array(
			'permissions' => json_encode($user['permissions'])
		);
		
		return $userManager->editUser($userID,$data);
	}
}
?>
