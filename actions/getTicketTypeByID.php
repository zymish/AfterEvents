<?php
require_once('../includes/startup.php');

$output = array(
	'result' => '0',
	'msg'	=> 'Unknown Ticket Type'
);

if(isset($_REQUEST['typeID']) && isset($_SESSION['user']))
{	
	$typeID = intval($_REQUEST['typeID']);
	$sql = "SELECT `uid`,`name`,`description`,`total`,`price` FROM `ticketTypes` WHERE `uid` = '".$typeID."' LIMIT 1";
	$result = $db->query($sql);
	
	if($result && $result->num_rows == 1)
	{
		$output['type'] = $result->fetch_assoc();
		$output['result'] = 1;
	}
}

echo json_encode($output);