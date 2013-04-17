<br>
<?php foreach($staff as $title=>$contacts):?>
	<h4><?= $title?></h4>
	<?php if(sizeof($contacts) > 0):?>
		<table class='table table-bordered table-striped table-hover table-condensed'>
			<thead>
				<tr>
					<?php if($title == 'BlackBerry BU'):?>
						<th>Business Unit</th>
					<?php elseif($title == 'Photographer'):?>
						<th>Company</th>
					<?php else:?>
						<th>Responsibility</th>
					<?php endif;?>
					<th>Name</th>
					<th>Email</th>
					<th>Phone</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($contacts as $user): ?>
					<tr>
						<?php if($title == 'BlackBerry BU'):?>
							<td><?=$user['businessUnit']?></td>
						<?php elseif($title == 'Photographer'):?>
							<td><?=$user['company']?></td>
						<?php else:?>
							<td><?=$user['responsibility']?></td>
						<?php endif;?>
						<td><?=$user['firstName']?> <?=$user['lastName']?></td>
						<td><a href='mailto:<?=$user['email']?>'><?=$user['email']?></a></td>
						<td><?=$user['mobile']?></td>
					</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	<?php else:?>
		<div class='alert alert-info'>There are no contacts of this type.</div>
	<?php endif;?>
	<?php if(checkPermission(array($projectID,'staff','groups',$group['uid'],'create')) && false): ?>
		<br><a class="btn padding clearfix" href='<?= SITE_ROOT . "project.people-newMember/".$projectID ?>/<?=$group['uid']?>' title='Add New <?= $group['title'] ?>'>Add New</a>
	<?php endif; ?> 
	<hr>
<?php endforeach;?>
<div class="modal hide" id="newStaffModal" style="width:750px;">
	<div style="position:absolute;top:44px;right:0;left:0;bottom:0;border-bottom-left-radius::5px;border-bottom-right-radius::5px;background:rgba(0,0,0,0.5);z-index:200" id="loading" class="hide">
    	<center><i class="icon-spinner icon-spin" style="color:white;position:absolute;top:50%;left:50%;font-size:50px;margin-left:-25px;margin-top:-35px;"></i></center>
    </div>
    <form accept-charset="UTF-8" action="" method="post" class="form-horizontal">
    	<input type="hidden" name="staffID">
    	<input type="hidden" name="action" value='editStaff'>
    	<input type="hidden" name="userID">
        <input type="hidden" name="groupID">
        <input type="hidden" name="eventID">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Edit <span class="groupName"></span> Contact</h3>
        </div>
        <div class="modal-body">
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
                    <i class="icon-question-sign" title="If checked, this means that the contact will need to access some element of this event record. I.E. Ticketing, Staffing, Guest List, etc.."></i>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Contact Group:</label>
                <div class="groupName controls">
                	<select name="groupID">
                    <?php foreach($staffGroups as $group):
						if(!checkPermission(array($projectID,'events',$eventID,'staff','groups',$group['uid'],'add'))) continue; ?>
                    	<option value="<?= $group['uid'] ?>"><?= htmlentities($group['title']) ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Name:</label>
                <div class="controls">
                	<input type="text" placeholder="First Name" name="firstName">
                    <input type="text" placeholder="Last Name" name="lastName">
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
            <div class='control-group'>
				<label class='control-label'>Business Unit:</label>
				<div class='controls'>
					<select name='businessUnit'>
						<option value=''>N/A</option>
						<option>Ashley FM</option>
						<option>AT&amp;T</option>
						<option>C Level</option>
						<option>Canadian Channel</option>
						<option>EMEA Events</option>
						<option>Employee</option>
						<option>Enterprise</option>
						<option>Global Events</option>
						<option>Media</option>
						<option>Neal FM</option>
						<option>Sprint</option>
						<option>T-Mobile</option>
						<option>TSM</option>
						<option>US Channel</option>
						<option>Verizon Wireless</option>
					</select>
				</div>
			</div>
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
            <a href="#" class="btn" data-dismiss="modal">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Contact</button>
        </div>
    </form>
</div>
<script>
function editStaff(staffID)
{
	$('#newStaffModal input').each(function(index,element){
		if($(element).attr('type') == 'checkbox')
			$(element).removeAttr('checked');
		else
			$(element).val('');
	});
	$('#newStaffModal #loadingIcon').hide();
	$('#newStaffModal #loading').hide();
	$('#newStaffModal #emailText').html('');
	$('#newStaffModal #emailField').removeClass('warning');
	$('#newStaffModal #emailField').removeClass('error');
	$('#newStaffModal #emailField').removeClass('info');
	$('#newStaffModal #emailField').removeClass('success');	
	
	$('#newStaffModal input[name=staffID]').val(staffID);
	$('#newStaffModal input[name=eventID]').val('<?= $eventID ?>');
	$('#newStaffModal input[name=action]').val('editStaff');
	$('#newStaffModal #needsLogin').hide();
	$('#newStaffModal #loading').show();
	$('#newStaffModal').modal();
	postAction('getStaffByID.php',{staffID:staffID},function(d){
		$('#newStaffModal #loading').fadeOut();
		$('#newStaffModal input[name=firstName]').val(d.firstName);
		$('#newStaffModal input[name=lastName]').val(d.lastName);
		$('#newStaffModal input[name=email]').val(d.email);
		$('#newStaffModal input[name=mobile]').val(d.mobile);
		$('#newStaffModal input[name=company]').val(d.company);
		$('#newStaffModal select[name=groupID]').val(d.staffGroupID);
		$('#newStaffModal select[name=businessUnit]').val(d.businessUnit);
		$('#newStaffModal input[name=responsibility]').val(d.responsibility);
		$('#newStaffModal textarea[name=notes]').html(d.notes);
		$('#newStaffModal input[name=email]').change();
	},function(d){
		$('#newStaffModal').modal('hide');
		bootbox.alert(d.msg);
	});
}
$('#newStaffModal input[name=email]').change(function(e) {
	var email = $(this).val();
	
	$('#newStaffModal #loadingIcon').hide();
	$('#newStaffModal #emailText').html('');
	$('#newStaffModal #emailField').removeClass('warning');
	$('#newStaffModal #emailField').removeClass('error');
	$('#newStaffModal #emailField').removeClass('info');
	$('#newStaffModal #emailField').removeClass('success');
	if(email.length == 0)
	{
			
	}else if(isValidEmailAddress(email))
	{
		$('#newStaffModal #loadingIcon').show();
		$('#newStaffModal #emailText').html('Checking Email...');
		postAction('checkUserEmail.php',{email:email},function(d){
			$('#newStaffModal #loadingIcon').hide();
			if(d.exists == '0')
			{
				$('#newStaffModal input[name=userID]').val('');
				$('#newStaffModal #emailField').addClass('info');
				$('#newStaffModal #emailText').html('Email not currently in system. <i class="icon-question-sign" title="If Needs Login? is checked, they will be sent an email asking to register."></i>');	
			}
			else
			{
				$('#newStaffModal #emailField').addClass('success');
				$('#newStaffModal #emailText').html('User exists in system. <i class="icon-question-sign" title="If Needs Login? is checked, they will be sent an email telling them that they\'ve been added to this event."></i> ');
				
				$('#newStaffModal input[name=userID]').val(d.uid);
				if($('#newStaffModal input[name=firstName]').val() == "")
					$('#newStaffModal input[name=firstName]').val(d.firstName);
				
				if($('#newStaffModal input[name=lastName]').val() == "")
					$('#newStaffModal input[name=lastName]').val(d.lastName);
					
				if($('#newStaffModal input[name=mobile]').val() == "")
					$('#newStaffModal input[name=mobile]').val(d.mobile);

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