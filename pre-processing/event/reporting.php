<?php
require_once('event.php');
if(!isset($event)) return;
	
if($_POST['action'] == 'saveReportData')
{
	$sql = "SELECT `reporting` FROM `events` WHERE `uid` = '".$eventID."' LIMIT 1";
	$result = $db->query($sql);
	
	if($result && $reportRow = $result->fetch_assoc())
		$report = real_display_array(json_decode($reportRow['reporting'],true));	
	else
		$report = array();
	
	$reportData = array(
		'managerName'		=> $_POST['managerName'],
		'venue'				=> $_POST['venue'],
		'city'				=> $_POST['city'],
		'doorsOpen'			=> $_POST['doorsOpen'],
		'showtime'			=> $_POST['showtime'],
		'overallAttendance'	=> $_POST['overallAttendance'],
		'willCallLoc'		=> $_POST['willCallLoc'],
		'ticketsAllocated'	=> $_POST['ticketsAllocated'],
		'rsvpNo'			=> $_POST['rsvpNo'],
		'ticketsUsed'		=> $_POST['ticketsUsed'],
		'avgArrivalTime'	=> $_POST['avgArrivalTime'],
		'weather'			=> $_POST['weather'],
		'guest-comment'		=> $_POST['guest-comment'],
		'manager-comment'	=> $_POST['manager-comment'],
		'deHubNo'			=> $_POST['deHubNo'],
		'deLocation'		=> $_POST['deLocation'],
		'debaNo'			=> $_POST['debaNo'],
		'deDemoNo'			=> $_POST['deDemoNo'],
		'deDwellTime'		=> $_POST['deDwellTime'],
		'dePhotos'			=> $_POST['dePhotos'],
		'deGiveaways'		=> $_POST['deGiveaways'],
		'dePromoMat'		=> $_POST['dePromoMat'],
		'deFeedback'		=> $_POST['deFeedback'],
		'faq'				=> $_POST['faq'],
		'feedback'			=> $_POST['feedback'],
		'hospLoc'			=> $_POST['hospLoc'],
		'hospType'			=> $_POST['hospType'],
		'rsvpGuestNo'		=> $_POST['rsvpGuestNo'],
		'guestsAttended'	=> $_POST['guestsAttended'],
		'guestType'			=> $_POST['guestType'],
		'ambassNo'			=> $_POST['ambassNo'],
		'decor'				=> $_POST['decor'],
		'menu'				=> $_POST['menu'],
		'giftBags'			=> $_POST['giftBags'],
		'onDutyManager'		=> $_POST['onDutyManager'],
		'ambassNo'			=> $_POST['ambassNo'],
		'extBrandDetails'	=> $_POST['extBrandDetails'],
		'intBrandDetails'	=> $_POST['intBrandDetails'],
		'concourseDetails'	=> $_POST['concourseDetails'],
		'jumboDetails'		=> $_POST['jumboDetails'],
		'stageDetails'		=> $_POST['stageDetails'],
		'addtlBrandDetails'	=> $_POST['addtlBrandDetails'],
		'competeDetails'	=> $_POST['competeDetails'],
		'stationName'		=> $_POST['stationName'],
		'giveaway'			=> $_POST['giveaway'],
		'radioNotes'		=> $_POST['radioNotes']
	);

	if(is_array($_FILES) && sizeof($_FILES) > 0):

		foreach($_FILES as $name => $file):
			$k = 0;
			if(is_array($file['name'])):
				$numImgs = sizeof($file['name']);
				
				foreach($file['size'] as $i => $size):
					if($size < 1024) continue;//1024 = 1kb
					
					$fileName = uploadFile($file['tmp_name'][$i],UPLOAD_PATH.$projectID."/".$eventID."/",$name."-",$file['name'][$i]);
					if($fileName !== false):
						if(isset($report[$name][$i]) && !empty($report[$name][$i]) && file_exists(UPLOAD_PATH.$projectID."/".$eventID."/".$report[$name][$i]))
							unlink(UPLOAD_PATH.$projectID."/".$eventID."/".$report[$name][$i]);
						
						$reportData[$name][$i] = $fileName;
					endif;
				endforeach;
			else:
				if($file['size'] < 1024) continue;
				
				$fileName = uploadFile($file['tmp_name'],UPLOAD_PATH.$projectID."/".$eventID."/",$name."-",$file['name']);
				if($fileName !== false):
					if(isset($report[$name]) && !empty($report[$name]) && file_exists(UPLOAD_PATH.$projectID."/".$eventID."/".$report[$name]))
						unlink(UPLOAD_PATH.$projectID."/".$eventID."/".$report[$name]);
					
					$reportData[$name] = $fileName;
				endif;
			endif;
		endforeach;
	endif;
	
	$reportData = clear_empty_array(normalize_array($reportData));
	
	logActivity(getCurrentUserID(true),$eventID,'Edit Report','editReport',"Previous:\n".$reportRow['reporting']."\n\nNew:\n".json_encode($reportData));
	
	$report = real_array_merge($report,$reportData);
	
	$data = $db->real_escape_string(json_encode($report));
	$sqlReport = "UPDATE `events` SET `reporting` = '".$data."' WHERE `uid` = '".$eventID."'";
	$reportResult = $db->query($sqlReport);
	if($db->error) error_log($db->error);
}

$sql = "SELECT `reporting` FROM `events` WHERE `uid` = '".$eventID."' LIMIT 1";
$result = $db->query($sql);

if($result && $report = $result->fetch_assoc())
	$report = real_display_array(json_decode($report['reporting'],true));	
else
	$report = array();

$venue = $eventManager->getVenueByID($event['venueID']);

require_once('content/event/getWeather.php');
$weatherState = json_decode($weather, true);
if(is_array($weatherState['history']['observations'])):
	foreach($weatherState['history']['observations'] as $observation):
		if($observation['date']['hour'] != '20')
		continue;
		$condition = $observation['conds'];
		$temp = $observation['tempi'];
	endforeach;
endif;



$total = 0;
$rsvp = 0;
$used = 0;
$sql = "SELECT `uid`,`rsvp`,`checkIns` FROM `guests` WHERE `eventID` = '".$eventID."'";
$result = $db->query($sql);
if($result)
while($row = $result->fetch_assoc()):
	$total++;
	if($row['rsvp'] == '1') $rsvp++;
	if($row['checkIns'] > 0)$used++;
endwhile;
				
$generated = array(
	'venue'				=> $venue['name'],
	'city'				=> $venue['city'],
	'doorsOpen'			=> $event['extraData']['doorsOpen'],
	'doorsClose'		=> $event['extraData']['doorsClose'],
	'willCallLoc'		=> $event['extraData']['willCallLoc'],
	'ticketsAllocated'	=> $total,
	'rsvpNo'			=> $rsvp,
	'ticketsUsed'		=> $used,
	'avgArrivalTime'	=> '',
	'hospLoc'			=> $event['extraData']['hospLoc'],
	'rsvpGuestNo'		=> $rsvp,
	'guestsAttended'	=> $used,
	'weather'			=> $condition.' and '.$temp.' degrees'
);


$site['pageTitle'] = date("n/j",strtotime($event['start'])) . " " . $event['title'] . ' - Reporting';
$site['css'][] = 'bootstrap-fileupload.min.css';
$site['js'][] = 'bootstrap-fileupload.min.js';
$site['js'][] = 'highcharts.js';
$site['js'][] = 'highcharts.theme.js';
$site['js'][] = 'jquery.simpleWeather-2.1.2.min.js';