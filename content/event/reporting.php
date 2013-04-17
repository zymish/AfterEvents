<?php require_once('event-nav.php'); ?>
<style>
	.report-table td:first-child,.image-row td:first-child{text-align:right;width:200px;}
	.report-table td:nth-child(2),.image-row td:nth-child(2){width:250px}
</style>
<div class='widget-box'>
    <div class='widget-title'>
        <ul class="nav nav-tabs">
            <li class="active"><a href="#report-form" data-toggle="tab">Report Form</a></li>
			<li><a href='#report-branding' data-toggle='tab'>Branding</a></li>
            <li><a href='#report-radio' data-toggle='tab'>Radio</a></li>
        </ul>
    </div>
	<form method="post" action="<?=SITE_ROOT?>event.reporting/<?=$projectID?>/<?=$eventID?>" enctype='multipart/form-data' accept-charset="UTF-8">
		<input type='hidden' name='action' value='saveReportData'>
		<div class='widget-content tab-content'>
			<div id="report-form" class="tab-pane active"><?php require_once(dirname(__FILE__)."/reporting-form.php") ?></div>
			<div id="report-branding" class="tab-pane"><?php require_once(dirname(__FILE__)."/reporting-branding.php") ?></div>
            <div id="report-radio" class="tab-pane"><?php require_once(dirname(__FILE__)."/reporting-radio.php") ?></div>
		</div>
	</form>
</div>