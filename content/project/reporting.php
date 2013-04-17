<style>
	.quick-stats tr :nth-child(1){text-align:right;}
	.quick-stats tr :nth-child(2){text-align:left;font-weight:bold;}
</style>
<div class='row-fluid'>
	<div class="span4">
	<div class='widget-box'>
		<div class='widget-title'>
			<h5>Overall Event</h5>
		</div>
        <div class="widget-content nopadding">
			<table class="table quick-stats">
                <tbody>
                	<tr>
                        <td>Tickets Allocated:</td>
                        <td><?=$report['all']['tickets']?></td>
                    </tr>
                    <tr>
                        <td>Guests RSVP'd:</td>
                        <td><?=$report['all']['rsvp']?></td>
                    </tr>
                    <tr>
                        <td>Tickets Used:</td>
                        <td><?=$report['all']['used']?></td>
                    </tr>
                    <tr>
                        <td>Overall Event Attendance:</td>
                        <td><?=$report['all']['attendance']?></td>
                    </tr>
                    <tr>
                        <td>No of Demos:</td>
                        <td><?=$report['all']['demos']?></td>
                    </tr>
                    <tr>
                        <td>No of Photos:</td>
                        <td><?=$report['all']['photos']?></td>
                    </tr>
                    <tr>
                        <td>No of Hospitality Events:</td>
                        <td><?=$report['all']['hosp']?></td>
                    </tr>
                    <tr>
                        <td>No of Hospitality Guests:</td>
                        <td><?=$report['all']['hospGuests']?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    <div class="span4">
	<div class='widget-box'>
		<div class='widget-title'>
			<h5>US Events</h5>
		</div>
        <div class="widget-content nopadding">
			<table class="table quick-stats">
                <tbody>
                	<tr>
                        <td>Tickets Allocated:</td>
                        <td><?=$report['us']['tickets']?></td>
                    </tr>
                    <tr>
                        <td>Guests RSVP'd:</td>
                        <td><?=$report['us']['rsvp']?></td>
                    </tr>
                    <tr>
                        <td>Tickets Used:</td>
                        <td><?=$report['us']['used']?></td>
                    </tr>
                    <tr>
                        <td>Overall Event Attendance:</td>
                        <td><?=$report['us']['attendance']?></td>
                    </tr>
                    <tr>
                        <td>No of Demos:</td>
                        <td><?=$report['us']['demos']?></td>
                    </tr>
                    <tr>
                        <td>No of Photos:</td>
                        <td><?=$report['us']['photos']?></td>
                    </tr>
                    <tr>
                        <td>No of Hospitality Events:</td>
                        <td><?=$report['us']['hosp']?></td>
                    </tr>
                    <tr>
                        <td>No of Hospitality Guests:</td>
                        <td><?=$report['us']['hospGuests']?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    <div class="span4">
	<div class='widget-box'>
		<div class='widget-title'>
			<h5>Canadian Events</h5>
		</div>
        <div class="widget-content nopadding">
			<table class="table quick-stats">
                <tbody>
                	<tr>
                        <td>Tickets Allocated:</td>
                        <td><?=$report['can']['tickets']?></td>
                    </tr>
                    <tr>
                        <td>Guests RSVP'd:</td>
                        <td><?=$report['can']['rsvp']?></td>
                    </tr>
                    <tr>
                        <td>Tickets Used:</td>
                        <td><?=$report['can']['used']?></td>
                    </tr>
                    <tr>
                        <td>Overall Event Attendance:</td>
                        <td><?=$report['can']['attendance']?></td>
                    </tr>
                    <tr>
                        <td>No of Demos:</td>
                        <td><?=$report['can']['demos']?></td>
                    </tr>
                    <tr>
                        <td>No of Photos:</td>
                        <td><?=$report['can']['photos']?></td>
                    </tr>
                    <tr>
                        <td>No of Hospitality Events:</td>
                        <td><?=$report['can']['hosp']?></td>
                    </tr>
                    <tr>
                        <td>No of Hospitality Guests:</td>
                        <td><?=$report['can']['hospGuests']?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>

<?php if(is_array($events['past']) && sizeof($events['past']) > 0): ?>
<div class='row-fluid'>
	<div class="span12">
	<div class='widget-box'>
		<div class='widget-title'>
			<h5>Past Events</h5>
		</div>
        <div class="widget-content">
            <ul class='thumbnails'>
			<?php
			$count = 0;
			foreach($events['past'] as $event):	
				if($count % 6 == 0) echo"	</ul><ul class='thumbnails'>\n";
				$count++;
			?>
                <li class='span2'>
                    <a href='<?= SITE_ROOT ?>event.reporting-view/<?= $projectID ?>/<?= $event['uid'] ?>' class='thumbnail alert alert-warning' title='Print Report for <?=$event['title']?>'>
                        <h2 class='alert-warning'><?= date('n/j',strtotime($event['start'])) ?></h2>
                        <?= $event['title'] ?>
                    </a>
                </li>
            <?php endforeach; ?>
            </ul>   
        </div>
    </div>
    </div>
</div>
<?php endif; ?>

<div class='row-fluid'>
	<div class="span12">
	<div class='widget-box'>
		<div class='widget-title'>
			<h5>Upcoming Events</h5>
		</div>
        <div class="widget-content">
            <ul class='thumbnails'>
            <?php 
			$count = 0;
			if(is_array($events['upcoming']))
			foreach($events['upcoming'] as $event):	
				if($count % 6 == 0) echo"	</ul><ul class='thumbnails'>\n";
				$count++;
			?>
                <li class='span2'>
                    <a href='<?= SITE_ROOT ?>event.reporting-view/<?= $projectID ?>/<?= $event['uid'] ?>' class='thumbnail alert alert-success' title='Print Report for <?=$event['title']?>'>
                        <h2 class='alert-success'><?= date('n/j',strtotime($event['start'])) ?></h2>
                        <?= $event['title'] ?>
                    </a>
                </li>
            <?php 
			endforeach;
			
			if(is_array($events['distant']))
			foreach($events['distant'] as $event):	
				if($count % 6 == 0) echo"	</ul><ul class='thumbnails'>\n";
				$count++;
			?>
                <li class='span2'>
                    <a href='<?= SITE_ROOT ?>event.reporting-view/<?= $projectID ?>/<?= $event['uid'] ?>' class='thumbnail alert alert-info' title='Print Report for <?=$event['title']?>'>
                        <h2 class='alert-info'><?= date('n/j',strtotime($event['start'])) ?></h2>
                        <?= $event['title'] ?>
                    </a>
                </li>
            <?php endforeach; ?>
			</ul>  
        </div>
    </div>
    </div>
</div>