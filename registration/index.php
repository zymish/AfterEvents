<?php
require_once('../includes/startup.php');

$disableInputs = false;
$error = '';
if(isset($_REQUEST['invite']) && !empty($_REQUEST['invite']))
{
	$guest = $guestManager->getGuestByRegID($_REQUEST['invite']);
	if(!$guest)
	{
		$error = "<h2>Invalid invite code. Please make sure to follow the link in your registration email.</h2>";
		$disableInputs = true;
	}
	else
	{
		
		if($guest['rsvp'] != '')
		{
			$error = "<h2>This invite code has already been registered. If you wish to edit your registration information you will need to contact ".$guest['invitedBy']." at <a href='mailto:".$guest['invitedEmail']."'>".$guest['invitedEmail']."</a></h2>";	
			$disableInputs = true;
		}
		
	}
	
	if($_POST['action'] == 'confirm' && empty($error))
	{	
		$data = array(
			'firstName'		=> $_POST['firstName'],
			'lastName'		=> $_POST['lastName'],
			'email'			=> $_POST['email'],
			'mobile'			=> $_POST['mobile'],
			'rsvp'			=> '1',
			'registraionIP' => $_SERVER['REMOTE_ADDR'],
			'registered'	=> date('Y-m-d H:i:s')
		);
		
		if(!isset($_POST['tos']))
			$error = '<h2>You must agree to the terms of service before you can register.</h2>';
		else
		{
			$result = $guestManager->editGuest($guest['guestID'],$data);
			if($result)
			{
				// $sql = "SELECT `uid`,`subject`,`body`,`images` FROM `messagesTemplates` WHERE `projectID` = '1' AND `msgType` = 'rsvp-yes' LIMIT 1";
				// $result = $db->query($sql);
				// if($result && $template = $result->fetch_assoc())
				// {
					// $subject = $messageManager->prepareMessage($template['subject'],$guest['guestID'],$guest['eventID']);
					// $body = $messageManager->prepareMessage($template['body'],$guest['guestID'],$guest['eventID'],array('{subject}'=>$subject));
					// if($messageManager->send_email($data['firstName']." ".$data['lastName'], $data['email'], $subject, $body,$template['images']))
						// $error = 'Thank you. You should recieve a confirmation email shortly.';
						// $disableInputs = true;
				// }
				// if($db->error) error_log($db->error);
				$event = $eventManager->getEventByID($guest['eventID']);
				$venue = $eventManager->getVenueByID($event['venueID']);
				$error = "<h2>Thanks for registering, ".$guest['firstName'].".</h2>
				<p>You are now an official guest of the BlackBerry&reg; presents Alicia Keys 'Set the World on Fire' Tour.</p>
				<p>We are thrilled that you'll be joining us on ".date('F jS',strtotime($event['start']))." in ".$guest['eventName'].".</p>
				<p>Here are your event details:<br>
				Venue Information.<br>
				".$venue['name']."<br>
				".$venue['address']."<br>
				".$venue['phone']."<br>
				<a href='".$venue['website']."'>".$venue['website']."</a></p>
				<p>Tickets can be collected from BlackBerry VIP Will Call on the evening of the event, once doors open. To collect your ticket(s) please bring proof of ID, required for each guest.</p>
				<p>As a reminder, this invitation is non-transferable. Substitutions may be permitted, please contact your BlackBerry representative for details.<br>
				For complete registration terms and conditions, please go to <a href='https://blackberrypresentsaliciakeys.com/terms'>https://BlackBerryPresentsAliciaKeys.com/terms</a></p>
				<p>Please contact your business unit manager with any questions or concerns.</p>
				<p>We look forward to seeing you!</p>";
				unset($guest);
			}else 
			{
				$error = '<h2>Unable to edit guest record.</h2>';
				$disableInputs = true;
			}
		}
	}
}
else
	$error = "<h2>Missing invite code. Please make sure to follow the link in your registration email.</h2>";
?><!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Registration form</title>
		<script type='text/javascript' src='<?=SITE_ROOT?>js/jquery.min.js'></script>
		<script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js'></script>
		<script src='<?=SITE_ROOT?>js/bootbox.min.js'></script>
		<script src='<?=SITE_ROOT?>js/bootstrap.min.js'></script>
		<link rel='stylesheet' href='<?=SITE_ROOT?>css/bootstrap.min.css'>
        <style>
        body {
            margin: 0;
            text-align: center;
            font-family: Helvetica, Arial, sans-serif;
            color: #ffffff;
            background: #091d25;
        }
		
		p{text-align:left;padding: 4px 10px;}
		
		.bootbox .modal-body {
			color:#000000;
		}
        #wrapper {
            margin: 0 auto;
            width: 600px;
            background: #000000;
        }
        #wrapper h2 {
            font-size: 20px;
            font-weight: normal;
            margin: 50px 0px;
        }
        #wrapper h3 {
            font-size: 12px;
            font-weight: normal;
        }
        #wrapper form {
            margin: 45px auto 100px;
            width: 500px;
        }
        #wrapper label {
            width: 150px;
            margin: 0 10px 15px -100px;
            display: inline-block;
            text-align: right;
        }
        #wrapper input[type="text"] {
            width: 200px;
        }
        #wrapper button {
            margin: 35px 0 0;
        }
        #wrapper span {
            display: inline-block;
            width: 200px;
            text-align: left;
        }
        #wrapper span.tos {
            width: 100%;
            margin: 35px 0 0;
            text-align: center;
            font-size: 14px;
        }
        a {
            color: #00a8df;
        }
        </style>
    </head>
    <body>
        <div id="wrapper">
            <img src="<?=SITE_ROOT?>img/Reg_Header.jpg" />
            <?php if(isset($guest)): ?>
            <h2>You have been invited to <?= isset($guest,$guest['eventName'])?$guest['eventName']:'' ?> by <?= isset($guest,$guest['invitedBy'])?$guest['invitedBy']:'' ?>.</h2>
            <h3><?= !empty($error)?$error:"Please confirm your information and agree to the Terms of Service to receive your ticket." ?></h3>
            <p>
                <form action="" method="POST" id='guestRegForm'>
                	<input type="hidden" name="action" value="confirm">
                    <label for="email">Email:</label>
                    <input type="text" name="email" value="<?= isset($guest,$guest['email'])?$guest['email']:'' ?>" placeholder="email"<?= ($disableInputs == true)?"disabled":""?>>
                    <br>
                    <label for="firstname">First Name:</label>
                    <input type="text" name="firstName" placeholder="First name" value="<?= isset($guest,$guest['firstName'])?$guest['firstName']:'' ?>" <?= ($disableInputs == true)?"disabled":""?>>
                    <br>
                    <label for="lastname">Last Name:</label>
                    <input type="text" name="lastName" placeholder="Last name" value="<?= isset($guest,$guest['lastName'])?$guest['lastName']:'' ?>" <?= ($disableInputs == true)?"disabled":""?>>
                    <br>
                    <label for="phone">Phone:</label>
                    <input type="text" name="mobile" placeholder="Phone number" value="<?= isset($guest,$guest['mobile'])?$guest['mobile']:'' ?>" <?= ($disableInputs == true)?"disabled":""?>>
                    <br>
					<label for='ticketsNo'># of Tickets:</label>
					<span><?=isset($guest,$guest['ticketsNo'])?$guest['ticketsNo']:'1'?></span>
                    <br>
                    <span class="tos"><input type="checkbox" name="tos" <?= ($disableInputs == true)?"disabled":""?>>&nbsp; I have read and accept the <a href="#">Terms of Service</a></span>
                    <br>
                    <button type="button" <?= ($disableInputs == true)?"disabled":""?> id='submitButton'>Submit</button>
                </form>
            </p>
            <?php else: ?>
            <?= $error ?>
            <?php endif; ?>
            <img src="<?=SITE_ROOT?>img/Reg_Footer.jpg" />
        </div>
		<script type='text/javascript'>
			$('#submitButton').click(function(){
				var currentForm = $('#guestRegForm');
				currentForm.submit();
			});
		</script>
    </body>
</html>