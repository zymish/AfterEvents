<?php
if(isset($_SESSION['user']))
{
	$errors[] = array('type'=>'error','icon'=>'icon-lock','msg'=>'You are already registered and logged in.');
	$fill = false;
	$site['page'][PAGE_INDEX] = PAGE_HOME;
	include_once("pre-processing/" . $site['page'][PAGE_INDEX].'.php');
	return;
}
$errors = '';
$fill = true;
if(isset($_REQUEST['regID']) && !empty($_REQUEST['regID']))
{
	$regID = $db->real_escape_string($_REQUEST['regID']);
	$sql = "SELECT `uid`, `firstName`, `lastName`, `email`, `mobile`, `invitedBy` AS invitedByID, `permissions`, `status` FROM `users` WHERE  `regID` = '".$regID."'";
	$result = $db->query($sql);
	if(!$result || $result->num_rows != 1):
		$site['page'][PAGE_INDEX] = 'login';
		$errors[] = array('type'=>'error','icon'=>'icon-exclamation-point','msg'=>'Invalid Invite Code. Please make sure to follow the link in your registration email.');
		$fill = false;
	else:
		$user = $result->fetch_assoc();
		$user['permissions'] = json_decode($user['permissions'],true);
		$sqlRoot = "SELECT CONCAT(`firstName`, ' ', `lastName`) AS invitedBy FROM `users` WHERE `uid` = '".$user['invitedByID']."'";
		$inviteResult = $db->query($sqlRoot);
		if($inviteResult && $invite = $inviteResult->fetch_assoc()):
			if($user['status'] > 0):
				$errors[] = array('type'=>'error','icon'=>'icon-exclamation-point','msg'=>'It looks like you have already registered. If you have forgotten your password, click the "Forgot Password?" link on the login page and follow the on-screen instructions.');
				$fill = false;
			else:
				if($_POST['action'] == 'register'):
					if($_POST['password'] == $_POST['passConfirm'] && !empty($_POST['firstName']) && !empty($_POST['lastName']) && !empty($_POST['mobile'])):
						$data = array(
							'firstName'			=> $_POST['firstName'],
							'lastName'			=> $_POST['lastName'],
							'email'				=> $user['email'],
							'password'			=> base64_encode(base64_encode($_POST['password'])),
							'mobile'				=> $_POST['mobile'],
							'registrationIP'	=> $_SERVER['REMOTE_ADDR'],
							'registered'		=> date('Y-m-d H:i:s'),
							'status'				=> '1'
						);
						$result = $userManager->editUser($user['uid'],$data);
						if($result)
						{
							$errors[] = array('type'=>'success','icon'=>'icon-ok','msg'=>'Thank you. You can now log in to the system using your new password.');
							$site['page'][PAGE_INDEX] = 'login';
							include_once("pre-processing/" . $site['page'][PAGE_INDEX].'.php');
							return;
						}else
							$errors[] = array('type'=>'error','icon'=>'icon-hdd','msg'=>$user['uid']);
							$fill = false;
					else:
						$errors[] = array('type'=>'error','icon'=>'icon-lock','msg'=>'Passwords must match. No field can be left blank.');
					endif;
				endif;
			endif;
		else:
			$errors[] = array('type'=>'error','icon'=>'icon-exclamation-point','msg'=>'Database error; we could not find a record of the user who sent this invite code.');
			$fill = false;
		endif;
	endif;
	if($fill == true) $errors[] = array('type'=>'info','icon'=>'icon-check','msg'=>'Please confirm your registration information below. All fields are required.');
}
else
{
	$errors[] = array('type'=>'error','icon'=>'icon-exclamation-point','msg'=>'Missing registration code. Please make sure to follow the link in your registration email.');
	$site['page'][PAGE_INDEX] = 'login';
	include_once("pre-processing/" . $site['page'][PAGE_INDEX].'.php');
	return;
}
$site['css'][] = 'unicorn.login.css';
$site['css'][] = 'bbak_custom.css';
$site['js'][] = 'unicorn.login.js';
$site['pageTitle'] = 'User Registration';