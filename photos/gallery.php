<div class='container-fluid' id='photo-gallery'>
	<h3><?=$event['title']?></h3>
    
<?php
$thumbURL = UPLOAD_URL.$projectID.'/'.$eventID.'/'.$type.'/thumbnail/';
$fullURL = UPLOAD_URL.$projectID.'/'.$eventID.'/'.$type.'/';
$i = 0;
$count = 0;
if (file_exists(UPLOAD_PATH.$projectID.'/'.$eventID.'/'.$type.'/thumbnail') && $handle = opendir(UPLOAD_PATH.$projectID.'/'.$eventID.'/'.$type.'/thumbnail')) {
    while (false !== ($entry = readdir($handle))) {
    	if(in_array($entry,array(".",".."))) continue;
    	
		if($i-- == 0):
			$i = 5;
			if($count > 0): ?>
		</ul>
	</div>
<?php		endif;?>
	<div class='row-fluid'>
		<ul class='thumbnails'>
<?php	endif; ?>
			<li class='span2'>
				<a href='<?=$fullURL.$entry?>' target="_blank" class='thumbnail'>
					<img src='<?=$thumbURL.$entry?>'>
				</a>
			</li>
<?php	$count++;
    }
    closedir($handle);
}
?>
    
</div>