<?php require_once('event-nav.php'); ?>
<style>
#guests-table .smaller-font{font-size:12px;}
</style>
<table class="table table-striped table-condensed table-hover table-bordered data-table" id='guests-table'>
	<thead>
    	<tr>
			<th nowrap>&nbsp; Edit &nbsp;</th>
            <th nowrap>&nbsp; Last Name &nbsp;</th>
			<th nowrap>&nbsp; First Name &nbsp;</th>
			<th nowrap>&nbsp; # TIX &nbsp;</th>
			<th nowrap>&nbsp; Type</th>
			<th nowrap>&nbsp; RSVP &nbsp;</th>
            <!--<th nowrap>&nbsp; Group &nbsp;</th>-->
            <th nowrap>&nbsp; Invited By &nbsp;</th>
			<?php /* ?><th nowrap>&nbsp; Hospitality &nbsp;</th> <?php */ ?>
			<th nowrap>&nbsp; Notes &nbsp;</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<div class="modal hide edit_guest_modal" id="editGuestModal">
	<div style="position:absolute;top:44px;right:0;left:0;bottom:0;border-bottom-left-radius::5px;border-bottom-right-radius::5px;background:rgba(0,0,0,0.5);z-index:200" class="hide loading">
    	<center><i class="icon-spinner icon-spin" style="color:white;position:absolute;top:50%;left:50%;font-size:50px;margin-left:-25px;margin-top:-35px;"></i></center>
    </div>
    <form accept-charset="UTF-8" action="<?= SITE_ROOT ?>event.guests-assignTickets/<?= $projectID ?>/<?= $eventID ?>" method="post" class="form-horizontal">
    	<input type="hidden" name="guestID">
    	<input type="hidden" name="action">
    	<input type="hidden" name="userID">
        <input type="hidden" name="eventID">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>View Guest</h3>
        </div>
        <div class="modal-body edit_guest_modal_body">
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
			<!--<div class='control-group'>
                <label class='control-label'><strong>In a Group?:</strong></label>
                <div class='controls'>
                    <input type="checkbox" name="isGroup" value="isGroup" onChange="checkIsGroup()">
                    <span id="groupContainer" class="hide">
                        <select name="group" class="input-large" onChange="checkIsGroup()">
                            <option value="-1">New Group</option>
                        <?php if(is_array($groups))foreach($groups as $group): ?>
                            <option value="<?= $group['uid'] ?>"><?= htmlentities($group['name']) ?></option>
                        <?php endforeach;?>
                        </select>
                        <input type="text" placeholder="New Group Name" name="newGroupName" class="indent input-medium hide">
    				</span>
                </div>
            </div>-->
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
				<label class='control-label'><strong># TIX:</strong></label>
				<div class='controls'>
					<input type='text' disabled name='ticketsNo'>
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
<script type='text/javascript'>
var allGuests = true;
var guestsTable;

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
		$('#editGuestModal textarea[name=notes]').val(d.guest.notes);
		$('#editGuestModal input[name=invitedBy]').val(d.guest.invitedBy);
		$('#editGuestModal [name=ticketsNo]').val(d.guest.ticketsNo);
		$('#editGuestModal [name=group]').html('<option value="-1">New Group</option>');
		$.each(d.groups,function(index,value){
			$('#editGuestModal [name=group]').append('<option value="'+value.uid+'">'+value.name+'</option>');
		});
		if(d.guest.groupID != "0")
		{
			$('#editGuestModal [name=isGroup]').attr('checked',true);
			$('#editGuestModal [name=isGroup]').parent().addClass('checked');
			$('#editGuestModal [name=group]').val(d.guest.groupID);
		}else{
			$('#editGuestModal input[name=isGroup]').attr('checked',false);
			$('#editGuestModal [name=isGroup]').parent().removeClass('checked');
		}
		$('#editGuestModal select').select2("destroy").select2();
		checkIsGroup();
		
	},function(d)
	{
		$('#editGuestModal').modal('hide');
		bootbox.alert(d.msg);
	});
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

function resendInviteConfirm(guestID)
{
	bootbox.confirm('Are you sure you want to resend the invite email to this guest?', function(result){
		if(result){
			bootbox.alert('Sending Email...');
			postAction('resendGuestInvite.php',{'guestID':guestID,'eventID':'<?=$eventID?>'},function(d){
				bootbox.alert(d.msg);
			},function(d){
				bootbox.alert(d.msg);
			});
		}
	});	
}

$(document).ready(function(e) {
	$('.datepicker').datepicker();
	
	<?php if(!$canInvite) echo "$('#inviteGuest :input').attr('disabled',true)"; ?>

	guestsTable = $('#guests-table').dataTable(
	{
		"iDisplayLength":50,
		"fnInitComplete": function() {
			$('#guests-table tbody td').attr('nowrap','nowrap');
		},
		"sPaginationType": "full_numbers",
		"sDom": '<"H"lfr>t<"F"ip>',
		"oLanguage": {
			"sEmptyTable": "<div class='alert alert-info'>No Guests To View.</div>"
		},
		"bJQueryUI":true,
		"bFilter":true,
		"bLengthChange":false,
		"bProcessing":true,
		"bServerSide":true,
		"sAjaxSource":ACTIONS_PATH + "dataTables.getGuests.php",
		"fnServerParams": function ( aoData ) {
		  aoData.push( { "name": "invitedBy", "value": (allGuests)?0:"<?=getCurrentUserID()?>"},{ "name":"eventID","value": "<?= $eventID ?>" } );
		},
		"bAutoWidth": true,
        "aoColumns" : [
            { sWidth: '75px',"sClass": "ellipsis text-center","bSortable": false,"bSearchable": false },
			{ sWidth: '10%',"sClass": "ellipsis" },
			{ sWidth: '10%',"sClass": "ellipsis" },
            { sWidth: '50px',"sClass": "ellipsis" },
			{ sWidth: '50px',"sClass": "ellipsis" },
			{ sWidth: '70px',"sClass": "ellipsis text-center" },
			{ sWidth: '15%',"sClass": "ellipsis" },
            //{ sWidth: '60px',"sClass": "ellipsis text-center","bSortable": false,"bSearchable": false },
            { sWidth: '200px',"sClass": "ellipsis smaller-font" }
        ]
	});
});
</script>