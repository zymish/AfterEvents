<?php 
require_once('../includes/startup.php');

$eventID = intval($_REQUEST['eventID']);
$event = $eventManager->getEventByID($eventID);

if(!$event):
	echo 'Invalid EventID';
	exit;
endif;

$report = $event['reporting'];
$report['date'] = date('F jS, Y',strtotime($event['start']));

require_once 'includes/phpdocx/classes/CreateDocx.inc';
require_once 'includes/phpdocx/classes/TransformDoc.inc';

$docx = new CreateDocx();
$docx->addTemplate('example_template.docx');

//$fields = $docx->getTemplateVariables();

foreach($report as $field => $value):
	$type = (strpos($field,'Img') > 1)?'image':NULL;
	if(!is_array($value)):
		if($type == 'image'):
			if(empty($value)):
				$docx->addTemplateVariable($field,'');
			else:
				$value = '../uploads/'.$event['projectID']."/".$eventID."/".$value;
				$docx->addTemplateImage($field, $value);
			endif;
		else:
			$docx->addTemplateVariable($field, $value);
		endif;
	else:
		if($type == 'image'):
			$index = 0;
			foreach($value as $item):
				$item = '../uploads/'.$event['projectID']."/".$eventID."/".$item;
				$docx->addTemplateImage($field."-".($index+1),$item);
				$index++;
			endforeach;
		else:
			if($field == 'radioAudio'):
				$output = '';
				$index = 1;
				foreach($value as $item):
					$item = SITE_ROOT.'uploads/'.$event['projectID']."/".$eventID."/".$item;
					$output .= "<a href='".$item."'>Download File ".$index++."</a> &nbsp; ";
				endforeach;
				$docx->addTemplateVariable($field,$output,'html');
			else:
				$docx->addTemplateVariable($field, "<p>".implode("</p><p>",$value)."</p>",'html');
			endif;
		endif;
	endif;
endforeach;

if(!file_exists('../uploads/'.$event['projectID'].'/'.$eventID.'/'))
		mkdir('../uploads/'.$event['projectID'].'/'.$eventID.'/',0755,true);
/*
echo '<pre>';
print_r($report);
print_r($fields);
print_r($used);
print_r($docx->getTemplateVariables());
echo '</pre>';
*/
$docx->createDocx('../uploads/'.$event['projectID'].'/'.$eventID.'/'.$event['title'].'-report');
header('Location: '.SITE_ROOT.'uploads/'.$event['projectID'].'/'.$eventID.'/'.$event['title'].'-report.docx') ;