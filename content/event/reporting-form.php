<table class="table report-table">
	<legend>Overall Event Information</legend>
	<thead>
    	<tr>
        	<th nowrap>&nbsp;</th>
            <th nowrap>New Value</th>
            <th nowrap>Server Value</th>
        </tr>
    </thead>
    <tbody>
    	<tr>
        	<td>Manager Name:</td>
            <td><input type="text" value="<?=(isset($report['managerName']))?$report['managerName']:""; ?>" class="input-block-level" name='managerName'></td>
            <td><span></span></td>
        </tr>
        <tr>
        	<td>Venue:</td>
            <td><input type="text" value="<?=(isset($report['venue']))?$report['venue']:""; ?>" class="input-block-level" name='venue'></td>
            <td><div class="help-inline"><?= $generated['venue']?></div></td>
        </tr>
        <tr>
        	<td>City:</td>
            <td><input type="text" value="<?=(isset($report['city']))?$report['city']:""; ?>" class="input-block-level" name='city'></td>
            <td><div class="help-inline"><?= $generated['city']?></div></td>
        </tr>
        <tr>
        	<td>Doors Open:</td>
            <td><input type="text" value="<?=(isset($report['doorsOpen']))?$report['doorsOpen']:""; ?>" class="input-block-level" name='doorsOpen'></td>
            <td><div class="help-inline"><?=$generated['doorsOpen']?></div></td>
        </tr>
        <tr>
        	<td>Show Time / Event End:</td>
            <td><input type="text" value="<?=(isset($report['showTime']))?$report['showTime']:""; ?>" class="input-block-level" name='showtime'></td>
            <td><div class="help-inline"><?=$generated['showTime']?></div></td>
        </tr>
        <tr>
        	<td>Overall Event Attendance:</td>
            <td><input type="text" value="<?=(isset($report['overallAttendance']))?$report['overallAttendance']:""; ?>" class="input-block-level"  name='overallAttendance'></td>
            <td><div class="help-inline"><?=$generated['overallAttendance']?></div></td>
        </tr>
        <tr>
        	<td>Will Call Location:</td>
            <td><input type="text" value="<?=(isset($report['willCallLoc']))?$report['willCallLoc']:""; ?>" class="input-block-level" name='willCallLoc'></td>
            <td><div class="help-inline"><?=$generated['willCallLoc']?></div></td>
        </tr>
        <tr>
        	<td>Tickets Ordered:</td>
            <td><input type="text" value="<?=(isset($report['ticketsOrdered']))?$report['ticketsOrdered']:""; ?>" class="input-block-level" name='willCallLoc'></td>
            <td><div class="help-inline"><?=$generated['ticketsOrdered']?></div></td>
        </tr>
        <tr>
        	<td>Tickets Assigned:</td>
            <td><input type="text" value="<?=(isset($report['ticketsAllocated']))?$report['ticketsAllocated']:""; ?>" class="input-block-level" name='ticketsAllocated'></td>
            <td><div class="help-inline"><?=$generated['ticketsAllocated']?></div></td>
        </tr>
        <tr>
        	<td>RSVP Via System:</td>
            <td><input type="text" value="<?=(isset($report['rsvpNo']))?$report['rsvpNo']:""; ?>" class="input-block-level" name='rsvpNo'></td>
            <td><div class="help-inline"><?=$generated['rsvpNo']?></div></td>
        </tr>
        <tr>
        	<td>Tickets Used:</td>
            <td><input type="text" value="<?=(isset($report['ticketsUsed']))?$report['ticketsUsed']:""; ?>" class="input-block-level" name='ticketsUsed'></td>
            <td><div class="help-inline"><?=$generated['ticketsUsed']?></div></td>
        </tr>
        <tr>
        	<td>Avg Arrival Time:</td>
            <td><input type="text" value="<?=(isset($report['avgArrivalTime']))?$report['avgArrivalTime']:""; ?>" class="input-block-level" name='avgArrivalTime'></td>
            <td><div class="help-inline"><?=$generated['avgArrivalTime']?></div></td>
        </tr>
        <tr>
        	<td>Weather:</td>
            <td><input type="text" value="<?=(isset($report['weather']))?$report['weather']:""; ?>" class="input-block-level" name='weather'></td>
            <td><div class='help-inline'><?=$generated['weather']?></div></td>
        </tr>
		<tr>
        	<td>Guest Comments:</td>
            <td colspan="2">
            	<ul class="unstyled guest-comments-list">
					<?php if(!isset($report['guest-comment']) || !is_array($report['guest-comment']))
							$report['guest-comment'] = array('');

					foreach ($report['guest-comment'] as $guestComment):?>
						<li>
							<div class="input-append">
								<input type="text" value="<?=$guestComment;?>" class="input-xxlarge" name='guest-comment[]'>
								<button type='button' class="btn btn-danger" onclick='removeComment(this)'><i class="icon-remove"></i></button>
							</div>
						</li>
					<?php endforeach; ?>
            	</ul>
               	<button type='button' class="btn btn-info btn-mini" onclick="addNewRow('.guest-comments-list','guest-comment[]')">Add More...</button>
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
							<div class="input-append">
								<input type="text" value="<?=$managerComment;?>" class="input-xxlarge" name='manager-comment[]'>
								<button type='button' class="btn btn-danger" onclick='removeComment(this)'><i class="icon-remove"></i></button>
							</div>
						</li>
					<?php endforeach; ?>
            	</ul>
               	<button type='button' class="btn btn-info btn-mini" onclick="addNewRow('.manager-comments-list','manager-comment[]')">Add More...</button>
            </td>
        </tr>
	</tbody>
</table>

<table class="table report-table">
	<legend>Direct Engagement Numbers:</legend>
	<thead>
    	<tr>
        	<th nowrap>&nbsp;</th>
            <th nowrap>New Value</th>
            <th nowrap>Server Value</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        	<td>Number of Hubs:</td>
            <td><input type="text" value="<?=(isset($report['deHubNo']))?$report['deHubNo']:"" ?>" class="input-block-level" name='deHubNo'></td>
            <td><div class="help-inline"><?=$generated['deHubNo']?></div></td>
        </tr>
        <tr>
        	<td>Location:</td>
            <td><input type="text" value="<?=(isset($report['deLocation']))?$report['deLocation']:"" ?>" class="input-block-level" name='deLocation'></td>
            <td><div class='help-inline'><?=$generated['deLocation']?></div></td>
        </tr>
        <tr>
        	<td># of Brand Ambassadors:</td>
            <td><input type="text" value="<?=(isset($report['debaNo']))?$report['debaNo']:"" ?>" class="input-block-level" name='debaNo'></td>
            <td><div class="help-inline"><?=$generated['debaNo']?></div></td>
        </tr>
        <tr>
        	<td># of Demos:</td>
            <td><input type="text" value="<?=(isset($report['deDemoNo']))?$report['deDemoNo']:"" ?>" class="input-block-level" name='deDemoNo'></td>
            <td><div class="help-inline"><?=$generated['deDemoNo']?></div></td>
        </tr>
        <tr>
        	<td>Estimated Dwell Time:</td>
            <td><input type="text" value="<?=(isset($report['deDwellTime']))?$report['deDwellTime']:"" ?>" class="input-block-level" name='deDwellTime'></td>
            <td><div class="help-inline"><?=$generated['deDwellTime']?></div></td>
        </tr>
        <tr>
        	<td># of Photos Emailed:</td>
            <td><input type="text" value="<?=(isset($report['dePhotos']))?$report['dePhotos']:"" ?>" class="input-block-level" name='dePhotos'></td>
            <td><div class="help-inline"><?=$generated['dePhotos']?></div></td>
        </tr>
        <tr>
        	<td>Giveaways:</td>
            <td><input type="text" value="<?=(isset($report['deGiveaways']))?$report['deGiveaways']:"" ?>" class="input-block-level" name='deGiveaways'></td>
            <td><div class="help-inline"><?=$generated['deGiveaways']?></div></td>
        </tr>
        <tr>
        	<td>Promotional Material:</td>
            <td><input type="text" value="<?=(isset($report['dePromoMat']))?$report['dePromoMat']:"" ?>" class="input-block-level" name='dePromoMat'></td>
            <td><div class="help-inline"><?=$generated['dePromoMat']?></div></td>
        </tr>
        <tr>
        	<td>Activity Feedback:</td>
            <td><input type="text" value="<?=(isset($report['deFeedback']))?$report['deFeedback']:"" ?>" class="input-block-level" name='deFeedback'></td>
            <td><div class="help-inline"><?=$generated['deFeedback']?></div></td>
        </tr>
        <tr>
        	<td>Most Asked Questions:</td>
            <td colspan="2">
            	<ul class="unstyled faq-list">
					<?php if(!isset($report['faq']) || !is_array($report['faq']))
							$report['faq'] = array('');

					foreach ($report['faq'] as $faq):?>
						<li>
							<div class="input-append">
								<input type="text" value="<?=$faq;?>" class="input-xxlarge" name='faq[]'>
								<button type='button' class="btn btn-danger" onclick='removeComment(this)'><i class="icon-remove"></i></button>
							</div>
						</li>
					<?php endforeach;?>
            	</ul>
				<button type='button' class="btn btn-info btn-mini" onclick="addNewRow('.faq-list','faq[]')">Add More...</button>
            </td>
        </tr>
        <tr>
        	<td>Feedback:</td>
            <td colspan="2">
            	<ul class="unstyled feedback-list">
					<?php  if(!isset($report['feedback']) || !is_array($report['feedback']))
							$report['feedback'] = array('');

					foreach ($report['feedback'] as $feedback):?>
						<li>
							<div class="input-append">
								<input type="text" value="<?=$feedback;?>" class="input-xxlarge" name='feedback[]'>
								<button type='button' class="btn btn-danger" onclick='removeComment(this)'><i class="icon-remove"></i></button>
							</div>
						</li>
					<?php endforeach;?>
            	</ul>
				<button type='button' class="btn btn-info btn-mini" onclick="addNewRow('.feedback-list','feedback[]')">Add More...</button>
            </td>
        </tr>
	</tbody>
</table>

<table class="table report-table">
	<legend>Hospitality:</legend>
	<thead>
    	<tr>
        	<th nowrap>&nbsp;</th>
            <th nowrap>New Value</th>
            <th nowrap>Server Value</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        	<td>Location:</td>
            <td><input type="text" value="<?=(isset($report['hospLoc']))?$report['hospLoc']:"" ?>" class="input-block-level" name='hospLoc'></td>
            <td><div class="help-inline"><?=$generated['hospLoc']?></div></td>
        </tr>
        <tr>
        	<td>Type:</td>
            <td><input type="text" value="<?=(isset($report['hospType']))?$report['hospType']:"" ?>" class="input-block-level" name='hospType'></td>
            <td><div class="help-inline"><?=$generated['hospType']?></div></td>
        </tr>
        <tr>
        	<td># of Guests RSVP'd:</td>
			<td><input type="text" value="<?=(isset($report['rsvpGuestNo']))?$report['rsvpGuestNo']:"" ?>" class="input-block-level" name='rsvpGuestNo'></td>
            <td><div class="help-inline"><?=$generated['rsvpGuestNo']?></div></td>
        </tr>
        <tr>
        	<td># of Guests Attended:</td>
            <td><input type="text" value="<?=(isset($report['guestsAttended']))?$report['guestsAttended']:"" ?>" class="input-block-level" name='guestsAttended'></td>
            <td><div class="help-inline"><?=$generated['guestsAttended']?></div></td>
        </tr>
        <tr>
        	<td>Guest Type:</td>
            <td><input type="text" value="<?=(isset($report['guestType']))?$report['guestType']:"" ?>" class="input-block-level" name='guestType'></td>
            <td><div class="help-inline"><?=$generated['guestType']?></div></td>
        </tr>
        <tr>
        	<td># of Ambassadors:</td>
            <td><input type="text" value="<?=(isset($report['ambassNo']))?$report['ambassNo']:"" ?>" class="input-block-level" name='ambassNo'></td>
            <td><div class="help-inline"><?=$generated['ambassNo']?></div></td>
        </tr>
        <tr>
        	<td>D&eacute;cor Used:</td>
            <td><input type="text" value="<?=(isset($report['decor']))?$report['decor']:"" ?>" class="input-block-level" name='decor'></td>
            <td><div class="help-inline"><?=$generated['decor']?></div></td>
        </tr>
        <tr>
        	<td>Menu:</td>
            <td><input type="text" value="<?=(isset($report['menu']))?$report['menu']:"" ?>" class="input-block-level" name='menu'></td>
            <td><div class="help-inline"><?=$generated['menu']?></div></td>
        </tr>
        <tr>
        	<td>Gift Bags:</td>
            <td><input type="text" value="<?=(isset($report['giftBags']))?$report['giftBags']:"" ?>" class="input-block-level" name='giftBags'></td>
            <td><div class="help-inline"><?=$generated['giftBags']?></div></td>
        </tr>
	</tbody>
</table>

<table class="table report-table">
	<legend>Brand Ambassadors / Staffing:</legend>
	<thead>
    	<tr>
        	<th nowrap>&nbsp;</th>
            <th nowrap>New Value</th>
            <th nowrap>Server Value</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        	<td>Manager on Duty:</td>
            <td><input type="text" value="<?=(isset($report['onDutyManager']))?$report['onDutyManager']:"" ?>" class="input-block-level" name='onDutyManager'></td>
            <td><div class="help-inline"><?=$generated['onDutyManager']?></div></td>
        </tr>
        <tr>
        	<td>Number of Brand Ambassadors:</td>
            <td><input type="text" value="<?=(isset($report['ambassNo']))?$report['ambassNo']:"" ?>" class="input-block-level" name='ambassNo'></td>
            <td><div class="help-inline"><?=$generated['ambassNo']?></div></td>
        </tr>
	</tbody>
</table>
<button type='submit' class="btn btn-success btn-block"><i class="icon-save"></i> Save</button>
<script type='text/javascript'>
$(document).ready(function(){
/*	$.simpleWeather({
		zipcode: '<?=$venue['zipcode']?>',
		woeid: '2357536',
		location: '',
		unit: 'f',
		success: function(weather){
			$('#tempDeg').html(weather.temp+'&deg;'+weather.units.temp);
			$('#weatherState').html(' and <strong>'+weather.currently+'</strong>');
		},
		error: function(error) {
			$('#weatherDisplay').html('<h4>'+error+'</h4>');
		}
	});*/
});
function removeComment(element)
{
	$(element).parent().parent().remove();
}
function addNewRow(element,name)
{
	$(element).append("<li><div class='input-append'><input type='text' class='input-xxlarge' name='"+name+"'><button type='button' class='btn btn-danger' onclick='removeComment(this)'><i class='icon-remove'></i></button></div></li>");
	$(element).children().last().attr('name',name);
}

function addNewFileRow(element,name)
{
	$(element).append("<li><div><input type='file' class='input-block-level' name='"+name+"'> &nbsp; <div class='help-inline'></div> &nbsp; <button type='button' class='btn btn-small btn-danger' onclick='removeComment(this)'><i class='icon-remove'></i></button></div></li>");
	$(element).children().last().attr('name',name);
	$(element).children().last().find('input[type=file]').uniform();
}
</script>