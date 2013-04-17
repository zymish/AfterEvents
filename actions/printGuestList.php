<?php require_once('../includes/startup.php');
$eventID = intval($_REQUEST['eventID']);
$addons = $ticketManager->getAddons($eventID);

$event = $eventManager->getEventByID($eventID);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Table Printing Demo</title>
 
<style type="text/css">
 
body {
font-family: verdana, arial, sans-serif ;
font-size: 14px ;
}
 
th,
td {
padding: 4px 4px 4px 4px ;
text-align: left ;
}

tbody tr td.center{text-align:center;}

th {
border-bottom: 2px solid #333333 ;
padding: 2px 10px;
}
 
td {
border-bottom: 1px dotted #999999 ;
vertical-align:top;
padding: 2px 10px;
}
 
tfoot td {
border-bottom-width: 0px ;
border-top: 2px solid #333333 ;
padding-top: 20px ;
}
 
</style>
 
</head>
<body>
<h1>BlackBerry Presents Alicia Keys in <?=$event['title']?> - <small><?=date('n/j',strtotime($event['start']))?></small></h1>
<hr />
<?php

$sql  = "SELECT DISTINCT(`guests`.`uid`), `guests`.`eventID`, `guests`.`firstName`, `guests`.`lastName`, `guests`.`notes`, `eventStaff`.`staffInfo`, `guests`.`responsible`, `ticketTypes`.`name` as `ticketType`,`guests`.`addons`,`ticketsNo` ";
$sql .= "FROM `guests` LEFT JOIN `eventStaff` ON `guests`.`invitedBy` = `eventStaff`.`userID` ";
$sql .= "LEFT JOIN `ticketTypes` ON `guests`.`ticketTypeID` = `ticketTypes`.`uid` ";
// $sql .= "LEFT JOIN `guestGroups` ON `guests`.`groupID` = `guestGroups`.`uid` ";
$sql .= "WHERE `guests`.`eventID` = '".$eventID."' GROUP BY `guests`.`uid` ";

// if($_REQUEST['sort'] == 'BU')
    // $sql .= "ORDER BY `guestGroups`.`name` ASC, `guests`.`lastName` ASC ";
// else
	$sql .= "ORDER BY `guests`.`lastName` ASC, `guests`.`firstName` ASC ";

$result = $db->query($sql);
$count = $result->num_rows;
if($result && $count > 0):
	while($row = $result->fetch_assoc()):
		$row['addons'] = json_decode($row['addons'],true);
		$row['staffInfo'] = json_decode($row['staffInfo'],true);
		$guest = array(
			'firstName'		=> $row['firstName'],
			'lastName'		=> $row['lastName'],
			'invitedBy'		=> $row['staffInfo']['businessUnit'],
			// 'groupName'		=> $row['groupName'],
			'notes'			=> $row['notes'],
			'ticketType'	=> $row['ticketType'],
			'hospitality'	=> '',
			'ticketsNo'		=> $row['ticketsNo']
		);
		if(is_array($row['addons']))
		foreach($row['addons'] as $id => $value)
			if($value == '1')$guest['hospitality'] .= ((!empty($guest['hospitality']))?', ':'').$addons[$id]['name'];
			
		if($_REQUEST['sort'] == 'BU')
			$guests[$guest['invitedBy']][] = $guest;
		else 
			$guests[] = $guest;
			
	endwhile;
	ksort($guests);
endif;
if($db->error) echo $db->error;

if($_REQUEST['sort'] == 'BU'):
	foreach($guests as $bu => $list):
	if(!is_array($list)) continue;
?>
<h2><?=$bu?></h2>
<table cellspacing="0">
	<thead>
		<tr>
        	<th>&nbsp;</th>
			<th>Name</th>
            <th># TIX</th>
            <th>Type</th>
            <th>Hospitality</th>
            <!--<th>Group</th>-->
            <th>Authorized</th>
            
			<th>Notes</th>
		</tr>
	</thead>
	<tbody>
<?php
foreach ($list as $i => $guest): ?>
		<tr>
        	<td><?=$i+1?></td>
			<td><?=$guest['lastName'].", ".$guest['firstName']?></td>
            <td class="center"><?=$guest['ticketsNo']?></td>
            <td><?=$guest['ticketType']?></td>
            <td><?=$guest['hospitality']?></td>
			<!--<td><?=$guest['groupName']?></td>-->
			<td><?=htmlentities(stripslashes($guest['responsible']))?></td>
			<td><?=htmlentities(stripslashes($guest['notes']))?></td>
		</tr>
<?php
endforeach;
?>
	</tbody>
</table>
<br />
<hr />
<?php 
	endforeach;
else:
?>
<table cellspacing="0">
	<thead>
		<tr>
        	<th>&nbsp;</th>
			<th>Name</th>
            <!--<th>Group</th>-->
			<th>BU</th>
            <th># TIX</th>
            <th>Type</th>
            <th>Hospitality</th>
            <th>Authorized</th>
			<th>Notes</th>
		</tr>
	</thead>
	<tbody>
<?php
if(is_array($guests)):
	foreach ($guests as $i => $guest): ?>
			<tr>
            	<td><?=$i+1?></td>
				<td><?=$guest['lastName'].", ".$guest['firstName']?></td>
				<!--<td><?=$guest['groupName']?></td>-->
				<td><?=$guest['invitedBy']?></td>
                <td class="center"><?=$guest['ticketsNo']?></td>
                <td><?=$guest['ticketType']?></td>
                <td><?=$guest['hospitality']?></td>
                <td><?=htmlentities(stripslashes($guest['responsible']))?></td>
				<td><?=htmlentities(stripslashes($guest['notes']))?></td>
			</tr>
<?php
	endforeach;
endif;
?>
	</tbody>
</table>
<?php
endif;
?>
</body>
</html>