<?php
require_once('event.php');
if(!isset($event)) return;
$site['pageTitle'] = date("n/j",strtotime($event['start'])) . " " . $event['title'] . ' - Media';
$site['js'][] = 'highcharts.js';
$site['js'][] = 'highcharts.theme.js';
$site['js'][] = 'jquery.gritter.min.js';
$site['css'][] = 'jquery.gritter.css';