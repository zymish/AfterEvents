<div style='position:relative;margin-top:-40px;' class="pull-right">
<form accept-charset="UTF-8" action="" method="POST" id="viewAsForm">
<?php if(checkPermission(array($projectID,'events',$eventID,'edit')) && ($site['page'][PAGE_INDEX] == 'event/overview' || $site['page'][PAGE_INDEX] == 'event/venue')): ?>
	<a href="<?= SITE_ROOT ?>event.edit/<?= $projectID ?>/<?= $eventID ?>" class="btn btn-primary"><i class="icon-edit"></i> Edit Event</a>
<?php endif; ?>
<?php if(checkPermission(array($projectID,'events',$eventID,'staff','viewAs'),true)): ?>
	
        &nbsp; | &nbsp; Manage Event as... 
        <select class="input-large" name="viewAs" onChange="$('#viewAsForm').submit()">
            <option value="<?=getCurrentUserID(true)?>" <?=(!isset($_SESSION['viewAs']))?"selected":""?>>Me (<?=$_SESSION['user']['name']?>)</option>
        <?php
			$viewAsStaff = $staffManager->getEventStaffByGroup($eventID);
			if(is_array($viewAsStaff))
			foreach($viewAsStaff as $member): ?>
            <option value="<?=$member['userID']?>" <?=($_SESSION['viewAs']['uid'] == $member['userID'])?"selected":""?>><?=$member['businessUnit']?></option>
		<?php endforeach; ?>
        </select>    
<?php endif; ?>
</form>
</div>
<div class="navbar">
    <div class="navbar-inner">
        <ul class='nav'>
            <li class="<?= ($site['page'][PAGE_INDEX] == "event/overview")?"active":""?>"><a href='<?= SITE_ROOT ?>event.overview/<?= $projectID ?>/<?= $eventID ?>'>
            	Overview</a></li>
            <li class="<?= ($site['page'][PAGE_INDEX] == "event/venue")?"active":""?>"><a href='<?= SITE_ROOT ?>event.venue/<?= $projectID ?>/<?= $eventID ?>'>
            	Venue</a></li>
        <?php if(checkPermission(array($projectID,'events',$eventID,'contacts','view'))): ?>
            <li class="<?= (substr($site['page'][PAGE_INDEX],0,11) == "event/contacts")?"active":""?>"><a href='<?= SITE_ROOT ?>event.contacts/<?= $projectID ?>/<?= $eventID ?>'>
            	Contacts</a></li>
        <?php endif; ?>
        <?php if(checkPermission(array($projectID,'events',$eventID,'tickets','view'))): ?>
            <li class="<?= (substr($site['page'][PAGE_INDEX],0,12) == "event/ticket")?"active":""?>"><a href='<?= SITE_ROOT ?>event.tickets/<?= $projectID ?>/<?= $eventID ?>'>
            	Ticketing</a></li>
        <?php endif; ?>
        <?php if(checkPermission(array($projectID,'events',$eventID,'guests','view'))): ?>
            <li class="<?= (substr($site['page'][PAGE_INDEX],0,11) == "event/guest")?"active":""?>"><a href='<?= SITE_ROOT ?>event.guests/<?= $projectID ?>/<?= $eventID ?>'>
            	Guests</a></li>
        <?php endif; ?>
        <?php if(checkPermission(array($projectID,'events',$eventID,'hospitality','view'))): ?>
            <li class="<?= (substr($site['page'][PAGE_INDEX],0,17) == "event/hospitality")?"active":""?>"><a href='<?= SITE_ROOT ?>event.hospitality/<?= $projectID ?>/<?= $eventID ?>'>
            	Hospitality</a></li>
        <?php endif; ?>
        <?php if(checkPermission(array($projectID,'events',$eventID,'messages','view'))): ?>
            <li class="<?= (substr($site['page'][PAGE_INDEX],0,13) == "event/message")?"active":""?>"><a href='<?= SITE_ROOT ?>event.messages/<?= $projectID ?>/<?= $eventID ?>'>
            	Messaging</a></li>
        <?php endif; ?>
        <?php if(checkPermission(array($projectID,'events',$eventID,'media','view')) && false): ?>
            <li class="<?= (substr($site['page'][PAGE_INDEX],0,11) == "event/media")?"active":""?>"><a href='<?= SITE_ROOT ?>event.media/<?= $projectID ?>/<?= $eventID ?>'>
            	Media</a></li>
        <?php endif; ?>
        <?php if(checkPermission(array($projectID,'events',$eventID,'staff','view'))): ?>
            <li class="<?= (substr($site['page'][PAGE_INDEX],0,11) == "event/staff")?"active":""?>"><a href='<?= SITE_ROOT ?>event.staff/<?= $projectID ?>/<?= $eventID ?>'>
            	Staffing</a></li>
        <?php endif; ?>		
        <?php if(checkPermission(array($projectID,'events',$eventID,'reporting','view'))): ?>
            <li class="<?= (substr($site['page'][PAGE_INDEX],0,12) == "event/report")?"active":""?>"><a href='<?= SITE_ROOT ?>event.reporting/<?= $projectID ?>/<?= $eventID ?>'>
            	Reporting</a></li>
        <?php endif; ?>
        </ul>
    </div>
</div>
<br>