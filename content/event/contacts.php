<?php require_once('event-nav.php'); ?>
<?php if(is_array($contactGroups)) foreach($contactGroups as $group):
	if(!checkPermission(array($projectID,'events',$eventID,'staff','groups',$group['uid'],'view'))) continue;
	foreach($group as $key => $value)
		$group[$key] = htmlentities($value);
		if($group['title'] != 'Brand Ambassador'):?>
<section class="clearfix">
	<h4><?= $group['title'] ?></h4>
	<?php $i = 0;
	if(isset($contact[$group['uid']])) {?>
		<table class="table table-striped table-hover table-condensed table-bordered">
			<thead>
				<?php if($group['title'] == 'BlackBerry BU'):?>
					<th>Business Unit</th>
				<?php elseif($group['title'] == 'Photographer'):?>
					<th>Company</th>
				<?php else:?>
					<th>Responsibility</th>
				<?php endif;?>
				<th>Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th class="text-center">Edit</th>
			</thead>
			<tbody>
				<?php foreach($contact[$group['uid']] as $user):
					foreach($user as $key => $value)
						$user[$key] = htmlentities($value);?>
						<tr>
							<?php if($group['title'] == 'BlackBerry BU'):?>
							<th><?=$user['businessUnit']?></td>
						<?php elseif($group['title'] == 'Photographer'):?>
							<td><?=$user['company']?></td>
						<?php else:?>
							<td><?=$user['responsibility']?></td>
						<?php endif;?>
							<td><?= htmlentities($user['firstName']) ?> <?= htmlentities($user['lastName']) ?></td>
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
		<a class="btn padding clearfix" href='<?= SITE_ROOT . "event.contacts-newMember/".$projectID."/".$eventID ?>/<?=$group['uid']?>' title='Add New <?= $group['title'] ?>'>Add New</a>
	<?php endif; ?>
</section>
<hr>
<?php endif;
endforeach; ?>
<div class="modal hide" id="newContactModal" style="width:750px;">
	<div style="position:absolute;top:44px;right:0;left:0;bottom:0;border-bottom-left-radius::5px;border-bottom-right-radius::5px;background:rgba(0,0,0,0.5);z-index:200" id="loading" class="hide">
    	<center><i class="icon-spinner icon-spin" style="color:white;position:absolute;top:50%;left:50%;font-size:50px;margin-left:-25px;margin-top:-35px;"></i></center>
    </div>
    <form accept-charset="UTF-8" action="<?=SITE_ROOT?>event.contacts/<?=$projectID?>/<?=$eventID?>" method="post" class="form-horizontal">
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
                    <?php foreach($contactGroups as $group):
						if(!checkPermission(array($projectID,'events',$eventID,'staff','groups',$group['uid'],'add'))) continue;
					?>
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
		bootbox.alert(d.msg);
		window.location.href = '<?=SITE_ROOT?>event.contacts/<?=$projectID?>/<?=$eventID?>';
	},function(d){
		$('#newContactModal').modal('hide');
		bootbox.alert(d.msg);
	});
}
function editStaff(staffID)
{
	$('#newContactModal input').each(function(index,element){
		if($(element).attr('type') == 'checkbox')
			$(element).removeAttr('checked');
		else
			$(element).val('');
	});
	$('#newContactModal #loadingIcon').hide();
	$('#newContactModal #loading').hide();
	$('#newContactModal #emailText').html('');
	$('#newContactModal #emailField').removeClass('warning');
	$('#newContactModal #emailField').removeClass('error');
	$('#newContactModal #emailField').removeClass('info');
	$('#newContactModal #emailField').removeClass('success');
	
	$('#newContactModal input[name=staffID]').val(staffID);
	$('#newContactModal input[name=eventID]').val('<?= $eventID ?>');
	$('#newContactModal input[name=action]').val('editStaff');
	$('#newContactModal #needsLogin').hide();
	$('#newContactModal #loading').show();
	$('#newContactModal').modal();
	postAction('getStaffByID.php',{staffID:staffID},function(d){
		$('#newContactModal #loading').fadeOut();
		$('#newContactModal input[name=firstName]').val(d.firstName);
		$('#newContactModal input[name=lastName]').val(d.lastName);
		$('#newContactModal input[name=email]').val(d.email);
		$('#newContactModal input[name=mobile]').val(d.mobile);
		$('#newContactModal input[name=company]').val(d.company);
		$('#newContactModal select[name=groupID]').val(d.staffGroupID);
		$('#newContactModal select[name=businessUnit]').val(d.businessUnit);
		$('#newContactModal input[name=responsibility]').val(d.responsibility);
		$('#newContactModal textarea[name=notes]').html(d.notes);
		$('#newContactModal input[name=email]').change();
	},function(d){
		$('#newContactModal').modal('hide');
		bootbox.alert(d.msg);
	});
}
$('#newContactModal input[name=email]').change(function(e) {
	var email = $(this).val();
	
	$('#newContactModal #loadingIcon').hide();
	$('#newContactModal #emailText').html('');
	$('#newContactModal #emailField').removeClass('warning');
	$('#newContactModal #emailField').removeClass('error');
	$('#newContactModal #emailField').removeClass('info');
	$('#newContactModal #emailField').removeClass('success');
	if(email.length == 0)
	{
			
	}else if(isValidEmailAddress(email))
	{
		$('#newContactModal #loadingIcon').show();
		$('#newContactModal #emailText').html('Checking Email...');
		postAction('checkUserEmail.php',{email:email},function(d){
			$('#newContactModal #loadingIcon').hide();
			if(d.exists == '0')
			{
				$('#newContactModal input[name=userID]').val('');
				$('#newContactModal #emailField').addClass('info');
				$('#newContactModal #emailText').html('Email not currently in system. <i class="icon-question-sign" title="If Needs Login? is checked, they will be sent an email asking to register."></i>');	
			}
			else
			{
				$('#newContactModal #emailField').addClass('success');
				$('#newContactModal #emailText').html('User exists in system. <i class="icon-question-sign" title="If Needs Login? is checked, they will be sent an email telling them that they\'ve been added to this event."></i> ');
				
				$('#newContactModal input[name=userID]').val(d.uid);
				if($('#newContactModal input[name=firstName]').val() == "")
					$('#newContactModal input[name=firstName]').val(d.firstName);
				
				if($('#newContactModal input[name=lastName]').val() == "")
					$('#newContactModal input[name=lastName]').val(d.lastName);
					
				if($('#newContactModal input[name=mobile]').val() == "")
					$('#newContactModal input[name=mobile]').val(d.mobile);

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