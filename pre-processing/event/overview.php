<?php
require_once('event.php');
$sql = "SELECT `name`, `description`, `address`, `address2`, `city`, `state`, `zipcode`, `country`, `phone`, `website`, `seatingChart`, `venueMap` FROM `venues` WHERE `venues`.`uid` = '".$event['venueID']."'";
$result=$db->query($sql);
if($result) $venue=$result->fetch_assoc();
if(!isset($event)) return;
$site['pageTitle'] = date("n/j",strtotime($event['start'])) . " " . $event['title'] . ' - Overview';
$site['js'][] = 'highcharts.js';
$site['js'][] = 'highcharts.theme.js';
$site['js'][] = 'jquery.simpleWeather-2.1.2.min.js';