<?php
require_once('app-authConnect.php');
if($output['result'] == '0')
{
	echo json_encode($output);
	return;	
}

$output['result'] = 0;

$sql = "SELECT `uid`,`projectID`,`title`,`start` FROM `events` WHERE `appID` = '".$db->real_escape_string($_REQUEST['appID'])."'";
$result = $db->query($sql);
if($result && $result->num_rows == 1)
{
	$output['result'] = 1;
	$event = $result->fetch_assoc();
	$output['event'] = $event;
	
	$output['ticketTypes'] = array();
	$output['addonTypes'] = array();
	$output['invitedByList'] = array();
	
	$ticketTypes = $ticketManager->getTicketTypes($event['uid']);
	foreach($ticketTypes as $value)
	{
		if(!is_array($value))continue;
		unset($value['price'],$value['total'],$value['assigned']);
		$output['ticketTypes'][] = $value;
	}
	
	$addons = $ticketManager->getAddons($event['uid']);
	foreach($addons as $value)	
	{
		if(!is_array($value))continue;
		unset($value['price']);
		$output['addonTypes'][] = $value;
	}
	$staff = $staffManager->getEventStaffByGroup($event['uid']);
	foreach($staff as $id => $value)
	{
		if(!empty($value['businessUnit']) && is_array($value['tickets']) && sizeof($value['tickets']) > 0)
		{
			$output['invitedByList'][] = array("uid"=>$id,"name"=>$value['businessUnit']);
		}
	}
	
	$sql  = "SELECT `guests`.`uid` as `guestID`, `guests`.`firstName`, `guests`.`lastName`, `guests`.`email`, `guests`.`responsible`, `guests`.`mobile`, `guests`.`checkIns`, `guests`.`extraData`, `guests`.`ticketTypeID`, `guests`.`notes`,`guests`.`addons`, `guests`.`ticketsNo`, ";
	$sql .= " `eventStaff`.`staffInfo`, ";
	$sql .= " `ticketTypes`.`name` as `ticketType`,";
	$sql .= " `guestGroups`.`name` as `groupName`, `guests`.`groupID`";
	$sql .= " FROM `guests`";
	$sql .= " LEFT JOIN `eventStaff` ON `guests`.`invitedBy` = `eventStaff`.`userID`";
	$sql .= " LEFT JOIN `ticketTypes` ON `guests`.`ticketTypeID` = `ticketTypes`.`uid`";
	$sql .= " LEFT JOIN `guestGroups` ON `guests`.`groupID` = `guestGroups`.`uid`";
	$sql .= " WHERE `guests`.`eventID` = '".intval($event['uid'])."' AND `eventStaff`.`eventID` = '".intval($event['uid'])."' GROUP BY `guests`.`uid` ORDER BY `guests`.`lastName` ASC, `guests`.`firstName` ASC";
	$result = $db->query($sql);

	$output['guests'] = array();
	if($result)
	while($row = $result->fetch_assoc())
	{
		if($row['ticketTypeID'] == 0) $row['ticketType'] = "None";
		$row['extraData'] = json_decode($row['extraData'],true);
		$guestAddons = json_decode($row['addons'],true);
		$row['staffInfo'] = json_decode($row['staffInfo'],true);
		$row['invitedBy'] = $row['staffInfo']['businessUnit'];
		unset($row['staffInfo']);
		
		$row['hospitalityString'] = "";
		$row['addons'] = array();
		if(is_array($guestAddons))
		foreach($guestAddons as $id => $value)
		{
			if($value == "1")
			{
				$row['hospitalityString'] .= (empty($row['hospitalityString'])?"":", ") . $output['addonTypes'][$id]['name'];
				$row['addons'][] = $id;
			}
		}
		
		if(!empty($row['groupID']))
		{
			$sql  = "SELECT `uid` as `guestID`, `firstName`, `lastName`, `responsible` FROM `guests` WHERE ";
			$sql .= "`groupID` = '".$row['groupID']."' AND `eventID` = '".intval($event['uid'])."' ";
			$sql .= "ORDER BY `guests`.`lastName` ASC, `guests`.`firstName` ASC";
			$result2 = $db->query($sql);
			if($result2 && $result2->num_rows >= 2)
			{
				$row['group'] = array();
				while($row2 = $result2->fetch_assoc())
				{
					$row['group'][] = $row2;
				}
			}
		}
		$output['guests'][] = $row;
	}
	if($db->error)error_log($db->error);
}else $output['msg'] =  'Invalid AppID.';

echo json_encode($output);