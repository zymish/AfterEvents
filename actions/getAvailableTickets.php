<?php
require_once('../includes/startup.php');

$output = array(
	'result' => '0',
	'msg'	 => 'Missing Required Data.'
);


$userID = intval($_REQUEST['userID']);
$eventID = intval($_REQUEST['eventID']);
if(!empty($userID) && !empty($eventID)):
	$staff = $staffManager->getStaffByUserID($userID,$eventID);

	$guests = $staffManager->getUserInvitedGuests($userID,$eventID);

	$staff['staffInfo'] = json_decode($staff['staffInfo'],true);

	$tickets = array('total'=>0);
	if(is_array($staff['staffInfo']['tickets']) foreach($staff['staffInfo']['tickets'] as $id => $num)
	{
		$tickets[$id] = $num;
		$tickets['total'] += $num;
	}

	while($guest = $guests->fetch_assoc())
	{
		$tickets[$guest['ticketTypeID']] -= $guest['ticketsNo'];
		$tickets['total'] -= $guest['ticketsNo'];
	}
	
	$output['result'] = 1;
	$output['tickets'] = $tickets;
	unset($output['msg']);
}
echo json_encode($output);