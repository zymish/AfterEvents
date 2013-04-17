<?php
if(isset($_SESSION['user']))
{
	$site['page'][PAGE_INDEX] = PAGE_HOME;
	include_once("pre-processing/". $site['page'][PAGE_INDEX].'.php');
	return;
}

if(isset($_POST,$_POST['action']))
{
	if($_POST['action'] == 'login')
	{
		$valid = false;
		$sql  = "SELECT `uid`, `firstName`, `lastName`, CONCAT(`firstName`,' ',`lastName`) as `name`, `email`, `permissions`, `status` FROM `users` ";
		$sql .= "WHERE `email` = '".$db->real_escape_string($_POST['username'])."' AND `password` = '".base64_encode(base64_encode($db->real_escape_string($_POST['password'])))."'";
		
		$result = $db->query($sql);
		if($result && $result->num_rows == 1)
		{
			$valid = true;
			$user = $result->fetch_assoc();
			if(isset($user['uid'],$user['firstName'],$user['permissions'],$user['status']) && !empty($user['uid']) && !empty($user['firstName']))
			{
				if($user['status'] == '0')
				{
					$errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>'Your account is not active yet. Please check your email for instructions on activating your account. If you no longer have your activation email, you can use the lost password link below to have it resent to you.');
				}
				else
				{
					$user['permissions'] = json_decode($user['permissions'],true);
					if(is_array($user['permissions']) && sizeof($user['permissions']) > 0)
						$_SESSION['user'] = $user;
					else
					{
						$errors[] = array('type'=>'warning','icon'=>'icon-question-sign','msg'=>'There was an issue loading your permissions. The system tried to correct it automatically, but was unable to do so. The system administrators have already been alerted to this issue and will investigate it as soon as possible.');
					}
				}
				$sqlRoot = "UPDATE `users` SET `lastLogin` = '".date('Y-m-d H:i:s')."', `lastIP` = '".$_SERVER['REMOTE_ADDR']."' WHERE `email` = '".$_POST['username']."' LIMIT 1";
				$updateLogin = $db->query($sqlRoot);
				if(!$updateLogin) $errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>$db->error);
				
				logActivity($user['uid'],0,'User Login','userLogin',"");

			}
		}
		
		if(!$valid)
			$errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>'Invalid username and/or password.');
	}
	else if($_POST['action'] == 'recoverPassword')
	{
		$newPass = randString(rand(4,9));
		$sql = "UPDATE `users` SET `password` = '".base64_encode(base64_encode($newPass))."' WHERE `email` = '".$_POST['email']."'";
		$result = $db->query($sql);
		
		$sqlRoot = "SELECT `uid`, `firstName`, `lastName` FROM `users` WHERE `email` = '".$_POST['email']."'";
		$userResult = $db->query($sqlRoot);
		if($userResult && $userResult->num_rows == 1)
		{
			$data = $userResult->fetch_assoc();
			$sql = "SELECT `uid`,`subject`,`body` FROM `messagesTemplates` WHERE `msgType` = 'passReset' LIMIT 1";
			$result = $db->query($sql);
			if($result && $template = $result->fetch_assoc()):
				$subject = $messageManager->prepareRecoveryMessage($template['subject'],$data['uid']);
				$body = $messageManager->prepareRecoveryMessage($template['body'],$data['uid']);
				$messageManager->send_email($data['firstName']." ".$data['lastName'],$_POST['email'],$subject,$body);
				$errors[] = array('type'=>'warning','icon'=>'icon-envelope','msg'=>'You have been sent an email with instructions on how to reset your password. It may take up to 10 minutes for you to recieve your email.');
			else:
				$errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>'There was an error sending the password recovery email. Please try again. If this problem persists, please contact a site administrator.');
			endif;
			if($db->error) error_log($db->error);
		} else {
			$errors[] = array('type'=>'error','icon'=>'icon-exclamation-sign','msg'=>'The email address you entered could not be found in the database. Please be sure you typed it correctly.');
		}
	}
}
if(isset($_SESSION['user']))
{
	$site['page'][PAGE_INDEX] = PAGE_HOME;
	include_once("pre-processing/". $site['page'][PAGE_INDEX].'.php');
	return;	
}
$site['css'][] = 'unicorn.login.css';
$site['js'][] = 'unicorn.login.js';
$site['pageTitle'] = 'User Login';