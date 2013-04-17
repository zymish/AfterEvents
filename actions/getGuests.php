<?php
require_once('../includes/startup.php');
$output = array(
	'exists' => '0'
);
if(isset($_SESSION['user']))
{	
	$sql  = "SELECT `guests`.`uid`, `guests`.`eventID`, `guests`.`invitedBy`, `guests`.`firstName`, `guests`.`lastName`, `guests`.`email`, `guests`.`mobile`, `guests`.`birthdate`, `guests`.`tickets`, `guests`.`addons`, `guests`.`notes`, `guests`.`extraData`, `guests`.`rsvp`, ";
	$sql .= "CONCAT(`users`.`firstName`,' ',`users`.`lastName`) AS invitedByName ";
	$sql .= "FROM `guests` LEFT JOIN `users` ON `guests`.`invitedBy` = `users`.`uid`";
	$result = $db->query($sql);
	$count = $result->num_rows;
	if($result && $count < 0)
	{
		$row = $result->fetch_assoc();
		$sql = "SELECT `ticketTypes`.`uid`, `ticketTypes`.`name`, `ticketTypes`.`price` FROM ticketTypes WHERE `ticketTypes`.`eventID` = '".$row['eventID']."'";
		$result = $db->query($sql);
		$ticketTypes = array();
		if($result)
		while($row2 = $result->fetch_assoc()):
		$ticketTypes[$row2['uid']] = $row2;
		endwhile;
		$row['extraData'] = json_decode($row['extraData'],true);
		$row['tickets'] = json_decode($row['tickets'],true);
		if(is_array($row['tickets']))
		foreach($row['tickets'] as $key=>$value)
		$row['tickets'][$key] = array(
			'name' => $ticketTypes[$key]['name'] ,
			'total' => $value
		);
		$guests[] = array(
			'guestID'		=> $row['uid'],
			'firstName'		=> $row['firstName'],
			'lastName'		=> $row['lastName'],
			'company'		=> $row['extraData']['company'],
			'email'			=> $row['email'],
			'mobile'			=> $row['mobile'],
			'birthdate'		=> $row['birthdate'],
			'invitedBy'		=> $row['invitedByName'],
			'rsvp'			=> $row['rsvp'],
			'notes'			=> $row['notes'],
			'tickets'			=> $row['tickets']
		);
		$output = $guests;
		$output['exists'] = '1';
	}
}
echo json_encode($output);