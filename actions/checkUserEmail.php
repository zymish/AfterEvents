<?php
require_once('../includes/startup.php');

$output = array(
	'result' => '0',
	'msg' => 'Missing Required Data.'
);

if(isset($_REQUEST['email']) && isset($_SESSION['user']))
{
	$output['result'] = '1';
	$email = $db->real_escape_string($_REQUEST['email']);
	$sql = "SELECT `uid`,`firstName`,`lastName`,`mobile` FROM `users` WHERE `email` = '".$email."' LIMIT 1";
	$result = $db->query($sql);
	if($result && $result->num_rows == 1)
	{
		$user = $result->fetch_assoc();
		$output = $user;
		$output['result'] = '1';
		$output['exists'] = '1';	
	}else $output['exists'] = '0';
}

echo json_encode($output);