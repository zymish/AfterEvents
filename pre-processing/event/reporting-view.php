<?php
require_once('event.php');
if(!isset($event)) return;	

$sql = "SELECT `reporting` FROM `events` WHERE `uid` = '".$eventID."' LIMIT 1";
$result = $db->query($sql);

if($result && $report = $result->fetch_assoc())
	$report = real_display_array(json_decode($report['reporting'],true));	
else
	$report = array();

$site['pageTitle'] = date("n/j",strtotime($event['start'])) . " " . $event['title'] . ' - Report';
$site['css'][] = 'bootstrap-fileupload.min.css';
$site['js'][] = 'bootstrap-fileupload.min.js';
$site['js'][] = 'highcharts.js';
$site['js'][] = 'highcharts.theme.js';
$site['js'][] = 'jquery.simpleWeather-2.1.2.min.js';