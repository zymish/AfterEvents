<?php
$site['pageTitle'] = "Event List";

$events = array(
	'past' => array(),
	'upcoming' => array(),
	'distant' => array()
);
if(!empty($projectID)) 
{
	$sql  = "SELECT `uid`, `title`, `start` FROM `events` WHERE `projectID` = '".$projectID."' ORDER BY `start` ASC";
	$result = $db->query($sql);
	if($result)
	{
		if($result->num_rows > 0)
		{
			while($event = $result->fetch_assoc())
			{
				if(checkPermission(array($projectID,'events',$event['uid'],'view'),true))
				{
					if(strtotime($event['start']) < time() - (60 * 60 * 24))
						$events['past'][$event['uid']] = $event;
					else if(strtotime($event['start']) - time() < 60 * 60 * 24 * 30) //seconds * minutes * hours * days
						$events['upcoming'][$event['uid']] = $event;
					else
						$events['distant'][$event['uid']] = $event;
				}
			}
		}
		else
			$errors[] = array('type'=>'warning','icon'=>'icon-calendar','msg'=>'There are currently no events assigned to this project.');
	}else
		$errors[] = array('type'=>'error','icon'=>'icon-hdd','msg'=>'There was a database error.  Please Try Again.');
}