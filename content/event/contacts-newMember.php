<?php require_once('event-nav.php'); ?>
<div class='row-fluid'>
	<div class='span12 widget-box'>
		<form accept-charset="UTF-8" action='<?= SITE_ROOT . "event.contacts/".$projectID."/".$eventID ?>' method="post" class="form-horizontal">
			<input type="hidden" name="action" value='newStaff'>
			<input type="hidden" name="userID">
			<input type="hidden" name="groupID" value='<?=$groupID?>'>
			<input type="hidden" name="eventID" value='<?=$eventID?>'>
			<input type='hidden' name='invitedBy' value='<?=$_SESSION['user']['uid']?>'>
			<div class="widget-title">
				<h5>New <span class="groupName"><?=$group['title']?></span> Contact</h5>
			</div>
			<div class="widget-content">
				<div class="control-group" id="emailField">
					<label class="control-label">Email:</label>
					<div class="controls">
						<input type="text" placeholder="Email" name="email"> &nbsp;
						<i class="icon-warning-sign" title="If the user fields below are empty when you change the email address, it will populate the data for you if the user is already in the system"></i>
						<i id="loadingIcon" class="icon-spinner icon-spin hide"></i>
						<small class="help-inline" id="emailText"></small>
					</div>
				</div>
				<div class="control-group" id="needsLogin">
					<label class="control-label">Needs Login?</label>
					<div class="controls">
						<input type="checkbox" name="needsLogin" value="true"> &nbsp; 
						<i class="icon-question-sign" title="If checked, this means that the Staff Member will need to access some element of this event record. I.E. Ticketing, Staffing, Guest List, Etc.."></i>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Name:</label>
					<div class="controls">
						<input type="text" placeholder="First Name" name="firstName" class="input-medium">
						<input type="text" placeholder="Last Name" name="lastName" class="input-medium">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Company:</label>
					<div class="controls">
						<input type="text" placeholder="Company" name="company">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Mobile:</label>
					<div class="controls">
						<input type="text" placeholder="Mobile" name="mobile">
					</div>
				</div>
                <?php if($group['title'] == 'BlackBerry BU'): ?>
				<div class='control-group'>
					<label class='control-label'>Business Unit:</label>
					<div class='controls'>
						<select name='businessUnit' class="input-large">
							<option value=''>N/A</option>
							<option>Ashley FM</option>
							<option value="AT&T">AT&amp;T</option>
							<option>C Level</option>
							<option>Canadian Channel</option>
							<option>EMEA Events</option>
							<option>Employee</option>
							<option>Enterprise</option>
							<option>Global Events</option>
							<option>Media</option>
                            <option>National Retail</option>
							<option>Neal FM</option>
                            <option>Pop-Up</option>
                            <option>Promo</option>
                            <option>Spares</option>
							<option>Sprint</option>
							<option>T-Mobile</option>
							<option>TSM</option>
							<option>US Channel</option>
                            <option>US Consumer Marketing</option>
							<option>Verizon Wireless</option>
						</select>
					</div>
				</div>
                <?php endif; ?>
				<div class='control-group'>
					<label class='control-label'>Responsibility:</label>
					<div class='controls'>
						<input type='text' placeholder='Responsibility' name='responsibility'>
					</div>
				</div>
				<div class='control-group'>
					<label class='control-label'>Notes:</label>
					<div class='controls'>
						<textarea placeholder='Notes' cols='10' name='notes'></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Save Staff</button>
			</div>
		</form>
	</div>
</div>
<script type='text/javascript'>
$('input[name=email]').change(function(e) {
	var email = $(this).val();
	$('#loadingIcon').hide();
	$('#emailText').html('');
	$('#emailField').removeClass('warning');
	$('#emailField').removeClass('error');
	$('#emailField').removeClass('info');
	$('#emailField').removeClass('success');
	if(email.length == 0)
	{
			
	}else if(isValidEmailAddress(email))
	{
		$('#loadingIcon').show();
		$('#emailText').html('Checking Email...');
		postAction('checkUserEmail.php',{email:email},function(d){
			$('#loadingIcon').hide();
			if(d.exists == '0')
			{
				$('input[name=userID]').val('');
				$('#emailField').addClass('info');
				$('#emailText').html('Email not currently in system. <i class="icon-question-sign" title="If Needs Login? is checked, they will be sent an email asking them to register."></i>');	
			}
			else
			{
				$('#emailField').addClass('success');
				$('#emailText').html('User exists in system. <i class="icon-question-sign" title="If Needs Login? is checked, they will be sent an email telling them that they\'ve been added to this event."></i> ');
				$('input[name=userID]').val(d.uid);
				if($('input[name=firstName]').val() == "")
					$('input[name=firstName]').val(d.firstName);
				if($('input[name=lastName]').val() == "")
					$('input[name=lastName]').val(d.lastName);
				if($('input[name=mobile]').val() == "")
					$('input[name=mobile]').val(d.mobile);
			}
		},function(d){
			bootbox.alert(d.msg);	
		});
	}
	else
	{
		$('#emailField').addClass('error');
		$('#emailText').html('Please enter a valid email address.');
	}
});
</script>