<?php
require_once('../includes/startup.php');

$output = array(
	'exists' => '0'
);

if(isset($_REQUEST['email']) && isset($_SESSION['user']))
{
	$email = $db->real_escape_string($_REQUEST['email']);
	$sql = "SELECT `uid`,`firstName`,`lastName`,`mobile` FROM `guests` WHERE `email` = '".$email."' LIMIT 1";
	$result = $db->query($sql);
	if($result && $result->num_rows == 1)
	{
		$guest = $result->fetch_assoc();
		$output = $guest;
		$output['exists'] = '1';
	}
}

echo json_encode($output);