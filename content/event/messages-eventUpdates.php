<?php require_once('event-nav.php');?>

<div class='row-fluid' id='messaging-page'>
	<div class='span6'>
		<div class='widget-box'>
			<div class='widget-title'>
				<h5>Latest Messages</h5>
			</div>
			<div class="widget-content nopadding updates">
				<div class='new-update clearfix'>
					<div class='update-done'>
						<h4>Loading Updates <i class='icon icon-spinner icon-spin'></i></h4>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class='span6' id='event-message'>
		<div class='widget-box'>
			<div class='widget-title'>
				<h5>Add Event Message</h5>
			</div>
			<div class='widget-content'>
				<input type='text' placeholder='Title' name='updateTitle'><br>
				<textarea placeholder='Message' name='updateMessage'></textarea><br>
				<select name='updateLevel' title='Specify who will be able to view this message.'>
					<option value='0'>Everyone</option>
					<option value='1'>BlackBerry BU's</option>
					<option value='2'>Administrators Only</option>
				</select><br>
				<button class='btn btn-success' onclick="sendUpdate()" id='update-button'>Send</button>
			</div>
		</div>
	</div>
</div>
<script type='text/javascript'>
$(document).ready(function(){
	postAction('getEventUpdates.php',{eventID:<?=$eventID?>},function(d){
		$('.updates').html('');
		$.each(d.updates,function(index,value){
			$('.updates').append(
			"<div class='new-update clearfix'><div class='update-done'><strong>" + value.title + "</strong><span>" + value.description + "</span></div><div class='update-date'><span class='update-day'>" + value.day +"</span>" + value.month + "</div></div>"
			);
		});
	},function(d){
		bootbox.alert(d.msg);
	});
});
function sendUpdate() {
	$('#update-button').addClass('disabled');
	$('#update-button').html('Sending...');
	var title = $('#event-message input[name=updateTitle]').val();
	var message = $('#event-message textarea[name=updateMessage]').val();
	var level = $('#event-message select[name=updateLevel]').val();
	postAction('addEventUpdate.php',{eventID:<?=$eventID?>,title:title,message:message,level:level},function(d){
		bootbox.alert(d.msg,function(){location.reload()});
		$('#update-button').removeClass('disabled');
		$('#update-button').html('Send');
	},function(d){
		bootbox.alert(d.msg);
		$('#update-button').removeClass('disabled');
		$('#update-button').html('Send');
		$('#event-message input[name=updateTitle]').val('');
		$('#event-message textarea[name=updateMessage]').val('');
		$('#event-message select[name=updateLevel]').val('');
	});
}
</script>