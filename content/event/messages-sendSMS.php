<?php require_once('event-nav.php');?>
<div class='row-fluid'>
	<div class='span12'>
		<form accept-charset="UTF-8" action="<?=SITE_ROOT?>event.messages/<?=$projectID?>/<?=$eventID?>/" method="post" class="form-horizontal" id='sendSMSForm'>
			<input type="hidden" name="action" value='sendSMS'>
			<input type="hidden" name="eventID" value="<?= $eventID ?>">
			<div class='control-group'>
				<label class='control-label'>Recipients:</label>
				<div class='controls'>
					<select name='smsRecipients' class='input-xlarge'>
						<option value='1'>All Guests</option>
						<option value='2'>My Guests</option>
					</select>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Message:</label>
				<div class='controls'>
					<input type="text" name='body' placeholder='Body' id='sms-body' class='input-xlarge'>
				</div>
			</div>
		</form>
		<button type="button" class='btn' onclick='previewSMS()'>Preview</button>
	</div>
</div>
<div class='modal hide' id='sms-preview'>
	<div style="position:absolute;top:44px;right:0;left:0;bottom:0;border-bottom-left-radius::5px;border-bottom-right-radius::5px;background:rgba(0,0,0,0.5);z-index:200" id="loading" class="hide">
    	<center><i class="icon-spinner icon-spin" style="color:white;position:absolute;top:50%;left:50%;font-size:50px;margin-left:-25px;margin-top:-35px;"></i></center>
    </div>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>SMS Preview</h3>
        </div>
        <div class="modal-body">
			<table class='table-condensed'>
				<tr>
					<td style='vertical-align:top;'><strong>Body:</strong></td>
					<td><div name='bodyField'></div></td>
				</tr>
			</table>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Cancel</a>
            <button type="button" class="btn btn-primary" onclick="$('#sendSMSForm').submit()">Send</button>
        </div>
</div>
<script type='text/javascript'>
function previewSMS()
{
	$('#sms-preview div[name=bodyField]').html($('#sendSMSForm [name=body]').val());
	$('#sms-preview').modal();
}
</script>