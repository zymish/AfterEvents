<?php
if(!checkPermission(array($projectID,'events',$eventID,'view'),true))
{
	$errors[] = array('type'=>'error','icon'=>'icon-lock','msg'=>'You do not have permission to view this event.');
	$site['page'][PAGE_INDEX] = PAGE_HOME;
	include_once("pre-processing/" . $site['page'][PAGE_INDEX].'.php');
	return;
}

$event = $eventManager->getEventByID($eventID);
if(is_array($event))
{
	$event = real_display_array($event);
}else $errors[] = array('type'=>'error','icon'=>'icon-hdd','msg'=>'There was a database issue. Please try again.');

if(isset($_POST['viewAs'])):
	$viewAs = intval($_POST['viewAs']);
	if(empty($viewAs) || getCurrentUserID(true) == $viewAs):
		unset($_SESSION['viewAs']);
	else:
		$user = $userManager->getUserByID($viewAs);
		if(is_array($user)):
			$_SESSION['viewAs'] = $user;
		endif;
	endif;
endif;