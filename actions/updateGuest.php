<?php
require_once('../includes/startup.php');
$output = array(
	'result' => '0',
	'msg'	 => 'Missing required data.'
);

if(isset($_SESSION['user'],$_POST['guestID'],$_POST['guest']) && !empty($_POST['guestID']))
{	
	$sql = "UPDATE `guests` SET ";
	$next = false;
	foreach($_POST['guest'] as $key => $value)
	{
		if(is_array($value)) $value = json_encode($value);
		
		if($next) $sql .= ", ";
		$sql .= "`" . $db->real_escape_string($key) . "` = '" . $db->real_escape_string($value) . "'";
		$next = true;
	}
	$sql .= " WHERE `uid` = '".intval($_POST['guestID'])."' LIMIT 1";
	
	if($next)
	{
		$result = $db->query($sql);
		if($result && empty($db->error))
		{
			$output = array(
				'result' => '1',
				'msg'	 => 'Update Successful.'
			);
		}else $output['msg'] = $db->error;
	}else $output['msg'] = 'No data given to update.';
	
}

echo json_encode($output);