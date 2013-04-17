<style>
	.report-table td:first-child,.image-row td:first-child{text-align:right;width:200px;}
	.table.report-table td, .table.report-table th{border-top: none;}
	.thumbnail{width:200px;height: 150px;}
	.thumbnail img{max-height:150px;}
</style>
<div class='pull-right' style='position:relative;margin-top:-40px;'>
	<a class='btn btn-primary' href='<?=SITE_ROOT?>actions/generateEventReport.php?eventID=<?=$eventID?>' target='_blank'><i class='icon-download-alt'></i> Download Report</a>
</div>
<table class="table report-table">
	<legend>Quick Stats</legend>
	<tbody>
    	<tr>
        	<td>Total Tickets Allocated:</td>
            <td><?=$report['ticketsAllocated']?></td>
        </tr>
        <tr>
        	<td>RSVP's:</td>
            <td><?=$report['rsvpNo']?></td>
        </tr>
        <tr>
        	<td>Emails Sent:</td>
            <td><?=$report['sentEmails']?></td>
        </tr>
        <tr>
        	<td>Tickets Used:</td>
            <td><?=$report['ticketsUsed']?></td>
        </tr>
        <tr>
        	<td>Guests Attended:</td>
            <td><?=$report['guestsAttended']?></td>
        </tr>
    </tbody>
</table>

<hr>


<table class="table report-table">
	<legend>Overall Event Information</legend>
    <tbody>
    	<tr>
        	<td>Manager Name:</td>
			<td><?=$report['managerName']?></td>
        </tr>
        <tr>
        	<td>Venue:</td>
            <td><?=$report['venue']?></td>
        </tr>
        <tr>
        	<td>City:</td>
            <td><?=$report['city']?></td>
        </tr>
        <tr>
        	<td>Doors Open:</td>
            <td><?=$report['doorsOpen']?></td>
        </tr>
        <tr>
        	<td>Show Time / Event End:</td>
            <td><?=$report['doorsClose']?></td>
        </tr>
        <tr>
        	<td>Overall Event Attendance:</td>
            <td><?=$report['overallAttendance']?></td>
        </tr>
        <tr>
        	<td>Will Call Location:</td>
            <td><?=$report['willCallLoc']?></td>
        </tr>
        <tr>
        	<td>Tickets Allocated:</td>
            <td><?=$report['ticketsAllocated']?></td>
        </tr>
        <tr>
        	<td>RSVP Number:</td>
            <td><?=$report['rsvpNo']?></td>
        </tr>
        <tr>
        	<td>Tickets Used:</td>
            <td><?=$report['ticketsUsed']?></td>
        </tr>
        <tr>
        	<td>Avg Arrival Time:</td>
            <td><?=$report['avgArrivalTime']?></td>
        </tr>
        <tr>
        	<td>Weather:</td>
            <td><?php if(isset($report['weather'])) echo $report['weather']?></td>
        </tr>
		<tr>
        	<td>Guest Comments:</td>
            <td colspan="2">
            	<ul class="unstyled guest-comments-list">
					<?php if(!isset($report['guest-comment']) || !is_array($report['guest-comment']))
					$report['guest-comment'] = array('');
					foreach ($report['guest-comment'] as $guestComment):?>
						<li>
							<?=$guestComment;?>
						</li>
					<?php endforeach; ?>
            	</ul>
            </td>
        </tr>
        <tr>
        	<td>Manager Comments:</td>
            <td colspan="2">
            	<ul class="unstyled manager-comments-list">
					<?php if(!isset($report['manager-comment']) || !is_array($report['manager-comment']))
					$report['manager-comment'] = array('');
					foreach ($report['manager-comment'] as $managerComment):?>
						<li>
							<?=$managerComment;?>
						</li>
					<?php endforeach; ?>
            	</ul>
            </td>
        </tr>
	</tbody>
</table>
<table class="table report-table">
	<legend>Direct Engagement Numbers:</legend>
    <tbody>
        <tr>
        	<td>Number of Hubs:</td>
            <td><?=$report['deHubNo']?></td>
        </tr>
        <tr>
        	<td>Location:</td>
            <td><?=$report['deLocation']?></td>
        </tr>
        <tr>
        	<td># of Brand Ambassadors:</td>
            <td><?=$report['debaNo']?></td>
        </tr>
        <tr>
        	<td># of Demos:</td>
            <td><?=$report['deDemoNo']?></td>
        </tr>
        <tr>
        	<td>Estimated Dwell Time:</td>
            <td><?=$report['deDwellTime']?></td>
        </tr>
        <tr>
        	<td># of Photos Emailed:</td>
            <td><?=$report['dePhotos']?></td>
        </tr>
        <tr>
        	<td>Giveaways:</td>
            <td><?=$report['deGiveaways']?></td>
        </tr>
        <tr>
        	<td>Promotional Material:</td>
            <td><?=$report['dePromoMat']?></td>
        </tr>
        <tr>
        	<td>Activity Feedback:</td>
            <td><?=$report['deFeedback']?></td>
        </tr>
        <tr>
        	<td>Most Asked Questions:</td>
            <td colspan="2">
            	<ul class="unstyled faq-list">
					<?php if(!isset($report['faq']) || !is_array($report['faq']))
					$report['faq'] = array('');
					foreach ($report['faq'] as $faq):?>
						<li>
							<?=$faq;?>
						</li>
					<?php endforeach;?>
            	</ul>
            </td>
        </tr>
        <tr>
        	<td>Feedback:</td>
            <td colspan="2">
            	<ul class="unstyled feedback-list">
					<?php if(!isset($report['feedback']) || !is_array($report['feedback']))
						$report['feedback'] = array('');
						foreach ($report['feedback'] as $feedback):?>
							<li>
								<?=$feedback;?>
							</li>
						<?php endforeach;?>
            	</ul>
            </td>
        </tr>
	</tbody>
</table>
<table class="table report-table">
	<legend>Hospitality:</legend>
    <tbody>
        <tr>
        	<td>Location:</td>
            <td><?=$report['hospLoc']?></td>
        </tr>
        <tr>
        	<td>Type:</td>
            <td><?=$report['hospType']?></td>
        </tr>
        <tr>
        	<td># of Guests RSVP'd:</td>
			<td><?=$report['rsvpGuestNo']?></td>
        </tr>
        <tr>
        	<td># of Guests Attended:</td>
            <td><?=$report['guestsAttended']?></td>
        </tr>
        <tr>
        	<td>Guest Type:</td>
            <td><?=$report['guestType']?></td>
        </tr>
        <tr>
        	<td># of Ambassadors:</td>
            <td><?=$report['ambassNo']?></td>
        </tr>
        <tr>
        	<td>D&eacute;cor Used:</td>
            <td><?=$report['decor']?></td>
        </tr>
        <tr>
        	<td>Menu:</td>
            <td><?=$report['menu']?></td>
        </tr>
        <tr>
        	<td>Gift Bags:</td>
            <td><?=$report['giftBags']?></td>
        </tr>
	</tbody>
</table>
<table class="table report-table">
	<legend>Brand Ambassadors / Staffing:</legend>
    <tbody>
        <tr>
        	<td>Manager on Duty:</td>
            <td><?=$report['onDutyManager']?></td>
        </tr>
        <tr>
        	<td>Number of Brand Ambassadors:</td>
            <td><?=$report['ambassNo']?></td>
        </tr>
	</tbody>
</table>
<table class="table report-table">
	<legend>Radio:</legend>
    <tbody>
        <tr>
        	<td>Station Name:</td>
            <td><?=$report['stationName']?></td>
        </tr>
        <tr>
        	<td>Giveaway:</td>
            <td><?=$report['giveaway']?></td>
        </tr>
        <tr>
        	<td>Audio:</td>
            <td>
            	<ul class="unstyled inline">
                    <?php if(is_array($report['radioAudio']))
                        foreach($report['radioAudio'] as $i => $url): ?>
                    <li>&nbsp; <?=(!empty($url))?"<a href='".UPLOAD_URL.$projectID."/".$eventID."/".$url."' target='_blank'>Download File ".($i+1)."</a>":""?> &nbsp;</li>
                	 <?php endforeach; ?>
                </ul></td>
        </tr>
        <tr>
        	<td>Images:</td>
            <td colspan="2">
                <ul class="inline unstyled">
                    <?php if(!is_array($report['radioImg'])) $report['radioImg'] = array('','','');
                        for($i=3;$i>sizeof($report['radioImg']);$i)$report['radioImg'][] = '';
                        foreach($report['radioImg'] as $i => $url)
						if(!empty($url)):?>
							<li><div>
								<div class="thumbnail">
									<img src="<?=UPLOAD_URL.$projectID."/".$eventID."/".$url?>">
								</div>
							</div></li>
						<?php endif; ?>
                </ul>
            </td>
        </tr>
        <tr>
        	<td>Notes:</td>
            <td colspan="2"><?=$report['radioNotes']?></td>
        </tr>
	</tbody>
</table>
	<table class="table image-row report-branding-table">
		<legend>Branding:</legend>
		<tbody>
			<tr>
				<td>External Venue Branding:</td>
				<td>
					
					<?=$report['extBrandDetails']?>
					<ul class="inline unstyled">
						<?php if(!is_array($report['extBrandImg'])) $report['extBrandImg'] = array('','','');
							for($i=3;$i>sizeof($report['extBrandImg']);$i)$report['extBrandImg'][] = '';
							foreach($report['extBrandImg'] as $i => $url)
							if(!empty($url)):?>
								<li><div class="thumbnail">
										<img src="<?=UPLOAD_URL.$projectID."/".$eventID."/".$url?>">
									</div></li>
							<?php endif;?>
					</ul>
				</td>
			</tr>
			<tr>
				<td>Internal Venue Branding:</td>
				<td>
					
					<?=$report['intBrandDetails']?>
					<br>
					<ul class="inline unstyled">
						<?php if(!is_array($report['intBrandImg'])) $report['intBrandImg'] = array('','','');
							for($i=3;$i>sizeof($report['intBrandImg']);$i)$report['intBrandImg'][] = '';
							foreach($report['intBrandImg'] as $i => $url)
							if(!empty($url)):?>
								<li><div class="thumbnail">
										<img src="<?=UPLOAD_URL.$projectID."/".$eventID."/".$url?>">
									</div></li>
							<?php endif; ?>
					</ul>
				</td>
			</tr>
			<tr>
				<td>Concourse:</td>
				<td>
					
					<?=$report['concourseDetails']?>
					<br>
					<ul class="inline unstyled">
						<?php if(!is_array($report['concourseImg'])) $report['concourseImg'] = array('','','');
							for($i=3;$i>sizeof($report['concourseImg']);$i)$report['concourseImg'][] = '';
							foreach($report['concourseImg'] as $i => $url)
							if(!empty($url)):?>
								<li><div class="thumbnail">
										<img src="<?=UPLOAD_URL.$projectID."/".$eventID."/".$url?>">
									</div></li>
							<?php endif; ?>
					</ul>
				</td>
			</tr>
			<tr>
				<td>Jumbotron:</td>
				<td>
					
					<?=$report['jumboDetails']?>
					<br>
					<ul class="inline unstyled">
						<?php if(!is_array($report['jumboImg'])) $report['jumboImg'] = array('','','');
							for($i=3;$i>sizeof($report['jumboImg']);$i)$report['jumboImg'][] = '';
							foreach($report['jumboImg'] as $i => $url)
							if(!empty($url)):?>
								<li><div class="thumbnail">
										<img src="<?=UPLOAD_URL.$projectID."/".$eventID."/".$url?>">
									</div></li>
							<?php endif; ?>
					</ul>
				</td>
			</tr>
			<tr>
				<td>Stage Screens:</td>
				<td>
					
					<?=$report['stageDetails']?>
					<br>
					<ul class="inline unstyled">
						<?php if(!is_array($report['stageImg'])) $report['stageImg'] = array('','','');
							for($i=3;$i>sizeof($report['stageImg']);$i)$report['stageImg'][] = '';
							foreach($report['stageImg'] as $i => $url)
							if(!empty($url)):?>
								<li><div class="thumbnail">
										<img src="<?=UPLOAD_URL.$projectID."/".$eventID."/".$url?>">
									</div></li>
							<?php endif; ?>
					</ul>
				</td>
			</tr>
			<tr>
				<td>Additional Branding:</td>
				<td><?=$report['addtlBrandDetails']?>
					<br>
					<ul class="inline unstyled">
						<?php if(!is_array($report['addtlBrandImg'])) $report['addtlBrandImg'] = array('','','');
							for($i=3;$i>sizeof($report['addtlBrandImg']);$i)$report['addtlBrandImg'][] = '';
							foreach($report['addtlBrandImg'] as $i => $url)
							if(!empty($url)):?>
								<li><div class="thumbnail">
										<img src="<?=UPLOAD_URL.$projectID."/".$eventID."/".$url?>">
									</div></li>
							<?php endif; ?>
					</ul>
				</td>
			</tr>
			<tr>
				<td>Any Competitor Branding or Activity:</td>
				<td><?=$report['competeDetails']?>
					<br>
					<ul class="inline unstyled">
						<?php if(!is_array($report['competeImg'])) $report['competeImg'] = array('','','');
							for($i=3;$i>sizeof($report['competeImg']);$i)$report['competeImg'][] = '';
							foreach($report['competeImg'] as $i => $url)
							if(!empty($url)):?>
								<li><div class="thumbnail">
										<img src="<?=UPLOAD_URL.$projectID."/".$eventID."/".$url?>">
									</div></li>
							<?php endif; ?>
					</ul>
				</td>
			</tr>
		</tbody>
	</table>