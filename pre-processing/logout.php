<?php
if(isset($_SESSION['user']))
{
	session_unset();
	$errors[] = array('type'=>'success','msg'=>'You have been successfully logged out.');
}
include_once(dirname(__FILE__) . '/login.php');