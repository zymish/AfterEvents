<?php
require_once('../includes/startup.php');

$output = array(
	'result'	=> '0',
	'msg'	=> 'Missing required data.'
);
$eventID=$_POST['eventID'];
$limit=$_POST['limit'];

$sql = "SELECT * FROM eventUpdates WHERE eventID = ".$eventID." ORDER BY timestamp DESC";
if(isset($limit)) $sql .= " LIMIT ".$limit;
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