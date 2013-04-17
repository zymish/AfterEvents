<?php
$eventStart = strtotime($event['start']);
$historyDate = date('Ymd',$eventStart);
$date1 = new DateTime(date('Y-m-d H:i:s'));
$date2 = new DateTime($event['start']);

if($date1 > $date2) $ch = curl_init('http://api.wunderground.com/api/8672146e632e82a3/history_'.$historyDate.'/q/'.$venue['state'].'/'.$venue['city'].'.json');
else
$ch = curl_init('http://api.wunderground.com/api/8672146e632e82a3/conditions/q/'.$venue['state'].'/'.$venue['city'].'.json');

curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$weather = curl_exec($ch);
curl_close($ch);
?>