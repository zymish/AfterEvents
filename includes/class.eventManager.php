<?php
/* class.eventManager.php
.---------------------------------------------------------------------------.
	Build By Strider Agostinelli (strider@boundlessether.com)
'---------------------------------------------------------------------------'
*/

class eventManager {

	function getEventByID($eventID)
	{
		global $db, $errors;
		$eventID = intval($eventID);
		if(empty($eventID)) return false;
		
		$sql = "SELECT * FROM `events` WHERE `uid` = '".$eventID."'";
		$result = $db->query($sql);
		if($result):
			$event = $result->fetch_assoc();
			$event['extraData'] = json_decode($event['extraData'],true);
			$event['reporting'] = json_decode($event['reporting'],true);
			return $event;
		endif;
		
		return false;
	}
	
	function getEventByAppID($appID)
	{
		global $db;
		$appID = $db->real_escape_string($appID);
		if(empty($appID)) return false;
		
		$sql = "SELECT `uid` FROM `events` WHERE `appID` = '".$appID."'";
		$result = $db->query($sql);
		if($result):
			$event = $result->fetch_assoc();
			return $this->getEventByID($event['uid']);
		endif;
		
		return false;
	}
	
	function getVenueByID($venueID)
	{
		global $db, $errors;
		$eventID = intval($venueID);
		if(empty($venueID)) return false;
		
		$sql = "SELECT * FROM `venues` WHERE `uid` = '".$venueID."'";
		$result = $db->query($sql);
		if($result):
			$venue = $result->fetch_assoc();
			return $venue;
		endif;
		
		return false;
	}
}
?>
