<div class="dash_head">
    <p>
        From Seattle to Sydney, BlackBerry is bringing the show stopping talents of Creative Director and Grammy Award Winning singer songwriter Alicia Keys to the most exciting cities around the world, as she takes stage across 5 continents throughout 2013.
        <br /><br />
        We can’t wait for you to be part of the experience and join us on the road!
    </p>
</div>
<div class="dash_bottom">
    <div class="dash_content">
        <h3>Upcoming Tour Dates</h3>
        <? if(is_array($events)) foreach($events as $event): ?>
            <div class="dash_box" onclick="location.href='<?=SITE_ROOT?>event.overview/<?=$projectID?>/<?=$event['uid']?>'">
                <h3><?=date_format(date_create($event["start"]),"n/j")?></h3>
                <p><?=$event["title"]?><br />
            </div>
        <? endforeach; ?>
        <hr />
        <h3>News</h3>
		<?php if(is_array($updates)) foreach($updates as $update):?>
				<div class='dash_news'>
					<h4><span><?=$update['title']?></span><?=$update['timestamp']?></h4>
					<p><?=$update['description']?></p>
				</div>
			<?php endforeach;?>
			<?php if(checkPermission(array($projectID,'messages','send'))):?>
				<h5>Add Update Message</h5>
				<form accept-charset="UTF-8" class='form-horizontal' method='post' action='<?=SITE_ROOT?>project.dashboard/<?=$projectID?>'>
					<input type='hidden' name='action' value='addUpdate'>
					<div class='control-group row-fluid'>
						<label class='control-label'>Title</label>
						<div class='controls'>
							<input type='text' name='title' class='span12'>
						</div>
					</div>
					<div class='control-group row-fluid'>
						<label class='control-label'>Description</label>
						<div class='controls'>
							<textarea name='description' class='span12'></textarea>
						</div>
					</div>
					<button class='btn'>Add Update</button>
				</form>
			<?php endif;?>
        <hr />
        <h3>Hospitality</h3>
        <div class="dash_hosp">
            <img src="<?=SITE_ROOT?>img/dash_model.jpg" />
            <p>There’s nothing like sharing the exhilaration of the most anticipated concert of the year with your partners, associates friends and fans. Together, in an exclusive BlackBerry hospitality area– your guests will gather before legendary performer Alicia Keys takes center stage to enjoy drinks, appetizers and great conversation.</p>
            <p>This exclusive priority access offer can turn this concert to remember into a night you and your guests will never forget.</p>
            <p>To order your hospitality package please go to: <a href="http://BlackBerryPresentsAliciaKeys.com">http://BlackBerryPresentsAliciaKeys.com</a></p>
    </div>
</div>