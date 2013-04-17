<?php
require_once('../includes/startup.php');

require('includes/class.photoUploadManager.php');

$eventID = intval($_REQUEST['eventID']);
$projectID = intval($_REQUEST['projectID']);
$type = preg_replace("/[^a-zA-Z0-9]+/", "", $_REQUEST['type']);

$options = array(
	'upload_dir' => UPLOAD_PATH.'/'.$projectID.'/'.$eventID.'/'.$type.'/',
    'upload_url' => UPLOAD_URL.'/'.$projectID.'/'.$eventID.'/'.$type.'/',
	'thumbnail' => array(
		'max_width' => 200,
		'max_height' => 200
	)
);

$upload_handler = new UploadHandler($options);