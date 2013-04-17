<?php require_once('event-nav.php');?>
<div class='row-fluid'>
	<div class='span12'>
		<form accept-charset="UTF-8" action="<?=SITE_ROOT?>event.messages/<?=$projectID?>/<?=$eventID?>/" method="post" class="form-horizontal" id='sendEmailForm'>
			<input type="hidden" name="action" value='sendEmail'>
			<input type="hidden" name="eventID" value="<?= $eventID ?>">
			<div class='control-group'>
				<label class='control-label'>Recipients:</label>
				<div class='controls'>
					<select name='emailRecipients' class='input-xxlarge'>
						<option value='1'>All Guests</option>
						<option value='2'>My Guests</option>
					</select>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Subject:</label>
				<div class='controls'>
					<input type='text' name='subject' placeholder='Subject' class='input-xxlarge'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Body:</label>
				<div class='controls'>
					<div id='email-toolbar'>
						<a data-wysihtml5-command='bold' class='btn btn-small'>Bold</a>
						<a data-wysihtml5-command='italic' class='btn btn-small'>Italic</a>
						<a data-wysihtml5-command='createLink' class='btn btn-small'>Insert Link</a>
						<div data-wysihtml5-dialog="createLink" style="display: none;">
							<label>
								Link:
								<input data-wysihtml5-dialog-field="href" value="http://" class="text">
							</label>
							<a data-wysihtml5-dialog-action="save" class='btn btn-small'>OK</a> <a data-wysihtml5-dialog-action="cancel" class='btn btn-small'>Cancel</a>
						</div>
					</div>
					<textarea name='body' placeholder='Body' id='email-body' class='input-xxlarge' style="min-height:120px;margin-top:5px;"></textarea>
				</div>
			</div>
		</form>
		<button class='btn' onclick='previewEmail()'>Preview</button>
	</div>
</div>
<div class='modal hide' id='email-preview'>
	<div style="position:absolute;top:44px;right:0;left:0;bottom:0;border-bottom-left-radius::5px;border-bottom-right-radius::5px;background:rgba(0,0,0,0.5);z-index:200" id="loading" class="hide">
    	<center><i class="icon-spinner icon-spin" style="color:white;position:absolute;top:50%;left:50%;font-size:50px;margin-left:-25px;margin-top:-35px;"></i></center>
    </div>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Email Preview</h3>
        </div>
        <div class="modal-body">
			<table class='table-condensed'>
				<tr>
					<td><strong>Subject:</strong></td>
					<td><span name='subjectField'></span></td>
				</tr>
				<tr>
					<td style='vertical-align:top;'><strong>Body:</strong></td>
					<td><div name='bodyField'></div></td>
				</tr>
			</table>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Cancel</a>
            <button type="button" class="btn btn-primary" onclick="$('#sendEmailForm').submit()">Send</button>
        </div>
</div>
<script type='text/javascript'>
$(document).ready(function(){
	var editor = new wysihtml5.Editor('email-body',{
		toolbar: 'email-toolbar',
		parserRules: wysihtml5ParserRules
	});
});
function previewEmail()
{
	$('#email-preview span[name=subjectField]').html($('#sendEmailForm input[name=subject]').val());
	$('#email-preview div[name=bodyField]').html($('#sendEmailForm textarea[name=body]').val());
	$('#email-preview').modal();
}
</script>