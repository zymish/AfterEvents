<?php 
require_once('event.php');
if(!isset($event)) return;

if(!checkPermission(array($projectID,'events',$eventID,'staff','new')))
{
	$errors[] = array('type'=>'error','icon'=>'icon-lock','msg'=>'You do not have permission to add contacts for this event.');
	$site['page'][PAGE_INDEX] = 'event/overview';
	include_once("pre-processing/" . $site['page'][PAGE_INDEX].'.php');
	return;
}
$groupID = $site['page'][EVENT_INDEX + 1];

$sql = "SELECT title FROM eventStaffGroups WHERE uid = ".$groupID."";
$result=$db->query($sql);
if($result)
	$group = $result->fetch_assoc();
	
$site['pageTitle'] = date("n/j",strtotime($event['start'])) . " " . $event['title'] . ' - New '.$group['title'].' Staff';