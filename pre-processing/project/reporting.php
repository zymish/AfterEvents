<?php
$site['pageTitle'] = "Event List";

$events = array(
	'past' => array(),
	'upcoming' => array(),
	'distant' => array()
);
$skipEvents = array(55);
$canEvents = array(2,15,16);
$report = array(
	'all' => array(
		'tickets'=>0,
		'rsvp'=>0,
		'used'=>0,
		'attendance'=>0,
		'demos'=>0,
		'photos'=>0,
		'hosp'=>0,
		'hospGuests'=>0
	),
	'us' => array(
		'tickets'=>0,
		'rsvp'=>0,
		'used'=>0,
		'attendance'=>0,
		'demos'=>0,
		'photos'=>0,
		'hosp'=>0,
		'hospGuests'=>0
	),
	'can' => array(
		'tickets'=>0,
		'rsvp'=>0,
		'used'=>0,
		'attendance'=>0,
		'demos'=>0,
		'photos'=>0,
		'hosp'=>0,
		'hospGuests'=>0
	)
);

if(!empty($projectID)) 
{
	$sql  = "SELECT `uid`, `title`, `start`,`reporting` FROM `events` WHERE `projectID` = '".$projectID."' ORDER BY `start` ASC";
	$result = $db->query($sql);
	if($result)
	{
		if($result->num_rows > 0)
		{
			while($event = $result->fetch_assoc())
			{
				$eventReport = json_decode($event['reporting'],true);
				unset($event['reporting']);
				
				if(checkPermission(array($projectID,'events',$event['uid'],'view'))):
					if(strtotime($event['start']) < time() - (60 * 60 * 24))
						$events['past'][$event['uid']] = $event;
					else if(strtotime($event['start']) - time() < 60 * 60 * 24 * 30) //seconds * minutes * hours * days
						$events['upcoming'][$event['uid']] = $event;
					else
						$events['distant'][$event['uid']] = $event;
				endif;
				
				if(in_array($event['uid'],$skipEvents)) continue;
				
				$report['all']['attendance'] += intval(preg_replace('/[^0-9]/','',$eventReport['overallAttendance']));
				$report[((in_array($event['uid'],$canEvents))?'can':'us')]['attendance'] += intval(preg_replace('/[^0-9]/','',$eventReport['overallAttendance']));
				
				$report['all']['demos'] += intval(preg_replace('/[^0-9]/','',$eventReport['deDemoNo']));
				$report[((in_array($event['uid'],$canEvents))?'can':'us')]['demos'] += intval(preg_replace('/[^0-9]/','',$eventReport['deDemoNo']));
				
				$report['all']['photos'] += intval(preg_replace('/[^0-9]/','',$eventReport['dePhotos']));
				$report[((in_array($event['uid'],$canEvents))?'can':'us')]['photos'] += intval(preg_replace('/[^0-9]/','',$eventReport['dePhotos']));
				
				$hasHosp = false;
				$sql = "SELECT `ticketsNo`,`addons`,`rsvp`,`checkIns` FROM `guests` WHERE `eventID` = '".$event['uid']."'";
				$result2 = $db->query($sql);
				if($result2)
				while($guest = $result2->fetch_assoc()):
					$hosp = json_decode($guest['addons'],true);
					
					$report['all']['tickets'] += $guest['ticketsNo'];
					$report[((in_array($event['uid'],$canEvents))?'can':'us')]['tickets'] += $guest['ticketsNo'];
					
					if($guest['rsvp'] == 1):
						$report['all']['rsvp']++;
						$report[((in_array($event['uid'],$canEvents))?'can':'us')]['rsvp']++;
					endif;
					
					if($guest['checkIns'] >= 1):
						$report['all']['used']++;
						$report[((in_array($event['uid'],$canEvents))?'can':'us')]['used']++;
					endif;
					
					if(is_array($hosp))
					foreach($hosp as $has)
						if($has == '1'):
							$report['all']['hospGuests'] += $guest['ticketsNo'];
							$report[((in_array($event['uid'],$canEvents))?'can':'us')]['hospGuests'] += $guest['ticketsNo'];
							if(!$hasHosp):
								$hasHosp = true;
								$report['all']['hosp']++;
								$report[((in_array($event['uid'],$canEvents))?'can':'us')]['hosp']++;
							endif;
							
						endif;
					
				endwhile;
			}
		}
		else
			$errors[] = array('type'=>'warning','icon'=>'icon-calendar','msg'=>'There are currently no events assigned to this project.');
	}else
		$errors[] = array('type'=>'error','icon'=>'icon-hdd','msg'=>'There was a database error.  Please Try Again.');
}