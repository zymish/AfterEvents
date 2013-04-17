<?php require_once('event-nav.php');?>
<?php if(!checkPermission(array($projectID,'events',$eventID,'messages','templates','view')))continue;?>
<div class='row-fluid' id='messaging-page'>
	<div class='span3'>
		<?php $sql = 'SELECT `uid`, `title` FROM messagesTemplates WHERE eventID = '.$eventID.'';
			$result = $db->query($sql);
			if($result):
				if($result->num_rows > 0):?>
					<table class='table table-striped table-bordered table-condensed table-hover'>
						<thead>
							<tr>
								<th>Title</th>
							</tr>
						</thead>
						<tbody>
							<?php while($row = $result->fetch_assoc()):?>
								<tr>
									<td><a href='#template-<?=$row['uid']?>' data-toggle='tab'><?=$row['title']?></a></td>
								</tr>
							<?php endwhile; ?>
						</tbody>
					</table>
				<?php else:?>
						<div class='alert alert-info'>There are no templates in the system.</div>
				<?php endif;
			endif;?>
	</div>
	<div class='span9'>
		<div class='tab-content'>
			<?php $sqlRoot = "SELECT * FROM messagesTemplates WHERE eventID = ".$eventID."";
			$result2 = $db->query($sqlRoot);
			if($result2):
				if($result->num_rows > 0):
					while($template = $result2->fetch_assoc()):?>
						<div class='tab-pane template-view' id='template-<?=$template['uid']?>'>
							<div class='form-horizontal'>
								<div class='control-group'>
									<label class='control-label'>Subject:</label>
									<div class='controls'>
										<input type='text' value="<?=$template['subject'];?>">
									</div>
								</div>
								<div class='control-group'>
									<label class='control-label'>Body:</label>
									<div class='controls'>
										<textarea rows='15'><?=$template['body']?></textarea>
									</div>
								</div>
							</div>
						</div>
					<?php endwhile;
				endif;
			endif;?>
		</div>
	</div>
</div>
<script type='text/javascript'>
function deleteConfirmTemplate(uid,title)
{
	bootbox.confirm('Are you sure you want to delete the template ' + title + '?',function(result){
		if(result) {
			bootbox.alert("You can't do that yet.");
		}
	});
}
</script>