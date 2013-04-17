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
                    <a href='<?= SITE_ROOT ?>event.overview/<?= $projectID ?>/<?= $event['uid'] ?>' class='thumbnail alert alert-success'>
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
                    <a href='<?= SITE_ROOT ?>event.overview/<?= $projectID ?>/<?= $event['uid'] ?>' class='thumbnail alert alert-info'>
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
                    <a href='<?= SITE_ROOT ?>event.overview/<?= $projectID ?>/<?= $event['uid'] ?>' class='thumbnail alert alert-warning'>
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