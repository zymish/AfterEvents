<?php
/* class.ticketManager.php
.---------------------------------------------------------------------------.
	Build By Strider Agostinelli (strider@boundlessether.com)
'---------------------------------------------------------------------------'
*/

class ticketManager {

	function getTicketTypes($eventID)
	{
		global $db, $errors;
		
		$eventID = intval($eventID);
		$ticketTypes = array();
		
		if(!empty($eventID)):	
			$sql = "SELECT `uid`, `name`,`total`,`price`,`description` FROM `ticketTypes` WHERE `eventID` = '".$eventID."' ORDER BY `uid` ASC";
			$result = $db->query($sql);
			
			if($result)
			while($row = $result->fetch_assoc()):
				$ticketTypes[$row['uid']] = $row;
			endwhile;
		
			$sql = "SELECT `eventStaff`.`uid` ,`eventStaff`.`staffInfo` FROM `eventStaff` LEFT JOIN `eventStaffGroups` ON `eventStaff`.`staffGroupID` = `eventStaffGroups`.`uid` WHERE `eventStaff`.`eventID` = '".$eventID."' AND `userID` > '0' AND `eventStaffGroups`.`title` = 'BlackBerry BU'";
			$result = $db->query($sql);
			if($result)
			while($row = $result->fetch_assoc()):
				$info = json_decode($row['staffInfo'],true);
				
				$staff[$row['uid']] = $info;
				if(isset($info['tickets']) && is_array($info['tickets']))
				foreach($info['tickets'] as $ticketID => $num)
				{	
					$ticketTypes[$ticketID]['assigned'] += $num;
				}
			endwhile;
		endif;
		return real_display_array($ticketTypes);
	}
	
	
	function newTicketType($data)
	{
		global $db, $errors;
		$data['eventID'] = intval($data['eventID']);
		
		if(empty($data['eventID'])) return false;
		$data = real_escape_array($data);
		
		$sql  = "INSERT INTO `ticketTypes` (`eventID`,`name`,`description`,`price`,`total`) ";
		$sql .= "VALUES ('".$data['eventID']."','".$data['name']."','".$data['description']."','".$data['price']."','".$data['total']."')";
		logActivity(getCurrentUserID(true),$data['eventID'],'New Ticket Type','newTicketType',"SQL: ".$sql);
		return $db->query($sql);
	}
	
	function editTicketType($ticketID,$data)
	{
		global $db, $errors;
		$data['eventID'] = intval($data['eventID']);
		$ticketID = intval($ticketID);
		
		if(empty($data['eventID']) || empty($ticketID)) return false;
		$data = real_escape_array($data);
		
		$sql  = "UPDATE `ticketTypes` SET ";
		if(isset($data['name'])) $sql .= (($sql != "UPDATE `ticketTypes` SET ")?", ":"")."`name` = '".$data['name']."' ";
		if(isset($data['description'])) $sql .= (($sql != "UPDATE `ticketTypes` SET ")?", ":"")."`description` = '".$data['description']."' ";
		if(isset($data['price'])) $sql .= (($sql != "UPDATE `ticketTypes` SET ")?", ":"")."`price` = '".$data['price']."' ";
		if(isset($data['total'])) $sql .= (($sql != "UPDATE `ticketTypes` SET ")?", ":"")."`total` = '".$data['total']."' ";
		if($sql == "UPDATE `ticketTypes` SET ") return false;
		$sql .= " WHERE `uid` = '".$ticketID."' LIMIT 1";

		logActivity(getCurrentUserID(true),$data['eventID'],'Edit Ticket Type','editTicketType',"SQL: ".$sql);
		return $db->query($sql);
	}
	
	function getAddons($eventID)
	{
		global $db, $errors;
		
		$eventID = intval($eventID);
		$addons = array();
		
		if(!empty($eventID))
		{	
			$sql = "SELECT `uid`, `name`, `price` FROM `addonTypes` WHERE `eventID` = '".$eventID."' ORDER BY `uid` ASC";
			$result = $db->query($sql);
			
			if($result)
			while($row = $result->fetch_assoc()):
				$addons[$row['uid']] = $row;
			endwhile;
		}
		return real_display_array($addons);
	}
	function newAddonType($data)
	{
		global $db, $errors;
		$data['eventID'] = intval($data['eventID']);
		
		if(empty($data['eventID'])) return false;
		$data = real_escape_array($data);
		
		$sql  = "INSERT INTO `addonTypes` (`eventID`,`name`,`description`,`price`,`slug`) ";
		$sql .= "VALUES ('".$data['eventID']."','".$data['name']."','".$data['description']."','".$data['price']."','".$data['slug']."')";
		logActivity(getCurrentUserID(true),$data['eventID'],'New Addon Type','newAddonType',"SQL: ".$sql);
		$result = $db->query($sql);
		if($db->error){
			error_log($db->error);
			return false;
		}
		return true;
	}
}
?>
