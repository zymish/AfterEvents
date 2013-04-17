<?php require_once('event-nav.php');?>
<?php if(!checkPermission(array($projectID,'events',$eventID,'messages','view')))continue;?>
<?php $nav = $_GET['nav'];?>
<div class='widget-box'>
    <div class='widget-title'>
        <ul class="nav nav-tabs">
        	<li class="<?=(!isset($nav) || $nav == '')?'active':''?>"><a href="#event-updates" data-toggle="tab">Event Updates</a></li>
			<?php if(checkPermission(array($projectID,'events',$eventID,'messages','send'))):?>
				<li class="<?=($nav == 'sendEmail')?'active':''?>"><a href='#sendEmail' data-toggle='tab'>Send Email</a></li>
			<?php endif;?>
			<?php if(checkPermission(array($projectID,'events',$eventID,'sms','send'))):?>
				<li><a href='#sendSMS' data-toggle='tab'>Send SMS</a></li>
			<?php endif;?>
			<?php if(checkPermission(array($projectID,'events',$eventID,'messages','templates','view')) && false):?>
				<li><a href='#templates' data-toggle='tab'>Email / SMS Templates</a></li>
            <?php endif;?>
			<?php if(checkPermission(array($projectID,'events',$eventID,'messages','sent','view')) && false):?>
				<li><a href='#sent' data-toggle='tab'>Sent Email / SMS Messages</a></li>
            <?php endif;?>
        </ul>
    </div>
    <div class='widget-content tab-content nopadding'>
        <div id="event-updates" class="tab-pane <?=(!isset($nav) || $nav == '')?'active':''?>"><?php require_once(dirname(__FILE__)."/messages-eventUpdates.php")?></div>
		<?php if(checkPermission(array($projectID,'events',$eventID,'messages','send'))):?>
			<div id='sendEmail' class='tab-pane <?=($nav == 'sendEmail')?'active':''?>'><?php require_once(dirname(__FILE__).'/messages-sendEmail.php')?></div>
		<?php endif; ?>
		<?php if(checkPermission(array($projectID,'events',$eventID,'sms','send'))):?>
			<div id='sendSMS' class='tab-pane '><?php require_once(dirname(__FILE__).'/messages-sendSMS.php')?></div>
		<?php endif; ?>
		<?php if(checkPermission(array($projectID,'events',$eventID,'messages','templates','view')) && false):?>
			<div id='templates' class='tab-pane'><?php require_once(dirname(__FILE__)."/messages-templates.php")?></div>
        <?php endif;?>
		<?php if(checkPermission(array($projectID,'events',$eventID,'messages','sent','view')) && false):?>
			<div id='sent' class='tab-pane'><?php require_once(dirname(__FILE__)."/messages-sent.php")?></div>
        <?php endif;?>
    </div>
</div>