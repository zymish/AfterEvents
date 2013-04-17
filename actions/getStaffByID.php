<?php
require_once('../includes/startup.php');

$output = array(
	'result' => '0',
	'msg' => 'Missing Required Data.'
);

if(isset($_REQUEST['staffID']) && isset($_SESSION['user']))
{
	$staffID = intval($_REQUEST['staffID']);
	$sql  = "SELECT `eventStaff`.`uid`, `eventStaff`.`userID`, `eventStaff`.`staffInfo`, `eventStaff`.`staffGroupID`, ";
	$sql .= "`users`.`firstName`, `users`.`lastName`, `users`.`email`, `users`.`mobile` ";
	$sql .= "FROM `eventStaff` LEFT JOIN `users` ON `eventStaff`.`userID` = `users`.`uid` WHERE `eventStaff`.`uid` = '".$staffID."' LIMIT 1";
	$result = $db->query($sql);
	if($result && $result->num_rows == 1)
	{
		$row = $result->fetch_assoc();
		$row['staffInfo'] = json_decode($row['staffInfo'],true);
		$user = $row['staffInfo'];
		$tmp = array(
			'staffID'				=> $row['uid'],
			'staffGroupID'		=> $row['staffGroupID'],
			'userID'				=> $row['userID'],
			'firstName'			=> (isset($row['staffInfo']['firstName']) && !empty($row['staffInfo']['firstName']))?$row['staffInfo']['firstName']:$row['firstName'],
			'lastName'			=> (isset($row['staffInfo']['lastName']) && !empty($row['staffInfo']['lastName']))?$row['staffInfo']['lastName']:$row['lastName'],
			'email'				=> (isset($row['staffInfo']['email']) && !empty($row['staffInfo']['email']))?$row['staffInfo']['email']:$row['email'],
			'mobile'				=> (isset($row['staffInfo']['mobile']) && !empty($row['staffInfo']['mobile']))?$row['staffInfo']['mobile']:$row['mobile'],
			'company'			=> (isset($row['staffInfo']['company']) && !empty($row['staffInfo']['company']))?$row['staffInfo']['company']:'',
			'businessUnit'	=> (isset($row['staffInfo']['businessUnit']) && !empty($row['staffInfo']['businessUnit']))?$row['staffInfo']['businessUnit']:'',
			'responsibility'	=> (isset($row['staffInfo']['responsibility']) && !empty($row['staffInfo']['responsibility']))?$row['staffInfo']['responsibility']:'',
			'notes'				=> (isset($row['staffInfo']['notes']) && !empty($row['staffInfo']['notes']))?$row['staffInfo']['notes']:''
		);
		
		foreach($tmp as $field => $value)
			$user[$field] = $value;
		
		//if(isset($_REQUEST['getTickets'],$row['staffInfo']['tickets']) && $_REQUEST['getTickets'] == '1')
			$user['tickets'] = (isset($row['staffInfo']['tickets']))?$row['staffInfo']['tickets']:array();
			$user['addons'] = (isset($row['staffInfo']['addons']))?$row['staffInfo']['addons']:array();
		
		$output = $user;
		$output['result'] = '1';
	}else
		$output['msg'] = 'Unable to find Staff Member';
}

echo json_encode($output);