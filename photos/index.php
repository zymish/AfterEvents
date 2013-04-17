<?php
require_once('../includes/startup.php');

$showGallery = false;

if(isset($_REQUEST['eventCode'],$_REQUEST['password'])):
	$eventCode = $_REQUEST['eventCode'];
	$password = $_REQUEST['password'];
	if(in_array($password,array('Kr5ggM923','yNB46W2A'))):
		if($password == 'Kr5ggM923')
			$type = 'concourse';
		else
			$type = 'meetGreet';
			
		$event = $eventManager->getEventByAppID($eventCode);
		if($event):
			$showGallery = true;
			$eventID = $event['uid'];
			$projectID = $event['projectID'];
		endif;
	endif;
else:

endif;

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>BlackBerry Presents Alicia Keys - Photos</title>
    <meta charset="UTF-8" />
    <meta name="description" content="ecPanel">
    <meta name="author" content="Boundless Ether, LLC">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <link rel="icon" type="image/png" href="<?= SITE_ROOT ?>img/favicon.png">
    <link rel="stylesheet" type="text/css" media="screen" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css">
    <link rel='stylesheet' href='<?=SITE_ROOT?>css/bootstrap.min.css'>
	<link rel='stylesheet' href='<?=SITE_ROOT?>css/bootstrap-responsive.min.css'>
    <link rel="stylesheet" type="text/css" media="screen" href="<?= SITE_ROOT ?>css/bbak_custom.css">
    
    <script type='text/javascript' src='<?=SITE_ROOT?>js/jquery.min.js'></script>
</head>
<body>
	<div id="logo" style="margin:50px auto 15px auto;text-align:center;">
    <img src="<?= SITE_ROOT ?>img/logo.png" alt="BlackBerry" />
</div>

<?php if(!$showGallery):?>
	<div id="login_box">
		<form id="loginform" class="form-vertical" action="" method="GET">
			<input type="hidden" name="action" value="login">
			<div class="input-prepend">
				<span class="add-on"><i class="icon-globe"></i></span><input type="text" placeholder="Event Code" name="eventCode">
			</div>
			<div class="input-prepend">
				<span class="add-on"><i class="icon-lock"></i></span><input type="password" placeholder="Password" name="password">
			</div>
			<input type="submit" class="btn btn-inverse" value="View Photos">
		</form>
	</div>
<?php else:?>
	<?php require_once('gallery.php');?>
<?php endif;?>

<script src='<?=SITE_ROOT?>js/bootbox.min.js'></script>
<script src='<?=SITE_ROOT?>js/bootstrap.min.js'></script>
</body>
</html>