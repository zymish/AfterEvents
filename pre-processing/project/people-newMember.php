<?php
$groupID = $site['page'][PROJECT_INDEX + 1];
$sql = "SELECT title FROM eventStaffGroups WHERE uid = ".$groupID."";
$result=$db->query($sql);
if($result)
	$group = $result->fetch_assoc();

$sql = "SELECT title FROM events WHERE projectID = '".$projectID."'";
$result = $db->query($sql);
if($result && $result->num_rows > 0)
while($results = $result->fetch_assoc()):
	$events[] = $results;
endwhile;