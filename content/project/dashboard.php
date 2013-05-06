<div class="dash_head">
    <p>Tell everyone about your project. This is the place to include a quick overview to get people excited about what you're planning!</p>
	<p>You can supply whatever background image you like.</p>
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
</div>