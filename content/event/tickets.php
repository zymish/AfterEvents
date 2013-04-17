<?php require_once('event-nav.php'); ?>
<div class='widget-box'>
    <div class='widget-title'>
        <div class="buttons">
        <?php if(checkPermission(array($projectID,'events',$eventID,'tickets','types','create'))): ?>
	        <button class="btn btn-success" onClick="newTicketTypeModal()"><i class="icon-plus"></i> Add New Ticket Type</button>
        <?php endif; ?>
        </div>
        <ul class="nav nav-tabs">
            <li class="active"><a href="#ticketing-staff" data-toggle="tab">Ticket Assignments</a></li>
        <?php if(checkPermission(array($projectID,'events',$eventID,'tickets','types','view'))): ?>
            <li><a href="#ticket-types" data-toggle="tab">Allocate Overall Event Tickets</a></li>
        <?php endif; ?> 
        </ul>
    </div>
    <div class='widget-content tab-content'>
        <div id="ticketing-staff" class="tab-pane active"><?php require_once(dirname(__FILE__)."/ticket-ticketing-staff.php") ?></div>
    <?php if(checkPermission(array($projectID,'events',$eventID,'tickets','types','view'))): ?>
        <div id="ticket-types" class="tab-pane"><?php require_once(dirname(__FILE__)."/ticket-types.php") ?></div>
    <?php endif; ?> 
    </div>
</div>

<div class="modal hide" id="addTicketTypeModal">
	<div style="position:absolute;top:44px;right:0;left:0;bottom:0;border-bottom-left-radius::5px;border-bottom-right-radius::5px;background:rgba(0,0,0,0.5);z-index:200" id="loading" class="hide">
    	<center><i class="icon-spinner icon-spin" style="color:white;position:absolute;top:50%;left:50%;font-size:50px;margin-left:-25px;margin-top:-35px;"></i></center>
    </div>
    <form accept-charset="UTF-8" action="<?=SITE_ROOT?>event.tickets/<?=$projectID?>/<?=$eventID?>/" method="post" class="form-horizontal">
    	<input type="hidden" name="ticketTypeID">
    	<input type="hidden" name="action">
        <input type="hidden" name="eventID" value="<?= $eventID ?>">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3><span class="actionName"></span> Ticket Type</h3>
        </div>
        <div class="modal-body">
        	<div class="control-group topLabels">
                	<div class="text-right" style="width:125px;margin-right:40px;display:inline-block"><strong>Field</strong></div>
                	<strong>New Value</strong>
                    <strong class="help-inline pull-right">Previous Value</strong>
            </div>
            <div class="control-group">
                <label class="control-label">Ticket Name:</label>
                <div class="controls">
                	<input type="text" name="name" placeholder="Ticket Name">
                    <span class="help-inline ticketName pull-right"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Price: </label>
                <div class="controls">
                	<div class="input-prepend">
                        <span class="add-on">$</span>
                        <input type="text" class="input-small" name="price" placeholder="Price">
                    </div>
                    <span class="help-inline ticketPrice pull-right"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Total Tickets:</label>
                <div class="controls">
                	<input type="number" class="input-small" name="total" placeholder="Total">
                    <span class="help-inline ticketTotal pull-right"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Description:</label>
                <div class="controls">
                	<textarea name="description" class="input-block-level" placeholder="Description" rows="3"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Cancel</a>
            <button type="submit" class="btn btn-primary"><span class="actionName"></span> Ticket Type</button>
        </div>
    </form>
</div>
<script>
function prepareTicketTypeModal()
{
	$('#addTicketTypeModal .actionName').html('');
	$('#addTicketTypeModal [name=ticketTypeID]').val('');
	$('#addTicketTypeModal [name=action]').val('');
	$('#addTicketTypeModal [name=name]').val('');
	$('#addTicketTypeModal [name=price]').val('');
	$('#addTicketTypeModal [name=total]').val('');
	$('#addTicketTypeModal [name=description]').val('');
	$('#addTicketTypeModal .ticketName').html('');
	$('#addTicketTypeModal .ticketPrice').html('');
	$('#addTicketTypeModal .ticketTotal').html('');
	$('#addTicketTypeModal .topLabels').hide();
}
function newTicketTypeModal()
{
	prepareTicketTypeModal();
	$('#addTicketTypeModal .actionName').html('Create New');
	$('#addTicketTypeModal [name=action]').val('newType');
	$('#addTicketTypeModal').modal();
}
function editTicketTypeModal(typeID)
{
	prepareTicketTypeModal();
	$('#addTicketTypeModal [name=ticketTypeID]').val(typeID);
	$('#addTicketTypeModal .actionName').html('Edit');
	$('#addTicketTypeModal [name=action]').val('editType');
	$('#addTicketTypeModal .topLabels').show();
	$('#addTicketTypeModal #loading').show();
	$('#addTicketTypeModal').modal();
	postAction('getTicketTypeByID.php',{typeID:typeID},function(d){
		$('#addTicketTypeModal #loading').fadeOut();
		$('#addTicketTypeModal [name=name]').val(d.type.name);
		$('#addTicketTypeModal [name=price]').val(d.type.price);
		$('#addTicketTypeModal [name=total]').val(d.type.total);
		$('#addTicketTypeModal [name=description]').val(d.type.description);
		$('#addTicketTypeModal .ticketName').html(d.type.name);
		$('#addTicketTypeModal .ticketPrice').html('$' + d.type.price);
		$('#addTicketTypeModal .ticketTotal').html(d.type.total);
	});
}
$(document).ready(function(e) {
	$('.datepicker').datepicker();
});
</script>