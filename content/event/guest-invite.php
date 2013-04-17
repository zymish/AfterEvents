<?php require_once('event-nav.php'); ?>
<?php if(!checkPermission(array($projectID,'events',$eventID,'guests','invite'))) continue;?>
<div class='widget-box'>
    <div class='widget-title'>
        <span class='icon'>
            <i class='icon-user'></i>
        </span>
        <h5>Invite Single Guest</h5>
    </div>
    <div class='widget-content'>
    <form accept-charset="UTF-8" action="" method="post" class="form-horizontal" id="inviteGuest">
    	<input type="hidden" name="action" value="inviteGuest">
        <div class="control-group">
            <label class="control-label">Name:</label>
            <div class="controls">
                <input type="text" placeholder="First Name" name="firstName" class="input-small"> &nbsp;
                <input type='text' placeholder='Last Name' name='lastName' class="input-small">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Email:</label>
            <div class="controls">
                <input type="text" placeholder='Email' name="email">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Mobile Number:</label>
            <div class="controls">
                <input type="text" placeholder="Mobile" name="mobile">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Company:</label>
            <div class="controls">
                <input type="text" placeholder="Company" name="company">
            </div>
        </div>
        <!--<div class='control-group'>
            <label class='control-label'>In a Group?:</label>
            <div class='controls'>
                <input type="checkbox" name="isGroup" value="isGroup" onChange="checkIsGroup()">
                <span id="groupContainer" class="hide">
                    <select name="group" class="input-large" onChange="checkIsGroup()">
                        <option value="-1">New Group</option>
                    <?php if(is_array($groups))foreach($groups as $group): ?>
                        <option value="<?= $group['uid'] ?>"><?= htmlentities($group['name']) ?></option>
                    <?php endforeach;?>
                    </select>
                    <input type="text" placeholder="New Group Name" name="newGroupName" class="input-medium hide">
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
            <label class='control-label'>Notes:</label>
            <div class='controls'>
                <textarea placeholder='Notes' name='notes' class="input-xlarge"></textarea>
            </div>
        </div>
        <div class='control-group'>
            <label class='control-label'>Ticket Type:</label>
            <div class='controls'>
                <select name="ticketTypeID" class="input-large">
                <?php if(is_array($ticketTypes)) foreach($ticketTypes as $type): if(empty($type['left'])) continue; ?>
                	<option value="<?=$type['uid']?>"><?= htmlentities($type['name']) ?> (<?= $type['left'] ?> Remaining)</option>
                <?php endforeach; ?>
                </select>
            </div>
        </div>
		<div class='control-group'>
			<label class='control-label'>Number of Tickets:</label>
			<div class='controls'>
				<input name='ticketsNo' class='input-large'>
			</div>
		</div>
        <div class='control-group'>
            <label class='control-label'></label>
            <div class='controls'>
                <button type="submit" class="btn btn-success">Invite Guest</button>
            </div>
        </div>
    </form>
    </div>
</div>

<script type='text/javascript'>
// function checkIsGroup()
// {
	// if($('input[name=isGroup]').is(':checked'))
	// {
		// $('#groupContainer').show();
		// if($('select[name=group]').val() == '-1')
			// $('input[name=newGroupName]').show();
		// else
			// $('input[name=newGroupName]').hide();
	// }
	// else
	// {
		// $('#groupContainer').hide();
		// $('input[name=newGroupName]').hide();
	// }		
// }

$(document).ready(function(e) {
	$('.datepicker').datepicker();
	
	<?php if(!$canInvite) echo "$('#inviteGuest :input').attr('disabled',true)"; ?>
});
</script>