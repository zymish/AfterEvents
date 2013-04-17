<?php
require_once('../includes/startup.php');

$output = array(
	'result' => '0'
);
$valid = false;
if(isset($_REQUEST,$_REQUEST['username'],$_REQUEST['password']) || isset($_REQUEST,$_REQUEST['authToken']))
{
	if(isset($_REQUEST['authToken']))
	{
		$auth = base64_decode($_REQUEST['authToken']);
		$auth = explode(';',$auth);
		$sql  = "SELECT `uid`, `firstName`, `permissions`, `status`,`created`,`password` FROM `users` ";
		$sql .= "WHERE `uid` = '".intval($auth[0])."' AND `password` = '".base64_decode($auth[2])."' AND `created` = '".$db->real_escape_string($auth[1])."'";
	}else{
		$sql  = "SELECT `uid`, `firstName`, `permissions`, `status`,`created`,`password` FROM `users` ";
		$sql .= "WHERE `email` = '".$db->real_escape_string($_REQUEST['username'])."' AND `password` = '".base64_encode(base64_encode($db->real_escape_string($_REQUEST['password'])))."'";
	}
	$result = $db->query($sql);
	if($result && $result->num_rows == 1)
	{
		$valid = true;
		$user = $result->fetch_assoc();
		if(isset($user['uid'],$user['firstName'],$user['permissions'],$user['status']) && !empty($user['uid']) && !empty($user['firstName']))
		{
			if($user['status'] == '0')
				$output['msg'] = 'Your account is not active yet.  Please check your email for instructions on activating your account.  If you no longer have your activation email, you can use the lost password link below to have it resent to you.';
			else
			{
				$user['permissions'] = json_decode($user['permissions'],true);
				if(is_array($user['permissions']) && sizeof($user['permissions']) > 0)
				{
					$output['authToken'] = base64_encode($user['uid'].";".$user['created'].";".base64_encode($user['password']));
					$output['result'] = 1;
				}
				else $output['msg'] =  'There was an issue loading your permissions.  The system tried to correct it automaticly, but was unable to do so.  The system administrators have already been alerted to this issue and will investigate this ASAP.';
			}
		}
	}
}
if(!$valid) $output['msg'] = 'Invalid username and/or password';