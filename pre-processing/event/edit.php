<?php
if(!checkPermission(array($projectID,'events',$eventID,'edit')))
{
	$errors[] = array('type'=>'error','icon'=>'icon-lock','msg'=>'You do not have permission to edit this event.');
	$site['page'][PAGE_INDEX] = 'event/overview';
	include_once("pre-processing/" . $site['page'][PAGE_INDEX].'.php');
	return;
}

/*
		Data has been edited.
*/
if(isset($_POST,$_POST['uid']) && !empty($_POST['uid']))
{
	if($eventID == $_POST['uid'])
	{
		unset($_POST['uid']);
		
		//Uploaded Files
		if(isset($_FILES))
		{			
			if(isset($_FILES['seatingChart']) && $_FILES['seatingChart']['size'] > 0)
			{
				$name = uploadImage($_FILES['seatingChart']['tmp_name'],UPLOAD_PATH . "venues/",$eventID . "-" . substr(str_replace(" ","",$_POST['venue']['name']),0,7)."-");
				if($name)
					$_POST['venue']['seatingChart'] = $name;	
			}
			
			if(isset($_FILES['venueMap']) && $_FILES['venueMap']['size'] > 0)
			{
				$name = uploadImage($_FILES['venueMap']['tmp_name'],UPLOAD_PATH . "venues/",$eventID . "-" . substr(str_replace(" ","",$_POST['venue']['name']),0,7)."-");
				if($name)
					$_POST['venue']['venueMap'] = $name;	
			}
		}
		
		//UPDATE VENUE
		if(isset($_POST['venue'],$_POST['venue']['name']) && !empty($_POST['venue']['name']))
		{
			$venue = $_POST['venue'];
			if(!empty($venue['uid']))
			{
				//UPDATE
				$items = array();
				if(is_array($venue)) foreach($venue as $key => $value)
				{
					if($key == 'uid') continue;
					$items[] = "`".$db->real_escape_string($key)."` = '".$db->real_escape_string($value)."'";
				}
				if(sizeof($items) > 0)
				{
					if(isset($_POST['venue']['venueMap']) || isset($_POST['venue']['seatingChart']))
					{
						$sql = "SELECT `seatingChart`, `venueMap` FROM `venues` WHERE `uid` = '".intval($venue['uid'])."' LIMIT 1";
						$result = $db->query($sql);
						if($result && $result->num_rows == 1)
						{
							$row = $result->fetch_assoc();
							if(isset($_POST['venue']['venueMap']) && !empty($row['venueMap']))
							{
								unlink(UPLOAD_PATH . "venues/" . $row['venueMap']);
							}
							if(isset($_POST['venue']['seatingChart']) && !empty($row['seatingChart']))
							{
								unlink(UPLOAD_PATH . "venues/" . $row['seatingChart']);
							}
						}
							
					}
					$sql = "UPDATE `venues` SET ".implode(',',$items)." WHERE `uid` = '".intval($venue['uid'])."' LIMIT 1";
					$db->query($sql);
					if(!empty($db->error))
					{
						error_log($db->error);
						$errors[] = array('type'=>'error','icon'=>'icon-hdd','msg'=>'There was an issue saving the venue data.  Please Try Again.');
					}else $errors[] = array('type'=>'success','icon'=>'icon-save','msg'=>'Venue Saved Successfully');
				}
			}
			else
			{
				//NEW
				$keys = array();
				$values = array();
				if(is_array($venue)) foreach($venue as $key => $value)
				{
					if($key == 'uid') continue;
					$keys[] = "`".$db->real_escape_string($key)."`";
					$values[] = "'".$db->real_escape_string($value)."'";
				}
				$sql  = "INSERT INTO `venues` (".implode(',',$keys).") VALUES(".implode(',',$values).")";
				if(sizeof($keys) == sizeof($values) && sizeof($keys) > 0)
				{
					$db->query($sql);
					if(!empty($db->error))
					{
						error_log($db->error);
						$errors[] = array('type'=>'error','icon'=>'icon-hdd','msg'=>'There was an issue creating the venue data.  Please Try Again.');
					}
					else 
					{
						$errors[] = array('type'=>'success','icon'=>'icon-save','msg'=>'Venue Created Successfully');
						$_POST['venueID'] = $db->insert_id;
					}
					
				}
			}
		}
		
		//UPDATE EVENT
		$hasExtra = false;
		$items = array();
		if(is_array($_POST)) foreach($_POST as $key => $value)
		{
			if(in_array($key,array('venue','ticketTypes','addons','venueMap','seatingChart')))
			{
				//Do Nothing.
			}
			else if($key == 'extraData')
			{
				if(is_array($value)) $hasExtra = true;
			}
			else
			{
				if(is_array($value)) continue;
				if(in_array($key,array('start','end'))) $value = date("Y-m-d H:i:s",strtotime($value));
				$items[] = "`".$db->real_escape_string($key)."` = '".$db->real_escape_string($value)."'";
			}
		}
		if($hasExtra){
			$result = $db->query("SELECT `extraData` FROM `events` WHERE `uid` = '".$eventID."' LIMIT 1");
			if($result && $result->num_rows == 1)
			{
				$extraData = $result->fetch_assoc();
				$extraData = json_decode($extraData['extraData'],true);
				foreach($_POST['extraData'] as $key => $value)
					$extraData[$key] = $value;
					
				$extraData = json_encode($extraData);
				$items[] = "`extraData` = '".$db->real_escape_string($extraData)."'";
			}
		}
		if(sizeof($items) > 0)
		{
			$sql = "UPDATE `events` SET ".implode(',',$items)." WHERE `uid` = '".$eventID."' LIMIT 1";
			logActivity(getCurrentUserID(true),$eventID,'Edit Event','editEvent',"SQL: ".$sql);
			$db->query($sql);
			if(!empty($db->error))
			{
				error_log($db->error);
				$errors[] = array('type'=>'error','icon'=>'icon-hdd','msg'=>'There was an issue saving the event data.  Please Try Again.');
			}else $errors[] = array('type'=>'success','icon'=>'icon-save','msg'=>'Event Saved Successfully');
		}
		
	}
	else $errors[] = array('type'=>'error','icon'=>'icon-hdd','msg'=>'There was an issue saving the event data.  Please Try Again.');
}

require_once('event.php');
if(!isset($event)) return;

if(!empty($event['venueID']))
{
	$sql = "SELECT `uid`, `name`, `address`, `address2`, `city`, `state`, `zipcode`, `country`, `phone`, `website`,`seatingChart`, `venueMap` FROM `venues` WHERE `uid` = '".$event['venueID']."' LIMIT 1";
	$result = $db->query($sql);
	if($result)
		$venue = $result->fetch_assoc();
		$venue = real_display_array($venue);
}

$sql = "SELECT `uid`, `name`, `price`, `total` FROM `ticketTypes` WHERE `eventID` = '".$eventID."' ORDER BY `name` ASC";
$ticketTypes = $db->query($sql);

$sql = "SELECT `uid`, `name`, `type`, `price`, `total` FROM `addonTypes` WHERE `eventID` = '".$eventID."' ORDER BY `name` ASC";
$addons = $db->query($sql);

$site['pageTitle'] = date("n/j",strtotime($event['start'])) . " " . $event['title'] . ' - Edit Event';
$site['js'][] = 'jquery.tokeninput.js';
$site['js'][] = 'bootstrap-datetimepicker.min.js';
$site['css'][] = 'token-input-bootstrap.css';
$site['css'][] = 'bootstrap-datetimepicker.min.css';