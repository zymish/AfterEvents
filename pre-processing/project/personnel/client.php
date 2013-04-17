<?php
$site['pageTitle'] = 'This is the page the client will see when logged in.';
$site['js'][] = 'highcharts.js';
$site['js'][] = 'highcharts.theme.js';
$site['css'][] = 'custom.css';

$result = $be->getMetrics($_SESSION['project']['uid']);
$overview = $result['return']['client'];