<?php 
if(!isset($_SESSION['user'])){
	include('login.php');
}else{
	$site['pageTitle'] = 'BlackBerry';
}