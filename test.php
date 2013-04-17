<?php if($_REQUEST['canIdoIt'] == 'yes')phpinfo(); exit;
//This script was used to insert a lot of staff members across multiple events.
require_once('includes/startup.php');

echo emailStrip('STsdif!@#$%1531234@asdjjiv.com');
/*
$_SESSION['user']['uid'] = 1;

$buList = array(
	"19"=>"EMEA Events",
	"20"=>"Verizon Wireless",
	"21"=>"Sprint",
	"22"=>"T-Mobile",
	"24"=>"AT&amp;T",
	"25"=>"TSM",
	"26"=>"Neal FM",
	"27"=>"Ashley FM",
	"28"=>"Enterprise",
	"29"=>"Canadian Channel",
	"30"=>"C Level",
	"31"=>"Employee",
	"32"=>"Media",
	"33"=>"Global Events"
);

$events = array(
	"19"=>array(),
	"20"=>array(1,3,4,5,6,7,8,9),
	"21"=>array(3,4,5,6,7,8,9),
	"22"=>array(1,3,4,5,6,7,8,9),
	"24"=>array(1,3,4,5,6,7,8,9),
	"25"=>array(1,3,4,5,6,7,8,9),
	"26"=>array(1,3,4,5,6,7,8,9),
	"27"=>array(1,3,4,5,6,7,8,9),
	"28"=>array(1,3,4,5,6,7,8,9),
	"29"=>array(2),
	"30"=>array(4),
	"31"=>array(),
	"32"=>array(),
	"33"=>array(2,3,4,5,6,7,8,9)
);


$sql = "SELECT * FROM `eventStaffGroups` WHERE `title` = 'BlackBerry BU'";
$result = $db->query($sql);
if($result)
while($staffGroup = $result->fetch_assoc())
{
	foreach($buList as $userID => $bu)
	{
		if(!in_array($staffGroup['eventID'],$events[$userID])) continue;
		
		$user = $userManager->getUserByID($userID);
		$staffInfo = array(
			'firstName'			=> $user['firstName'],
			'lastName'			=> $user['lastName'],
			'email'				=> $user['email'],
			'businessUnit'		=> $bu,
		);
		$data = array(
			'eventID'		=> $staffGroup['eventID'],
			'userID'		=> $userID,
			'staffInfo' 	=> json_encode($staffInfo),
			'staffGroupID'	=> $staffGroup['uid']
		);
		
		$staffManager->addStaff($data);
	}
}*/