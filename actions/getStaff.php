<?php
function check_email_address($email) {
  // First, we check that there's one @ symbol, 
  // and that the lengths are right.
  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
    // Email invalid because wrong number of characters 
    // in one section or wrong number of @ symbols.
    return false;
  }
  // Split it into sections to make life easier
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) {
    if
(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&
↪'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
$local_array[$i])) {
      return false;
    }
  }
  // Check if domain is IP. If not, 
  // it should be valid domain name
  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) {
        return false; // Not enough parts to domain
    }
    for ($i = 0; $i < sizeof($domain_array); $i++) {
      if
(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|
↪([A-Za-z0-9]+))$",
$domain_array[$i])) {
        return false;
      }
    }
  }
  return true;
}

$output = array();
if(isset($_REQUEST['q']) && !empty($_REQUEST['q']) && check_email_address($_REQUEST['q']))
{
	$output[] = array('id'=>0,'name'=>$_REQUEST['q']);
}
$output[] = array('id'=>1,'name'=>'Clark Kent');
$output[] = array('id'=>2,'name'=>'Bruce Wayne');
$output[] = array('id'=>3,'name'=>'Bruce Banner');
$output[] = array('id'=>4,'name'=>'Tony Stark');
$output[] = array('id'=>5,'name'=>'Zool');
$output[] = array('id'=>6,'name'=>'Steve Rogers');
$output[] = array('id'=>7,'name'=>'Bugs Bunny');
$output[] = array('id'=>8,'name'=>'Daffy Duck');
$output[] = array('id'=>9,'name'=>'Ash Ketchum');
$output[] = array('id'=>10,'name'=>'Danny DeVito');
$output[] = array('id'=>11,'name'=>'Wally West');
$output[] = array('id'=>12,'name'=>'Johnny Quest');
$output[] = array('id'=>13,'name'=>'Roger Rabbit');
$output[] = array('id'=>14,'name'=>'Bob The Builder');
$output[] = array('id'=>15,'name'=>'Optumus Prime');
$output[] = array('id'=>16,'name'=>'Wednesday Adams');
$output[] = array('id'=>17,'name'=>'Jessica Rabbit');
$output[] = array('id'=>18,'name'=>'Dinah Drake');
$output[] = array('id'=>19,'name'=>'Dinah Laurel Lance');
$output[] = array('id'=>20,'name'=>'Natasha Romanoff');
$output[] = array('id'=>21,'name'=>'Barbara Gordon');
$output[] = array('id'=>22,'name'=>'Cassandra Cain');
$output[] = array('id'=>23,'name'=>'Selina Kyle');
$output[] = array('id'=>24,'name'=>'Abby Chase');
$output[] = array('id'=>25,'name'=>'Beth Chapel');
$output[] = array('id'=>26,'name'=>'Rita Farr');
$output[] = array('id'=>27,'name'=>'Angelica Jones');
$output[] = array('id'=>28,'name'=>'Maria Mendoza');
$output[] = array('id'=>29,'name'=>'Mary Maxwell');

if(isset($_REQUEST['q']) && !empty($_REQUEST['q']))
{
	$display = array();
	foreach($output as $value)
	if(stripos($value['name'],$_REQUEST['q']) !== false)
	{
		$display[] = $value;
	}
	
	echo json_encode($display);
}else
	echo json_encode($output);
?>
