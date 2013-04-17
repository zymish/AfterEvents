<?php
require_once("includes/startup.php");

/* - - - - - - - - - - - 
		Page Finding
 - - - - - - - - - - - - */

$site['page'] = explode('/',substr($_SERVER['REQUEST_URI'],1));
//Current Page
if(sizeof($site['page']) < PAGE_INDEX + 1 || empty($site['page'][PAGE_INDEX]))
	$site['page'][PAGE_INDEX] = PAGE_HOME;
//Current Project
if(sizeof($site['page']) < PROJECT_INDEX + 1 || empty($site['page'][PROJECT_INDEX]))
	$site['page'][PROJECT_INDEX] = PROJECT_DEFAULT;
//Fix Links
foreach($site['page'] as $key => $value)
	$site['page'][$key] = str_replace('.','/',$value);

global $projectID, $eventID;
$projectID = (isset($site['page'][PROJECT_INDEX]))?intval($site['page'][PROJECT_INDEX]):0;
$eventID = (isset($site['page'][EVENT_INDEX]))?intval($site['page'][EVENT_INDEX]):0;

if(empty($eventID)) unset($_SESSION['viewAs']);

/* - - - - - - - - - - - 
		Is Logged in?
 - - - - - - - - - - - - */
if(!isset($_SESSION['user']) && $site['page'][PAGE_INDEX] != 'user-reg')
	$site['page'][PAGE_INDEX] = 'login';
/* - - - - - - - - - - - 
		CSS Scripts
 - - - - - - - - - - - - */
$site['css'] = array();

$site['css'][] = 'bootstrap.min.css';
$site['css'][] = 'bootstrap-responsive.min.css';
$site['css'][] = 'font-awesome.min.css';
$site['css'][] = 'font-awesome-ie7.min.css';
$site['css'][] = 'unicorn.main.css';
$site['css'][] = 'unicorn.grey.css';
$site['css'][] = 'select2.css';
$site['css'][] = 'uniform.css';
$site['css'][] = 'custom.css';

/* - - - - - - - - - - - 
		JS Scripts
 - - - - - - - - - - - - */
$site['js'] = array();

$site['js'][] = 'excanvas.min.js';
//$site['js'][] = 'jquery.ui.custom.js';
$site['js'][] = 'bootstrap.min.js';
$site['js'][] = 'unicorn.js';
$site['js'][] = 'bootbox.min.js';
$site['js'][] = 'select2.min.js';
$site['js'][] = 'jquery.uniform.js';
$site['js'][] = 'afterevent.js';


/* - - - - - - - - - - - 
		Pre Processing
 - - - - - - - - - - - - */
if(file_exists('./pre-processing/' . $site['page'][PAGE_INDEX].'.php'))
	include_once('pre-processing/' . $site['page'][PAGE_INDEX].'.php');
	
if(!file_exists('./content/' . $site['page'][PAGE_INDEX].'.php'))
	$site['page'][PAGE_INDEX] = PAGE_404;

/* - - - - - - - - - - - 
		Content Display
 - - - - - - - - - - - - */

require_once('header.php');
flush();
include_once('content/' . $site['page'][PAGE_INDEX] . '.php');
flush();
require_once('footer.php');
if($site['debug'] && false)
{
	echo '<pre>';
	print_r($_SESSION);
	echo '</pre>';
}