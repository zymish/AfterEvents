<?php
require_once('../includes/startup.php');

$output = array(
	'result'	=> '0',
	'msg'	=> 'Missing required data.'
);

if(!empty($_POST['title']) && !empty($_POST['message']) && isset($_POST['level'])):
	$eventID=$_POST['eventID'];
	$title=$_POST['title'];
	$message=$_POST['message'];
	$timestamp=$date = date('Y-m-d H:i:s');
	$level=$_POST['level'];

	$sql = "INSERT INTO eventUpdates (eventID,title,description,timestamp,level) VALUES (".$eventID.",'".$db->real_escape_string($title)."','".$db->real_escape_string($message)."','".$timestamp."',".$level.")";
	$result=$db->query($sql);
	if($result):
		$output = array(
			'result'	=> '1',
			'msg'	=> 'Message successfully added.'
		);
	else:
		$output['msg'] = $db->error;
	endif;
endif;

echo json_encode($output);