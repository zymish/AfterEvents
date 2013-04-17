<?php
require_once('../includes/startup.php');

$output = array(
	'result'	=> '0',
	'msg'	=> 'Missing required data.'
);
$projectID=$_POST['projectID'];

$sql = "SELECT * FROM `projectUpdates` WHERE `projectID` = ".$projectID." ";

if(checkPermission(array($projectID,'updates','admin-view'))) $sql .= "AND `level` <= 2 ";
elseif(checkPermission(array($projectID,'updates','admin-view')) || true) $sql .= "AND `level` <= 1 ";
else $sql .= "AND `level` < 1 ";

$sql .= "ORDER BY `timestamp` DESC";
$result=$db->query($sql);
if($result):
	$output['result'] = '1';
	if($result->num_rows > 0):
		while($row = $result->fetch_assoc()):
			$output['updates'][] = array(
				'title' 			=> $row['title'],
				'description' 	=> $row['description'],
				'day'				=> date("d",strtotime($row['timestamp'])),
				'month'			=> date("M",strtotime($row['timestamp'])),
				'level'			=> $row['level']
			);
		endwhile;
	else:
		$output['updates'][] = array(
			'title' => 'There are no updates for this event.',
			'description' => '',
			'day'	=> '',
			'month' => '',
			'level' => ''
		);
	endif;
else:
	$output['msg'] = 'There was an error fetching the latest updates.';
endif;

echo json_encode($output);