<?php require_once('event-nav.php'); ?>
<?php if(is_array($staffGroups)) foreach($staffGroups as $group):
	if(!checkPermission(array($projectID,'events',$eventID,'staff','groups',$group['uid'],'view'))) continue;
	foreach($group as $key => $value)
		$group[$key] = htmlentities($value);?>
<section class="clearfix">
	<h4><?= $group['title'] ?></h4>
	<?php $i = 0;
	if(isset($staff[$group['uid']])) {?>
		<table class="table table-striped table-hover table-condensed table-bordered">
			<thead>
				<th>Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th class="text-center">Edit</th>
			</thead>
			<tbody>
				<?php foreach($staff[$group['uid']] as $user):
					foreach($user as $key => $value)
						$user[$key] = htmlentities($value);?>
						<tr>
							<td><?= htmlentities($user['lastName']) ?>, <?= htmlentities($user['firstName']) ?></td>
							<td><a href="mailto:<?= htmlentities($user['email']) ?>"><?= htmlentities($user['email']) ?></a></td>
							<td><?= ($user['mobile']) ?></td>
							<td class="text-center">
								<button type="button" onClick="editStaff('<?= $user['staffID'] ?>')" class="btn btn-small btn-inverse" title="Edit Staff">Edit</button>
								<button type='button' onclick='removeContact(<?=$user['staffID']?>)' class='btn btn-danger btn-small' title='Remove Staff'>Remove</button>
							</td>
						</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php } else {?>
		<div class="alert alert-info">There are no contacts of this type.</div>
	<?php } ?>
	<?php if(checkPermission(array($projectID,'events',$eventID,'staff','groups',$group['uid'],'create'))): ?>
		<a class="btn padding clearfix" href='<?= SITE_ROOT . "event.staff-newMember/".$projectID."/".$eventID ?>/<?=$group['uid']?>' title='Add New <?= $group['title'] ?>'>Add New</a>
	<?php endif; ?>
</section>
<hr>
<?php endforeach; ?>
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
			<h5>BA Contact Info:</h5>
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
                <label class="control-label">Name:</label>
                <div class="controls">
                	<input type="text" placeholder="First Name" name="firstName">
                    <input type="text" placeholder="Last Name" name="lastName">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Mobile:</label>
                <div class="controls">
                	<input type="text" placeholder="Mobile" name="mobile">
                </div>
            </div>
			<div class='control-group'>
				<label class='control-label'>Gender:</label>
				<div class='controls'>
					<select name='gender' class="input-medium">
						<option value='null'>Unknown</option>
						<option value='male'>Male</option>
						<option value='female'>Female</option>
					</select>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Dress Size:</label>
				<div class='controls'>
					<input type='text' placeholder='Dress Size' name='dressSize'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Shirt Size:</label>
				<div class='controls'>
					<input type='text' placeholder='Shirt Size' name='shirtSize'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Pants Size:</label>
				<div class='controls'>
					<input type='text' placeholder='Pants Size' name='pantsSize'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Shoe Size:</label>
				<div class='controls'>
					<input type='text' placeholder='Shoe Size' name='shoeSize'>
				</div>
			</div>
			<h5>Emergency Contact:</h5>
			<div class='control-group'>
				<label class='control-label'>Name:</label>
				<div class='controls'>
					<input type='text' placeholder='Name' name='emergencyName'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Phone:</label>
				<div class='controls'>
					<input type='text' placeholder='Phone' name='emergencyPhone'>
				</div>
			</div>
			<h5>BA Event Info:</h5>
			<div class='control-group'>
				<label class='control-label'>Time In:</label>
				<div class='controls'>
					<input type='text' placeholder='Time In' name='timeIn'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Time Out:</label>
				<div class='controls'>
					<input type='text' placeholder='Time Out' name='timeOut'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Paperwork Signed:</label>
				<div class='controls'>
					<input type='checkbox' name='paperwork' value="signed">
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>On-Site Training:</label>
				<div class='controls'>
					<input type='text' placeholder='On-Site Training' name='onSiteTraining'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Device Issued:</label>
				<div class='controls'>
					<input type='text' placeholder='Device Issued' name='deviceIssued'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Uniform Issued:</label>
				<div class='controls'>
					<input type='text' placeholder='Uniform Issued' name='uniformIssued'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Uniform Returned:</label>
				<div class='controls'>
					<input type='text' placeholder='Uniform Returned' name='uniformReturned'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>No. of Staff:</label>
				<div class='controls'>
					<input type='text' placeholder='No. of Staff' name='staffNo'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Manager on Duty:</label>
				<div class='controls'>
					<input type='text' placeholder='Manager on Duty' name='onDutyMan'>
				</div>
			</div>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Contact</button>
			<?php if(checkPermission(array($projectID,'events',$eventID,'staff','remove')))?><button type='button' class='btn btn-danger' id='removeStaff'>Remove Contact</button>
        </div>
    </form>
</div>
<script>
function removeContact(staffID)
{
	bootbox.confirm('Are you sure?',function(result){
		if(result)
			deleteIt(staffID);
	});
}
function deleteIt(staffID)
{
	postAction('removeContact.php',{staffID:staffID},function(d){
		$('#newContactModal').modal('hide');
		window.location.href = '<?=SITE_ROOT?>event.staff/<?=$projectID?>/<?=$eventID?>';
	},function(d){
		$('#newContactModal').modal('hide');
		bootbox.alert(d.msg);		
	});
}
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
		console.log(d);
		$('#newStaffModal #loading').fadeOut();
		$('#newStaffModal input[name=groupID]').val(d.staffGroupID);
		$('#newStaffModal input[name=firstName]').val(d.firstName);
		$('#newStaffModal input[name=lastName]').val(d.lastName);
		$('#newStaffModal input[name=email]').val(d.email);
		$('#newStaffModal input[name=mobile]').val(d.mobile);
		$('#newStaffModal select[name=gender]').val(d.gender);
		$('#newStaffModal input[name=dressSize]').val(d.dressSize);
		$('#newStaffModal input[name=shirtSize]').val(d.shirtSize);
		$('#newStaffModal input[name=pantsSize]').val(d.pantsSize);
		$('#newStaffModal input[name=shoeSize]').val(d.shoeSize);
		$('#newStaffModal input[name=emergencyName]').val(d.emergencyName);
		$('#newStaffModal input[name=emergencyPhone]').val(d.emergencyPhone);
		$('#newStaffModal input[name=timeIn]').val(d.timeIn);
		$('#newStaffModal input[name=timeOut]').val(d.timeOut);
		if((d.paperwork == 'signed'))
		{
			$('#newStaffModal input[name=paperwork]').attr('checked',true);
			$('#newStaffModal input[name=paperwork]').parent().addClass('checked');
		}else{
			$('#newStaffModal input[name=paperwork]').attr('checked',false);
			$('#newStaffModal input[name=paperwork]').parent().removeClass('checked');
		}
		$('#newStaffModal input[name=onSiteTraining]').val(d.onSiteTraining);
		$('#newStaffModal input[name=deviceIssued]').val(d.deviceIssued);
		$('#newStaffModal input[name=uniformIssued]').val(d.uniformIssued);
		$('#newStaffModal input[name=staffNo]').val(d.staffNo);
		$('#newStaffModal input[name=onDutyMan]').val(d.onDutyMan);
		$('#newStaffModal input[name=email]').change();
		
		$('#newStaffModal select').select2('destroy').select2();
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