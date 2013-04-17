<?php require_once('event-nav.php'); ?>
<br>
<?php if(!isset($guests) || !$guests): ?>
	<div class="alert alert-error"><i class="icon-hdd"></i>&nbsp; Unable to get your guests from the database.</div>
<?php 
	return;
endif; ?>
<div class="row-fluid">
    <div class="alert alert-success span6" id="tickets-alert"><strong>Allocated Tickets:</strong> 
    <?php $hasTickets = false;
		foreach($ticketTypes as $type): 
		if(empty($user['tickets'][$type['uid']]))continue;
		$hasTickets = true;
	?>
        &nbsp; <i class="icon-film"></i>&nbsp;<strong id="ticket-<?=$type['uid']?>"><?=$user['tickets'][$type['uid']] - $type['left']?></strong> of <strong><?=$user['tickets'][$type['uid']]?></strong> <?=$type['name']?> &nbsp;
    <?php endforeach; if(!$hasTickets): ?>
    	You have no tickets to allocate.
    <?php endif; ?>
    </div>

    <div class="alert alert-success span6" id="addons-alert"><strong>Allocated Addons:</strong> 
    <?php if(is_array($user['addons']) && !empty($user['addons'])):foreach($user['addons'] as $addonID => $total):if($total == 0)continue; ?>
        &nbsp; <i class="icon-beer"></i>&nbsp;<strong id="addon-<?=$addonID?>"><?=$addons[$addonID]['left']?></strong> of <strong><?=$total?></strong> <?=$addons[$addonID]['name']?> &nbsp;
    <?php endforeach; else: ?>
    	You have no addons to allocate.
	<?php endif;?>
    </div>
</div>
<div class='widget-box'>
    <div class='widget-content nopadding'>
<form accept-charset="UTF-8" action="<?=SITE_ROOT."event.guests-assignTickets/".$projectID."/".$eventID?>" method="post" id="assign-tickets-form">
<input type="hidden" name="action" value="assignTickets">
<table class="table table-bordered" id="guests-table">
	<thead>
    	<tr>
			<th>First Name</th>
            <th>Last Name</th>
            <th class='text-center' nowrap width='10'>&nbsp; # TIX &nbsp;</th>
            <th class="text-center" nowrap width="10">&nbsp; TIX Type &nbsp;</th>
            <?php if(is_array($user['addons']))foreach($user['addons'] as $addonID => $total): if($total == 0)continue; ?>
            <th class="text-center" nowrap>&nbsp; <?=$addons[$addonID]['name']?> &nbsp;</th>
            <?php endforeach; ?>
            <th class="text-center" nowrap>&nbsp; RSVP &nbsp;</th>
            <!--<th>Group Name</th>-->
            <th class="text-center" nowrap width="150">&nbsp; Actions &nbsp;</th>
		</tr>
    </thead>
	<tbody>
<?php
while($guest = $guests->fetch_assoc()):
	$guest['addons'] = json_decode($guest['addons'],true);
	$guest['extraData'] = json_decode($guest['extraData'],true);
	$guest = real_display_array($guest);
	$shown = 0;
?>
	<tr id="row-<?=$guest['uid']?>">
		<td><?=$guest['firstName']?></td>
        <td><?=$guest['lastName']?></td>
        <td class='text-center'>
			<input class='input-mini ticketsNo' name='row[<?=$guest['uid']?>][ticketsNo]' onChange='updateTickets()' value='<?=$guest['ticketsNo']?>'>
		</td>
        <td class="text-center"><select class="input-small ticket-select" name="row[<?=$guest['uid']?>][ticketType]" onChange="updateTickets()">
        <?php foreach($ticketTypes as $type):
			if(empty($user['tickets'][$type['uid']]))continue;
			
		?>
			<option value="<?=$type['uid']?>" <?php if($type['uid'] == $guest['ticketTypeID'])echo'selected' ?>><?=$type['name']?></option>
		<?php endforeach; ?>
        </select></td>
        
        <?php if(is_array($user['addons']))foreach($user['addons'] as $addonID => $total): if($total == 0)continue; $shown++; ?>
        <td class="text-center">
        	<input type="checkbox" class="addon-select" addonType="<?=$addonID?>" name="row[<?=$guest['uid']?>][addons][<?=$addonID?>]"<?=($guest['addons'][$addonID] == '1')?"checked":""?> onChange="updateAddons()" value="1">
        </td>
        <?php endforeach; ?>
        <td class="text-center"><i class="icon-<?=($guest['rsvp'] == '')?"minus":(($guest['rsvp'] == 1)?"check":"check-empty")?>"></i></td>
        <!--<td><?=$guest['groupName']?></td>-->
        <td class="text-center"><div class='btn-group'>
        	<button type="button" class='btn btn-info btn-small' title='Edit Guest' onclick="editGuest('<?=$guest['uid']?>')"><i class="icon-edit"></i> Edit</button>
        	<button type="button" class='btn btn-danger btn-small' onclick="bootboxRemoveGuest('<?=$guest['uid']?>')"><i class='icon icon-remove'></i> Remove</button>
        </div></td>
    </tr>
<?php endwhile; ?>
	<tr>
    	<td colspan="<?= $shown + 6 ?>">&nbsp;<button type="submit" class="btn btn-success pull-right"><i class="icon-save"></i>&nbsp; Save Guest Data</button></td>
    </tr>
	</tbody>
</table>
<br>

</div>
</form>
</div>
</div>
<div class="modal hide edit_guest_modal" id="editGuestModal">
	<div style="position:absolute;top:44px;right:0;left:0;bottom:0;border-bottom-left-radius::5px;border-bottom-right-radius::5px;background:rgba(0,0,0,0.5);z-index:200" class="hide loading">
    	<center><i class="icon-spinner icon-spin" style="color:white;position:absolute;top:50%;left:50%;font-size:50px;margin-left:-25px;margin-top:-35px;"></i></center>
    </div>
    <form accept-charset="UTF-8" action="<?= SITE_ROOT ?>event.guests-assignTickets/<?= $projectID ?>/<?= $eventID ?>" method="post" class="form-horizontal" onSubmit='return updateGuest()'>
    	<input type="hidden" name="guestID">
    	<input type="hidden" name="action">
    	<input type="hidden" name="userID">
        <input type="hidden" name="eventID">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>View Guest</h3>
        </div>
        <div class="modal-body edit_guest_modal_body">
        	<div class="pull-right" style="padding:10px;font-size-adjust:+1"><strong>TIX:</strong> &nbsp; <span class="ticketsNo"></span></div>
            <div class="control-group">
                <label class="control-label"><strong>Name:</strong></label>
                <div class="controls">
                    <input type="text" placeholder="First Name" name="firstName" class="input-small"> &nbsp;
                    <input type='text' placeholder='Last Name' name='lastName' class="input-small">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"><strong>Email:</strong></label>
                <div class="controls">
                	<input type="text" placeholder='Email' name="email">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"><strong>Mobile Number:</strong></label>
                <div class="controls">
                	<input type="text" placeholder="Mobile" name="mobile">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"><strong>Company:</strong></label>
                <div class="controls">
                	<input type="text" placeholder="Company" name="company">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Authorized Parties:</label>
                <div class="controls">
                    <input type="text" placeholder="Authorized Parties" name="responsible">
                </div>
            </div>
			<div class='control-group'>
				<label class='control-label'><strong>RSVP'd?:</strong></label>
				<div class='controls'>
					<select name='rsvp' class="input-medium">
						<option value='null'>Unknown</option>
						<option value='1'>Yes</option>
                        <option value='0'>No</option>
					</select>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'><strong>Notes:</strong></label>
				<div class='controls'>
					<textarea type='text' placeholder='Notes' name='notes' class="input-xlarge" rows="1" style="resize:none;"></textarea>
				</div>
			</div>
        </div>
        <div class="modal-footer">
        	<a data-dismiss="modal" data-target="#editGuestModal" class="btn">Cancel</a>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
<form accept-charset="UTF-8" id="remove-guest" action="<?=SITE_ROOT."event.guests-assignTickets/".$projectID."/".$eventID?>" method="POST">
	<input type="hidden" name="guestID">
    <input type="hidden" name="action" value="removeGuest">
</form>
<script>
var isError = false,
	errorCount = 0,
	guestsTable,
	tickets = {<?php $shown = false;
		foreach($ticketTypes as $type): 
			if(empty($user['tickets'][$type['uid']]))continue;
			if($shown) echo ',';
			echo '"'.$type['uid'].'":'.$user['tickets'][$type['uid']];
			$shown = true;
		endforeach; ?>},
	addons = {<?php $shown = false;
		if(is_array($user['addons']))
		foreach($user['addons'] as $name => $total):
			if($shown) echo ',';
			echo '"'.$name.'":'.$total;
			$shown = true;
		endforeach; ?>};

function prepareModal()
{
	$('#editGuestModal input').each(function(index, element) {
		if($(element).attr('type') == 'checkbox')
			$(element).removeAttr('checked');
		else
        	$(element).val('');
    });
	$('#editGuestModal .loadingIcon').hide();
	$('#editGuestModal .loading').hide();
	$('#editGuestModal table input[type=number]').val('0');
}
function editGuest(guestID)
{
	prepareModal();
	$('#editGuestModal input[name=action]').val('editGuest');
	$('#editGuestModal input[name=guestID]').val(guestID);
	$('#editGuestModal input[name=eventID]').val('<?= $eventID ?>');
	$('#editGuestModal .actionName').html('Edit');
	$('#editGuestModal .loading').show();
	$('#guestTickets tbody').html('');
	$('#editGuestModal').modal();
	postAction('getGuestByID.php',{'guestID':guestID},function(d){
		//console.log(d);
		$('#editGuestModal .loading').fadeOut();
		$('#editGuestModal input[name=firstName]').val(d.guest.firstName);
		$('#editGuestModal input[name=lastName]').val(d.guest.lastName);
		if(typeof d.guest.extraData != 'undefined')
		{
			$('#editGuestModal input[name=company]').val(d.guest.company);
		}
		$('#editGuestModal input[name=email]').val(d.guest.email);
		$('#editGuestModal input[name=mobile]').val(d.guest.mobile);
		$('#editGuestModal input[name=birthdate]').val(d.guest.birthdate);
		$('#editGuestModal select[name=rsvp]').val(d.guest.rsvp);
		$('#editGuestModal select[name=rsvp]').select2('destroy').select2();
		$('#editGuestModal textarea[name=notes]').val(d.guest.notes);
		$('#editGuestModal input[name=invitedBy]').val(d.guest.invitedBy);
		$('#editGuestModal .ticketsNo').html(d.guest.ticketsNo);
		// if(d.guest.groupID != "0")
		// {
			// console.log();
			// $('#editGuestModal [name=isGroup]').attr('checked',true);
			// $('#editGuestModal [name=isGroup]').parent().addClass('checked');
			// $('#editGuestModal [name=group]').val(d.guest.groupID);
		// }else{
			// $('#editGuestModal input[name=isGroup]').attr('checked',false);
			// $('#editGuestModal [name=isGroup]').parent().removeClass('checked');
		// }
		// checkIsGroup();
		
		
		
	},function(d)
	{
		$('#editGuestModal').modal('hide');
		bootbox.alert(d.msg);
	});
}

function bootboxRemoveGuest(guestID)
{
	bootbox.confirm('Are you sure you want to remove this guest?', function(result){
		if(result){
			$('#remove-guest input[name=guestID]').val(guestID);
			$('#remove-guest').submit();
		}
	});
}
function updateGuest()
{
	return true;
}

function checkIsGroup()
{
	if($('input[name=isGroup]').is(':checked'))
	{
		$('#groupContainer').show();
		if($('select[name=group]').val() == '-1')
			$('input[name=newGroupName]').show();
		else
			$('input[name=newGroupName]').hide();
	}
	else
	{
		$('#groupContainer').hide();
		$('input[name=newGroupName]').hide();
	}		
}

function updateTickets()
{
	var available = {},
		isTicketError = false;
	
	$.extend(available,tickets);
	$('#guests-table .ticket-select').each(function(index, element) {
		var tmpVal = parseInt($(element).parent().parent().find('.ticketsNo').val()) || 1;
        available[$(element).val()] -= tmpVal;
    });
	$.each(available,function(index,value){
		$('#ticket-'+index).html(tickets[index] - value);
		if(value < 0)
		{
			$('#tickets-alert').removeClass('alert-success').addClass('alert-error');
			isError = true;
			isTicketError = true;
			errorCount++;
		}
		else
			if(!isTicketError) $('#tickets-alert').addClass('alert-success').removeClass('alert-error');
	});
}

function updateAddons()
{
	var available = {},
		isAddonError = false;
		
	$.extend(available,addons);
	$('#guests-table .addon-select').each(function(index, element) {
		if($(element).is(':checked'))
		{
			var tmpVal = parseInt($(element).parent().parent().find('.ticketsNo').val()) || 1;
			available[$(element).attr('addonType')]-= tmpVal;
		}
    });
	$.each(available,function(index,value){
		$('#addon-'+index).html(addons[index] - value);
		if(value < 0)
		{
			$('#addons-alert').removeClass('alert-success').addClass('alert-error');
			isError = true;
			isAddonError = true;
			errorCount++;
		}
		else
			if(!isAddonError) $('#addons-alert').addClass('alert-success').removeClass('alert-error');
	});
}
	
function checkAll()
{
	isError = false;
	updateTickets();
	updateAddons();
}
	
$(document).ready(function(e) {
/*	
	guestsTable = $('#guests-table').dataTable({
		"iDisplayLength":50,
		"sPaginationType": "full_numbers",
		"sDom": '<"">t<"F"ip>',
		"oLanguage": {
			"sEmptyTable": "<div class='alert alert-info'>No Guests.</div>"
		},
		"bJQueryUI":true,
		"bFilter":true,
		"bSort":true,
		"bLengthChange":false
	});
*/	
	$('#assign-tickets-form').submit(function(e) {
        checkAll();
		if(isError)
			bootbox.alert("There are still <strong>"+parseInt(errorCount / 2) +"</strong> issues on your spreadsheet.  Please correct them all before continuing.");
		return !isError;
    });
	
	checkAll();
});
</script>