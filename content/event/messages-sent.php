<?php require_once('event-nav.php');?>
<?php if(!checkPermission(array($projectID,'events',$eventID,'messages','sent','view')))continue;?>
<div class='row-fluid' id='messaging-page'>
	<div class='span12'>
		<?php $sql = 'SELECT * FROM messagesSent WHERE eventID = '.$eventID.'';
			$result = $db->query($sql);
			if($result):
				if($result->num_rows > 0):?>
					<table class='table table-striped table-bordered table-condensed table-hover'>
						<thead>
							<tr>
								<th style='width:100px;'>To</th>
								<th style='width:100px;'>From</th>
								<th style='width:200px;'>Subject</th>
								<th>Body</th>
							</tr>
						</thead>
						<tbody>
							<?php while($row = $result->fetch_assoc()):?>
								<tr>
									<td><?=$row['to']?></td>
									<td><?=$row['from']?></td>
									<td style='max-width:250px;' class='ellipsis'><?=$row['subject']?></td>
									<td style='max-width:300px;' class='ellipsis'><?=$row['body']?></td>
								</tr>
							<?php endwhile; ?>
						</tbody>
					</table>
				<?php else:?>
					<div class='alert alert-info'>There are no sent messages in the system.<div>
				<?php endif;
			endif;?>
	</div>
</div>