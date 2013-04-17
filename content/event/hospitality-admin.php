<table class="table table-striped table-hover table-condensed table-bordered" id="addon-staff-table">
	<thead>
    	<tr>
        	<th>Business Unit</th>
            <?php foreach($addons as $type): ?>
            <th nowrap width="80px" class="text-center">&nbsp; <?= htmlentities($type['name']) ?> &nbsp;</th>
            <?php endforeach; ?>
            <th nowrap width="80px" class="text-center">&nbsp; Total &nbsp;</th>
            <th width="100px" class="text-center">&nbsp; Actions &nbsp;</th>
        </tr>
    </thead>
    <tbody>
    <?php if(is_array($staff))foreach($staff as $staffID => $row):
		$total = 0;
		?>
      <tr>
      	<td><?=$row['businessUnit']?></td>
      	<?php if(is_array($addons))foreach($addons as $value):
		$total += intval($row['addons'][$value['uid']]); ?>
      	<td class="text-center"><?=intval($row['addons'][$value['uid']])?></td>
        <?php endforeach; ?>
        <td class="text-center"><?=intval($total)?></td>
        <td class="text-center"><div class="btn-group">
        	<button class="btn btn-small btn-success" title="Add Addons" onClick="addAddonsModal('<?=intval($staffID)?>')"><i class="icon-plus"></i></button>
        </div></td>
      </tr>
        <?php endforeach;?>
        <tr class="alert alert-info">
        	<td><h4>Totals:</h4></td>
            <?php $total = 0;if(is_array($addons))foreach($addons as $value):
		$total += intval($row['addons'][$value['uid']]); ?>
      	<td class="text-center"><strong><?=intval($row['addons'][$value['uid']])?></strong></td>
        <?php endforeach; ?>
        <td class="text-center"><strong><?=intval($total)?></strong></td>
        <td>&nbsp;</td>
        </tr>
    </tbody>
</table>

<div class="modal hide" id="addAddonsModal">
	<div style="position:absolute;top:44px;right:0;left:0;bottom:0;border-bottom-left-radius::5px;border-bottom-right-radius::5px;background:rgba(0,0,0,0.5);z-index:200" id="loading" class="hide">
    	<center><i class="icon-spinner icon-spin" style="color:white;position:absolute;top:50%;left:50%;font-size:50px;margin-left:-25px;margin-top:-35px;"></i></center>
    </div>
    <form accept-charset="UTF-8" action="<?=SITE_ROOT?>event.hospitality/<?=$projectID?>/<?=$eventID?>/admin" method="post" class="form-horizontal">
    	<input type="hidden" name="staffID">
    	<input type="hidden" name="action">
        <input type="hidden" name="eventID" value="<?= $eventID ?>">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3><span class="actionName"></span> Addon Allocations &nbsp; <small><span class="staffName"></span>, <span class="companyName"></span></small></h3>
        </div>
        <div class="modal-body nopadding">
            <table class="table" style="overflow-x:hidden;">
            	<thead>
                	<tr>
                    	<th>Addon:</th>
                        <th>Current:</th>
                        <th>Available:</th>
                        <th><span class="actionName"></span>:</th>
                        <th>New Total:</th>
                        <th>New Available:</th>
                     </tr>
                 </thead>
                 <tbody>
                 	<?php if(is_array($addons))foreach($addons as $type): ?>
                 	<tr id="addon-row-<?=$type['uid']?>" class="addon-row" row-id="<?=$type['uid']?>">
                    	<td>&nbsp; <?=htmlentities($type['name'])?> &nbsp; <i class="icon-question-sign" title="<?= htmlentities($type['description']) ?>"></i></td>
                    	<td class="text-center col-total"></td>
                        <td class="text-center col-available"></td>
                        <td class="text-center">
                        	<div class="input-prepend">
                              <span class="add-on"><i class="action-icon"></i></span>
                              <input type="number" name="addons[<?= $type['uid'] ?>]" value="0" class="input-mini" onChange="updateRow('#addon-row-<?= $type['uid'] ?>')">
                            </div>
                        	
                        </td>
                        <td class="text-center col-new-total"></td>
                        <td class="text-center col-new-available"></td>
                    </tr>
                    <?php endforeach; ?>
                 </tbody>
             </table>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Cancel</a>
            <button type="submit" class="btn btn-primary">Save New Allocations</button>
        </div>
    </form>
</div>
<script>
var addonStaffTable;

function updateRow(rowID)
{
	var row = $(rowID),
		val = parseInt(row.find('input[type=number]').val(),10) || 0,
		total = parseInt(row.find('.col-total').html(),10) || 0,
		available = parseInt(row.find('.col-available').html(),10) || 0;
	if($('#addAddonsModal input[name=action]').val() == 'remove') val = -val;
		
	row.find('.col-new-total').html(total + val);
	row.find('.col-new-available').html(available + val);
	
	if((total + val) <= 0) row.find('.col-new-total').addClass('alert');
	else row.find('.col-new-total').removeClass('alert');
	
	if((total + val) < 0) row.find('.col-new-total').addClass('alert-danger');
	else row.find('.col-new-total').removeClass('alert-danger');
	
	if((available + val) <= 0) row.find('.col-new-available').addClass('alert');
	else row.find('.col-new-available').removeClass('alert');
	
	if((available + val) < 0) row.find('.col-new-available').addClass('alert-danger');
	else row.find('.col-new-available').removeClass('alert-danger');
}

function clearAddonsModal()
{
	$('#addAddonsModal .action-icon').removeClass('icon-plus').removeClass('icon-minus');
	$('#addAddonsModal .actionName').html('');
	$('#addAddonsModal .staffName').html('');
	$('#addAddonsModal .companyName').html('');
	$('#addAddonsModal .col-total').html('0');
	$('#addAddonsModal .col-available').html('0');
	$('#addAddonsModal .col-new-total').html('0');
	$('#addAddonsModal .col-new-available').html('0');
	$('#addAddonsModal input[type=number]').val(0);
	$('#addAddonsModal input[name=action]').val('');
	$('#addAddonsModal input[name=staffID]').val('');
}
function addAddonsModal(staffID)
{
	clearAddonsModal();
	$('#addAddonsModal .action-icon').addClass('icon-plus');
	$('#addAddonsModal .actionName').html('Add');
	$('#addAddonsModal input[name=action]').val('add');
	$('#addAddonsModal #loading').show();
	$('#addAddonsModal').modal();
	postAction('getStaffByID.php',{staffID:staffID},function(d){
		$('#addAddonsModal input[name=staffID]').val(d.staffID);
		$('#addAddonsModal .staffName').html(d.firstName + " " + d.lastName);
		$('#addAddonsModal .companyName').html(d.company);
		$('#addAddonsModal .addon-row').each(function(index, element) {
			var rowID = $(element).attr('row-id');
            $(element).find('.col-total').html(d.addons[rowID]);
			$(element).find('.col-available').html(d.addons[rowID]);
			updateRow(element);
        });
		$('#addAddonsModal #loading').fadeOut();
	},function(d){
		$('#addAddonsModal').modal('hide');
		bootbox.alert(d.msg);
	});
}

$(document).ready(function(e) {
});
</script>