<?php require_once('event-nav.php'); ?>
<div class='widget-box'>
    <div class='widget-title'>
        <div class="buttons">
        <?php if(checkPermission(array($projectID,'events',$eventID,'addons','types','create'))): ?>
	        <button class="btn btn-success" onClick="newHospTypeModal()"><i class="icon-plus"></i> Add New Addons Type</button>
        <?php endif; ?>
        </div>
		<ul class="nav nav-tabs">
			<li class="<?=(!isset($site['page'][EVENT_INDEX+1]) || !in_array($site['page'][EVENT_INDEX+1],array('admin','order')))?"active":""?>">
            	<a href="#addons" data-toggle="tab">Addons</a>
            </li>
            <?php if(checkPermission(array($projectID,'events',$eventID,'addons','admin'))): ?>
			<li class="<?=(isset($site['page'][EVENT_INDEX+1]) && $site['page'][EVENT_INDEX+1] == "admin")?"active":""?>">
            	<a href="#addons-admin" data-toggle="tab">Admin</a>
            </li>
<?php /* ?>
			<li><a href="#addons-packs" data-toggle="tab">Addons</a></li>
<?php */ ?>
            <?php endif; ?>
            <li class="<?=(isset($site['page'][EVENT_INDEX+1]) && $site['page'][EVENT_INDEX+1] == "oder")?"active":""?>">
            	<a href='#addons-purchase' data-toggle='tab'>Request Addons</a>
            </li>
		</ul>
    </div>
    <div class='widget-content tab-content'>
        <div id="addons" class="tab-pane <?=(!isset($site['page'][EVENT_INDEX+1]) || !in_array($site['page'][EVENT_INDEX+1],array('admin','order')))?"active":""?>">
			<?php require_once(dirname(__FILE__)."/addons-addons.php") ?>
        </div>
        <div id="addons-admin" class="tab-pane <?=(isset($site['page'][EVENT_INDEX+1]) && $site['page'][EVENT_INDEX+1] == "admin")?"active":""?>">
			<?php require_once(dirname(__FILE__)."/addons-admin.php") ?>
        </div>
<?php /* ?>
        <div id="addons-packs" class="tab-pane"><?php require_once(dirname(__FILE__)."/addons-packs.php") ?></div>
<?php */ ?>
		<div id="addons-purchase" class="tab-pane <?=(isset($site['page'][EVENT_INDEX+1]) && $site['page'][EVENT_INDEX+1] == "order")?"active":""?>">
			<?php require_once(dirname(__FILE__)."/addons-purchase.php") ?>
        </div>
    </div>
</div>
<div class="modal hide" id="addHospTypeModal">
	<div style="position:absolute;top:44px;right:0;left:0;bottom:0;border-bottom-left-radius::5px;border-bottom-right-radius::5px;background:rgba(0,0,0,0.5);z-index:200" id="loading" class="hide">
    	<center><i class="icon-spinner icon-spin" style="color:white;position:absolute;top:50%;left:50%;font-size:50px;margin-left:-25px;margin-top:-35px;"></i></center>
    </div>
    <form accept-charset="UTF-8" action="<?=SITE_ROOT?>event.addons/<?=$projectID?>/<?=$eventID?>/" method="post" class="form-horizontal">
    	<input type="hidden" name="hospTypeID">
    	<input type="hidden" name="action">
        <input type="hidden" name="eventID" value="<?= $eventID ?>">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3><span class="actionName"></span> Addons Type</h3>
        </div>
        <div class="modal-body">
        	<div class="control-group topLabels">
                	<div class="text-right" style="width:125px;margin-right:40px;display:inline-block"><strong>Field</strong></div>
                	<strong>New Value</strong>
                    <strong class="help-inline pull-right">Previous Value</strong>
            </div>
            <div class="control-group">
                <label class="control-label">Addons Name:</label>
                <div class="controls">
                	<input type="text" name="name" placeholder="Addons Name">
                    <span class="help-inline hospName pull-right"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Price: </label>
                <div class="controls">
                	<div class="input-prepend">
                        <span class="add-on">$</span>
                        <input type="text" class="input-small" name="price" placeholder="Price">
                    </div>
                    <span class="help-inline hospPrice pull-right"></span>
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
            <button type="submit" class="btn btn-primary"><span class="actionName"></span> Addons Type</button>
        </div>
    </form>
</div>
<script>
function prepareHospTypeModal()
{
	$('#addHospTypeModal .actionName').html('');
	$('#addHospTypeModal [name=hospTypeID]').val('');
	$('#addHospTypeModal [name=action]').val('');
	$('#addHospTypeModal [name=name]').val('');
	$('#addHospTypeModal [name=price]').val('');
	$('#addHospTypeModal [name=total]').val('');
	$('#addHospTypeModal [name=description]').val('');
	$('#addHospTypeModal .hospName').html('');
	$('#addHospTypeModal .hospPrice').html('');
	$('#addHospTypeModal .hospTotal').html('');
	$('#addHospTypeModal .topLabels').hide();
}

function newHospTypeModal()
{
	prepareHospTypeModal();
	$('#addHospTypeModal .actionName').html('Create New');
	$('#addHospTypeModal [name=action]').val('newType');
	$('#addHospTypeModal').modal();
}

$(document).ready(function(e) {
	$('.datepicker').datepicker();
});
</script>