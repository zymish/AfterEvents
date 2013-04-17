<?php
require_once('../includes/startup.php');

$eventID = 1;
$names = array('Carl Hanson','Florence Sharples','Nils Styger','Carl Zante','Adam Neramani','Paola Keaton','Mallory Simms','John Goodman','Alicia Stepp','Katherine Rush','Caroline Yanez','Elizabeth Joiner','Zoey Mcgee','Louis Keith','Victor Guzman','Steven Pressley','Grayson Hale','Hermoine Young','Paisley Lewis','Diamond Parker','Edith Thompson','Giovanni Valadez','Maxwell Tovar','Fairly Davies','Mark Anderson','Julian Anderson','Michael Ibn','Jonathan Hickman','Dan Abnett');
$companies = array('Sprint','Verizon Wireless','T-mobile','AT&T','TSM','Neal FM','Enterprize','BlackBerry');
$rsvps = array("NULL","'0'","'1'");

$sql = "INSERT INTO `guests` (`eventID`,`firstName`,`lastName`,`email`,`mobile`,`extraData`,`invitedBy`,`birthdate`,`ticketTypeID`,`created`,`rsvp`,`notes`) VALUES";
foreach($names as $i => $name)
{
	$name = explode(' ',$name);
	$company = $companies[rand(0,sizeof($companies) -1)];
	$email = $db->real_escape_string(strtolower(substr($name[0],0,1).".".$name[1]."@".str_replace(" ","",$company).".com"));
	$mobile = rand(0,9).rand(0,9).rand(0,9)."-".rand(0,9).rand(0,9).rand(0,9)."-".rand(0,9).rand(0,9).rand(0,9).rand(0,9);
	$extraData = json_encode(array('company'=>$company));
	$bDay = rand(1950,1988)."-".rand(1,12)."-".rand(1,27);
	$rsvp = $rsvps[rand(0,2)];
	
	if(rand(0,10) <= 3)
		$notes = "A Very Important VIP.";	
	elseif(rand(0,10) > 7)
		$notes = "Will be bringing serveral important guests.  Treat them all extra special.";
	else
		$notes = "";
	
	
	if($i > 0) $sql .= ",\n";
	$sql .= "('".$eventID."','".$name[0]."','".$name[1]."','".$email."','".$mobile."','".$extraData."','".rand(1,3)."','".$bDay."','".rand(1,6)."',NOW(),".$rsvp.",'".$notes."')";
}

echo $sql;