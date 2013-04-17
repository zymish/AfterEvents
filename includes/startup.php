<?php
//Start the session if it's not set.
if(!isset($_SESSION)) session_start();
//Get and set our global configuration
require_once('config.php');
error_reporting(E_ERROR | E_WARNING | E_PARSE);
set_include_path(SITE_PATH);
setlocale(LC_MONETARY, 'en_US');

//innitialize $errors and connect to MySQL database.
global $db,$errors,$site,$messageManager,$guestManager,$ticketManager,$userManager,$staffManager,$eventManager;
$errors = array();
$db = new MySQLi(SQL_HOST,SQL_USER,SQL_PASS,SQL_DB);
if (mysqli_connect_errno()) {
    error_log(mysqli_connect_error());
	exit('<h2>There has been a database connection error. Please refresh and try again.</h2>');
}

//Setup the $site var to deal with the details for the page we're viewing
$site = array('debug' => false);
if(isset($_SESSION['user']) && $_SESSION['user']['status'] == '9')
	$site['debug'] = true;
	
//Require other PHP classes we'll be using
require_once('functions.php');
require_once('class.messageManager.php');
require_once('class.guestManager.php');
require_once('class.ticketManager.php');
require_once('class.userManager.php');
require_once('class.staffManager.php');
require_once('class.eventManager.php');
require_once('class.photoManager.php');
require_once('excel/reader.php');

$messageManager = new messageManager;
$guestManager = new guestManager;
$ticketManager = new ticketManager;
$userManager = new userManager;
$staffManager = new staffManager;
$eventManager = new eventManager;
$photoManager = new photoManager;