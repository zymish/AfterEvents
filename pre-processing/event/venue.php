<?php
require_once('event.php');
if(!isset($event)) return;

if(!empty($event['venueID']))
{
	$sql = "SELECT `uid`, `name`, `address`, `address2`, `city`, `state`, `zipcode`, `country`, `phone`, `website`,`seatingChart`, `venueMap` FROM `venues` WHERE `uid` = '".$event['venueID']."' LIMIT 1";
	$result = $db->query($sql);
	if($result)
		$venue = $result->fetch_assoc();
}

$site['pageTitle'] = date("n/j",strtotime($event['start'])) . " " . $event['title'] . ' - <small>'.(($venue)?$venue['name']:"Venue").'</small>';