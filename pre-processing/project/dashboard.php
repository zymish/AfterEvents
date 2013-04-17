<?php
$title = $_POST['title'];
$description = $_POST['description'];
$timestamp = date('Y-m-d H:i:s');
if($_POST['action'] == 'addUpdate'):
$sql = "INSERT INTO `projectupdates` (`title`,`description`,`timestamp`,`userID`,`projectID`) VALUES ('".$title."','".$description."','".$timestamp."','".getCurrentUserID()."','".$projectID."')";
$result = $db->query($sql);
endif;

$sql = "SELECT `title`, `description`, `timestamp` FROM `projectupdates` WHERE `projectID` = '".$projectID."' LIMIT 3";
$result = $db->query($sql);
if($result)
while($update = $result->fetch_assoc()) $updates[] = $update;

$sql = "SELECT `events`.`uid`, `events`.`title`, `events`.`start`, `venues`.`name` AS venue, `venues`.`state` as state FROM `events` ";
$sql .= "LEFT JOIN `venues` ON `venues`.`uid` = `events`.`venueID` ";
$sql .= "WHERE `projectID` = '".$projectID."' AND `start` > NOW() ORDER BY `start` ASC LIMIT 4";
$result = $db->query($sql);
if($result) 
while($event = $result->fetch_assoc()) $events[] = $event;

$site['pageTitle'] = 'BlackBerry Presents: Alicia Keys';
$site['js'][] = 'highcharts.js';
$site['js'][] = 'highcharts.theme.js';