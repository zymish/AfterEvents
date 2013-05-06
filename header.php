<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?= DEFAULT_TITLE . " - ".((isset($site['pageTitle']) && !empty($site['pageTitle']))?$site['pageTitle']:'404') ?></title>
		<META http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta charset="UTF-8" />
        <meta name="description" content="ecPanel">
		<meta name="author" content="Boundless Ether, LLC">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        
        <link rel="icon" type="image/png" href="<?= SITE_ROOT ?>img/favicon.png">
        <link rel="stylesheet" type="text/css" media="screen" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css">
        
		<?php if(is_array($site['css'])) foreach($site['css'] as $file): ?>
			<link rel="stylesheet" href="<?= SITE_ROOT ?>css/<?= $file; ?>" />
		<?php endforeach; ?>

		<script src="<?= SITE_ROOT ?>js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <script src="<?= SITE_ROOT ?>js/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" media="screen" href="<?= SITE_ROOT ?>css/aftereve_custom.css">
	</head>
    <body>
    <?php 
	if(!isset($_SESSION['user']))
	{
		require_once('loginHeader.php');
		return;	
	}
	?>
    <div id="header">
			<h1><a href="<?= SITE_ROOT ?>">AfterEvents</a></h1>		
		</div>
		
		<div id="user-nav" class="navbar navbar-inverse">
            <ul class="nav btn-group">
				<?php if(isset($_SESSION['user'])): ?>
					<li class="btn btn-bb_header"><a title="" href="<?= SITE_ROOT ?>logout"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
				<?php else: ?>
					<li class="btn btn-bb_header"><a title="" href="<?= SITE_ROOT ?>login"><i class="icon icon-lock"></i> <span class="text">Login</span></a></li>
				<?php endif; ?>  
            </ul>
        </div> 
		<div id="sidebar">
				<ul>
					<li class="<?= ($site['page'][PAGE_INDEX] == "project/dashboard")?"active":""?>" title='Dashboard'>
						<a href="<?= SITE_ROOT ?>project.dashboard/<?= $projectID ?>"><i class="icon icon-dashboard"></i><span>DASHBOARD</span></a>
					</li>
                <?php if(checkPermission(array($projectID,'events','view'),true)): ?>
					<li class='<?= ($site['page'][PAGE_INDEX] == 'project/events' || substr($site['page'][PAGE_INDEX],0,5) == "event")?' active':''?>' title='Events'>
						<a href='<?= SITE_ROOT ?>project.events/<?= $projectID ?>'><i class='icon icon-calendar'></i><span>EVENTS</span></a>
					</li>
                <?php endif; ?>
                <?php if(checkPermission(array($projectID,'staff','view'),true)): ?>
                    <li class='<?= ($site['page'][PAGE_INDEX] == 'project/people')?'active':''?>' title='People'>
						<a href='<?= SITE_ROOT ?>project.people/<?= $projectID ?>'><i class='icon icon-group'></i><span>CONTACTS</span></a>
					</li>
                <?php endif; ?>
				<?php if(checkPermission(array($projectID,'reporting','view'),true)):?>
					<li class='<?=($site['page'][PAGE_INDEX] == 'project/reporting')?'active':''?>' title='Reporting'>
						<a href='<?=SITE_ROOT?>project.reporting/<?=$projetID?>'><i class='icon icon-check'></i><span>REPORTING</span></a>
					</li>
				<?php endif;?>
                <?php if(checkPermission(array($projectID,'ticketing','view'),true) && false): ?>
                    <li class='<?= ($site['page'][PAGE_INDEX] == 'project/ticketing')?'active':''?>' title='Ticketing'>
						<a href='<?= SITE_ROOT ?>project.ticketing/<?= $projectID ?>'><i class='icon icon-film'></i><span>TICKETING</span></a>
					</li>
                <?php endif; ?>
                <?php if(checkPermission(array($projectID,'hospitality','view'),true) && false): ?>
                    <li class='<?= ($site['page'][PAGE_INDEX] == 'project/hospitality')?'active':''?>' title='Ticketing'>
						<a href='<?= SITE_ROOT ?>project.hospitality/<?= $projectID ?>'><i class='icon icon-film'></i><span>HOSPITALITY</span></a>
					</li>
                <?php endif; ?>
                <?php if(checkPermission(array($projectID,'reporting','view',true)) && false): ?>
					<li class='<?= ($site['page'][PAGE_INDEX] == 'project/reporting')?'active':''?>' title='Reporting'>
						<a href='<?= SITE_ROOT ?>project.reporting/<?= $projectID ?>'><i class='icon icon-bar-chart'></i><span>REPORTING</span></a>
					</li>
                <?php endif; ?>
				</ul>
		</div>
        <div id="content">
        	<div id="content-header">
				<h1><?= (isset($site['pageTitle']) && !empty($site['pageTitle']))?$site['pageTitle']:'Afterevents Admin Panel'; ?></h1>
			</div>
			<div class="container-fluid">
            <?php if(is_array($errors)) foreach($errors as $error): ?>
				<div class="row-fluid">
                    <div class="alert alert-<?= $error['type'] ?>" style="margin:12px auto;">
                    <?php if(isset($error['icon'])):?><i class="<?= $error['icon'] ?>"></i>&nbsp;<?php endif; ?>
                    <?= $error['msg'] ?></div>
                </div>
			<?php endforeach; ?> 