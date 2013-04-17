<?php
require_once('../includes/startup.php');

$output = array(
	'result' => '0',
	'msg' => 'Missing Required Data.'
);

if(isset($_REQUEST['staffID']) && isset($_SESSION['user']))
{
	$staffID = intval($_REQUEST['staffID']);
	$sql = "SELECT `userID` FROM `eventStaff` WHERE `uid` = '".$staffID."'";
	$result = $db->query($sql);
	if($result && $result->num_rows > 0):
		$row = $result->fetch_assoc();
		$sql = "SELECT `guests`.`uid` FROM `guests` WHERE `invitedBy` = '".$row['userID']."'";
		$result = $db->query($sql);
		if($result && $result->num_rows > 0):
			$output['msg'] = 'Cannot delete staff member who has invited guests.';
		else:
			$sql  = "DELETE FROM `eventStaff` WHERE `eventStaff`.`uid` = '".$staffID."' LIMIT 1";
			$result = $db->query($sql);
			if($result)
			$output['msg'] = 'Contact successfully removed.';
			else
			$output['msg'] = 'There was a database error. Please try again.';
		endif;
	else:
		$sql  = "DELETE FROM `eventStaff` WHERE `eventStaff`.`uid` = '".$staffID."' LIMIT 1";
		$result = $db->query($sql);
		if($result)
		$output['msg'] = 'Contact successfully removed.';
		else
		$output['msg'] = 'There was a database error. Please try again.';
	endif;
}
echo json_encode($output);