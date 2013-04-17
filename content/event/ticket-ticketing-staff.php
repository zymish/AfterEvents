<div class="alert <?=($totalTickets == $assignedTickets)?"alert-error":"alert-info"?>">There are <strong><?=$totalTickets - $assignedTickets?></strong> of <strong><?=$totalTickets?></strong> Tickets available.</div>
<table class="table table-hover table-condensed table-bordered" id="ticketing-staff-table">
	<thead>
    	<tr>
        	<th>Business Unit</th>
            <?php if(is_array($ticketTypes))foreach($ticketTypes as $type): ?>
            <th nowrap width="80px" class="text-center"><?= htmlentities($type['name']) ?></th>
            <?php endforeach; ?>
            <th nowrap width="80px" class="text-center">Total</th>
            <th width="80px" class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
    	<?php if(is_array($staff))foreach($staff as $staffID => $row):
		$total = 0;
		$userAssigned = 0;
		?>
      <tr>
      	<td><?=$row['businessUnit']?></td>
      	<?php if(is_array($ticketTypes))foreach($ticketTypes as $value):
		$total += intval($row['tickets'][$value['uid']]);
		
		$assigned = 0;
		$sql = "SELECT SUM(`ticketsNo`) as `total` FROM `guests` WHERE `eventID` = '".$eventID."' AND `invitedBy` = '".$row['userID']."' AND `ticketTypeID` = '".$value['uid']."'";
		
		$result = $db->query($sql);
		if($result && $temp = $result->fetch_assoc())
			$assigned = $temp['total'];
			
		$userAssigned += $assigned;
		if(isset($assignedTotal[$value['uid']]))
			$assignedTotal[$value['uid']] += $assigned;
		else
			$assignedTotal[$value['uid']] = $assigned;
		
		if(isset($assignedTotal['all']))
			$assignedTotal['all'] += $assigned;
		else
			$assignedTotal['all'] = $assigned;
		
		?>
      	<td class="text-center <?=(intval($assigned) < intval($row['tickets'][$value['uid']]))?'alert-success':''?>"><?=intval($assigned)?>/<?=intval($row['tickets'][$value['uid']])?></td>
        <?php endforeach; ?>
        <td class="text-center <?=(intval($userAssigned) < intval($total))?'alert-success':''?>"><?=intval($userAssigned)?>/<?=intval($total)?></td>
        <td class="text-center"><div class="btn-group">
        	<button class="btn btn-small btn-success" title="Add Tickets" onClick="addTicketsModal('<?=intval($staffID)?>')"><i class="icon-plus"></i></button>
        </div></td>
      </tr>
        <?php endforeach;?>
        <tr class="alert alert-info">
        	<td><h4>Totals:</h4></td>
            <?php if(is_array($ticketTypes))foreach($ticketTypes as $value):
		$total += intval($row['tickets'][$value['uid']]);
		
		?>
      	<td class="text-center"><strong><?=intval($assignedTotal[$value['uid']])?>/<?=intval($value['assigned'])?></strong></td>
        <?php endforeach; ?>
        <td class="text-center"><strong><?=intval($assignedTotal['all'])?>/<?=$assignedTickets?></strong></td>
        <td>&nbsp;</td>
        </tr>
            
    </tbody>
</table>

<div class="modal hide" id="addTicketsModal">
	<div style="position:absolute;top:44px;right:0;left:0;bottom:0;border-bottom-left-radius::5px;border-bottom-right-radius::5px;background:rgba(0,0,0,0.5);z-index:200" id="loading" class="hide">
    	<center><i class="icon-spinner icon-spin" style="color:white;position:absolute;top:50%;left:50%;font-size:50px;margin-left:-25px;margin-top:-35px;"></i></center>
    </div>
    <form accept-charset="UTF-8" action="<?=SITE_ROOT?>event.tickets/<?=$projectID?>/<?=$eventID?>/" method="post" class="form-horizontal" id="edit-tickets-form">
    	<input type="hidden" name="staffID">
    	<input type="hidden" name="action">
        <input type="hidden" name="eventID" value="<?= $eventID ?>">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3><span class="actionName"></span> Ticket Allocations &nbsp; <small><span class="staffName"></span>, <span class="companyName"></span></small></h3>
        </div>
        <div class="modal-body nopadding">
            <table class="table" style="overflow-x:hidden;">
            	<thead>
                	<tr>
                    	<th>Ticket Type:</th>
                        <th>Current:</th>
                        <th>Available:</th>
                        <th><span class="actionName"></span>:</th>
                        <th>New Total:</th>
                        <th>New Available:</th>
                     </tr>
                 </thead>
                 <tbody>
                 	<?php if(is_array($ticketTypes))foreach($ticketTypes as $type): ?>
                 	<tr id="ticket-row-<?=$type['uid']?>" class="ticket-row" row-id="<?=$type['uid']?>">
                    	<td>&nbsp; <?=htmlentities($type['name'])?> &nbsp; <i class="icon-question-sign" title="<?= htmlentities($type['description']) ?>"></i></td>
                    	<td class="text-center col-total"></td>
                        <td class="text-center col-available"><?= $type['total'] - $type['assigned'] ?></td>
                        <td class="text-center">
                        	<div class="input-prepend">
                              <span class="add-on"><i class="action-icon"></i></span>
                              <input type="number" name="tickets[<?= $type['uid'] ?>]" value="0" class="input-mini" onChange="updateRow('#ticket-row-<?= $type['uid'] ?>')">
                            </div>
                        	
                        </td>
                        <td class="text-center col-new-total"></td>
                        <td class="text-center col-new-available"><?= $type['total'] - $type['assigned'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                 </tbody>
             </table>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Cancel</a>
            <button type="submit" class="btn btn-primary">Save New Ticket Allocation</button>
        </div>
    </form>
</div>

<script>
var hasError = false;

function updateRow(rowID)
{
	var row = $(rowID),
		val = parseInt(row.find('input[type=number]').val(),10) || 0,
		total = parseInt(row.find('.col-total').html(),10) || 0,
		available = parseInt(row.find('.col-available').html(),10) || 0;
	if($('#addTicketsModal input[name=action]').val() == 'remove') val = -val;
		
	row.find('.col-new-total').html(total + val);
	row.find('.col-new-available').html(available - val);
	
	if((total + val) <= 0) row.find('.col-new-total').addClass('alert');
	else row.find('.col-new-total').removeClass('alert');
	
	if((total + val) < 0)
	{
		row.find('.col-new-total').addClass('alert-danger');
		hasError = true;
	}
	else row.find('.col-new-total').removeClass('alert-danger');
	
	if((available - val) <= 0) row.find('.col-new-available').addClass('alert');
	else row.find('.col-new-available').removeClass('alert');
	
	if((available - val) < 0)
	{ 
		row.find('.col-new-available').addClass('alert-danger');
		hasError = true;
	}
	else row.find('.col-new-available').removeClass('alert-danger');
}

function clearTicketsModal()
{
	$('#addTicketsModal .action-icon').removeClass('icon-plus').removeClass('icon-minus');
	$('#addTicketsModal .actionName').html('');
	$('#addTicketsModal .staffName').html('');
	$('#addTicketsModal .companyName').html('');
	$('#addTicketsModal .col-total').html('0');
	$('#addTicketsModal .col-new-total').html('0');
	$('#addTicketsModal .col-new-available').html('0');
	$('#addTicketsModal input[type=number]').val(0);
	$('#addTicketsModal input[name=action]').val('');
	$('#addTicketsModal input[name=staffID]').val('');
}
function addTicketsModal(staffID)
{
	clearTicketsModal();
	$('#addTicketsModal .action-icon').addClass('icon-plus');
	$('#addTicketsModal .actionName').html('Add');
	$('#addTicketsModal input[name=action]').val('add');
	$('#addTicketsModal #loading').show();
	$('#addTicketsModal').modal();
	postAction('getStaffByID.php',{staffID:staffID},function(d){
		$('#addTicketsModal input[name=staffID]').val(d.staffID);
		$('#addTicketsModal .staffName').html(d.firstName + " " + d.lastName);
		$('#addTicketsModal .companyName').html(d.company);
		$('#addTicketsModal .ticket-row').each(function(index, element) {
			var rowID = $(element).attr('row-id');
            $(element).find('.col-total').html(d.tickets[rowID]);
			updateRow(element);
        });
		$('#addTicketsModal #loading').fadeOut();
	},function(d){
		$('#addTicketsModal').modal('hide');
		bootbox.alert(d.msg);
	});
}

function removeTicketsModal(staffID)
{
	clearTicketsModal();
	$('#addTicketsModal .action-icon').addClass('icon-minus');
	$('#addTicketsModal .actionName').html('Remove');
	$('#addTicketsModal input[name=action]').val('remove');
	$('#addTicketsModal #loading').show();
	$('#addTicketsModal').modal();
	getStaffByID(staffID,function(d){
		$('#addTicketsModal input[name=staffID]').val(d.staffID);
		$('#addTicketsModal .staffName').html(d.firstName + " " + d.lastName);
		$('#addTicketsModal .companyName').html(d.company);
		$('#addTicketsModal .ticket-row').each(function(index, element) {
			var rowID = $(element).attr('row-id');
            $(element).find('.col-total').html(d.tickets[rowID]);
			$(element).find('.col-available').html(d.tickets[rowID]);
			updateRow(element);
        });
		$('#addTicketsModal #loading').fadeOut();
	});
}

$('#edit-tickets-form').submit(function(e) {
	hasError = false;
	$('#addTicketsModal .ticket-row').each(function(index, element) {
		updateRow(element);
	});
	if(hasError)
	{
		bootbox.alert('Invalid Ticket Allocations.');
	}
	return !hasError;
});
</script>