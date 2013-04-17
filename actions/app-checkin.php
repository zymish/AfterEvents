<?php
require_once('app-authConnect.php');
if($output['result'] == '0')
{
	echo json_encode($output);
	return;
}

$sql = "SELECT `uid`,`projectID`,`title`,`start` FROM `events` WHERE `appID` = '".$db->real_escape_string($_REQUEST['appID'])."'";
$result = $db->query($sql);
if($result && $result->num_rows == 1)
{
	$event = $result->fetch_assoc();
	$output['event'] = $event;
	
	$count = 0;
	$output['checkins'] = array();
	$checkins = json_decode($_REQUEST['checkins'],true);
	
	if(is_array($checkins))
	foreach($checkins as $i => $guestID)
	{
		$guestID = intval($guestID);
		if(empty($guestID))
		{
			$output['checkins'][$i] = array('result'=>'0','msg'=>'Missing or invalid guestID');
			continue;
		}
		$sql = "SELECT `eventID`, `ticketTypeID`, `checkins` FROM `guests` WHERE `uid` = '".$guestID."' LIMIT 2";
		$result = $db->query($sql);
		if($result && $result->num_rows == 1)
		{
			$output['checkins'][$i]['guestID'] = $guestID;
			$guest = $result->fetch_assoc();
			
			if($guest['eventID'] != $event['uid'])
			{
				$output['checkins'][$i]['result'] = '0';
				$output['checkins'][$i]['eventID'] = $guest['eventID'];
				$output['checkins'][$i]['msg'] = 'Guest does not match this event.';
				continue;
			}
			
			$guest['checkins']++;
			
			$sql  = "INSERT INTO `guestCheckins` (`guestID`,`ticketTypeID`,`timestamp`,`checkedInBy`) VALUES ";
			$sql .= "('".$guestID."','".$guest['ticketTypeID']."',NOW(),'".$user['uid']."')";
			$db->query($sql);
			if($db->error)
			{
				error_log("There was an SQL error from this query:\n".$sql."\nMySQL Said:".$db->error);
				$output['checkins'][$i]['result'] = '0';
				$output['checkins'][$i]['msg'] = 'There was a Database error.  Most likely the guest was removed.';
				continue;
			}
			
			$sql = "UPDATE `guests` SET `checkins` = '".$guest['checkins']."' WHERE `uid` = '".$guestID."' LIMIT 1";
			$db->query($sql);
			if($db->error)
			{
				error_log("There was an SQL error from this query:\n".$sql."\nMySQL Said:".$db->error);
				$output['checkins'][$i]['result'] = '0';
				$output['checkins'][$i]['msg'] = 'There was a Database error.  Most likely the guest was removed.';
				continue;
			}else{
				$output['checkins'][$i]['result'] = '1';
				$output['checkins'][$i]['checkins'] = $guest['checkins'];
			}
			
		}else $output['checkins'][$i] = array('result'=>'0','msg'=>'Unable to find guest.','guestID'=>$guestID);
	}
	
}else $output['msg'] =  'Invalid AppID.';
				
echo json_encode($output);
