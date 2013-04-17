<?php require_once('event-nav.php'); ?>
<?php if(isset($_GET['email'])) $email = $_GET['email'];?>
<?php echo $email;?>
<br>
<div class="alert alert-info"><i class="icon-hdd"></i>&nbsp; There are <strong class="numGuests"><?= $numTickets ?></strong> Tickets on this spreadsheet.  You have <strong><?=$user['tickets']['available']?></strong> Tickets available.</div>

<?php if(!empty($badEntries)): ?>
	<div class="alert alert-error"><i class="icon-hdd"></i>&nbsp; There where <strong><?=$badEntries?></strong> Bad Entries that are not displayed.</div>
<?php endif; ?>


<div id="tooManyInvites" class="alert alert-error hide"><i class="icon-film"></i>&nbsp; You are attempting to allocate more tickets then you have available.  You need to remove <strong></strong> tickets.</div>
<form accept-charset="UTF-8" action="<?=SITE_ROOT."event.guests-upload/".$projectID."/".$eventID?>" method="post" id="confirm-guests-form">
    <input type="hidden" name="action" value="addGuests">
	<?php if($email == 'noEmail'):?><input type='hidden' name='noEmail' value='noEmail'><?php endif;?>
    <table class="table table-bordered table-condensed" id="upload-table">
        <thead>
            <tr>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Email Address</th>
                <th>Tickets No</th>
                <th>Notes</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
	<?php
		if(is_array($guests))
        foreach($guests as $guestID => $guest) {
            if($guest['group'] === $group_name) {
    ?>
            <tr class="alert" id="row-<?=$guestID?>">
                <td class="text-center" field="Last Name"><input type='text' name="row[<?=$guestID?>][lastName]" value="<?=$guest['lastName']?>" class="input-medium" rowID="#row-<?=$guestID?>"><div class="i-container" style="margin-left:10px;width:24px;height:24px;display:inline-block;"></div></td>
                <td class="text-center" field="First Name"><input type='text' name="row[<?=$guestID?>][firstName]" value="<?=$guest['firstName']?>" class="input-medium" rowID="#row-<?=$guestID?>"><div class="i-container" style="margin-left:10px;width:24px;height:24px;display:inline-block;"></div></td>
                <td class="text-center" field="Email"><input type='text' name="row[<?=$guestID?>][email]" value="<?=$guest['email']?>" class="input-medium" rowID="#row-<?=$guestID?>"><div class="i-container" style="margin-left:10px;width:24px;height:24px;display:inline-block;"></div></td>
                <td class="text-center" field="Tickets No"><input type='text' name="row[<?=$guestID?>][ticketsNo]" value="<?=$guest['ticketsNo']?>" class="input-mini ticketsNo" rowID="#row-<?=$guestID?>"><div class="i-container" style="margin-left:10px;width:24px;height:24px;display:inline-block;"></div></td>
                <td class="text-center" field="notes"><input type='text' name="row[<?=$guestID?>][notes]" value="<?=$guest['notes']?>" class="input-xxlarge" rowID="#row-<?=$guestID?>"><div class="i-container" style="margin-left:10px;width:24px;height:24px;display:inline-block;"></div></td>
                <input type="hidden" name="row[<?=$guestID?>][mobile]" value="<?=$guest['mobile']?>">
                <input type="hidden" name="row[<?=$guestID?>][extraData][company]" value="<?=$guest['company']?>">
                <input type="hidden" name="row[<?=$guestID?>][responsible]" value="<?=$guest['responsible']?>">
                <td class="text-center"><button type="button" class='btn btn-danger btn-small' title='Remove Guest' onclick='removeRow("#row-<?=$guestID?>")'><i class='icon-remove'></i></button></td>
            </tr>
    <?php
            }
        ?>
    <?php
        }
    ?>
        </tbody>
    </table>
    <br />
    <div class="pull-left">
    	<button type="button" class='btn btn-info' title='Add Row' onclick='addRow()'><i class='icon-plus'></i>&nbsp; Add New Row</button>
    </div>
    <div class="pull-right">
    	<button type="submit" class="btn btn-success"><i class="icon-save"></i>&nbsp; Save Guest Data</button>
    </div>
</form>
<script>
var isError = false,
	errorCount = 0,
	uploadTable,
	totalTickets = <?=$user['tickets']['available']?>;
	
function addRow()
{
	var guestID = $('#upload-table tbody tr.alert').size()+4;
	$('#upload-table tbody').append('<tr class="alert" id="row-' + guestID + '"><td class="text-center" field="Last Name"><input type="text" name="row[' + guestID + '][lastName]" value="" class="input-medium" rowID="#row-' + guestID + '"><div class="i-container" style="margin-left:10px;width:24px;height:24px;display:inline-block;"></div></td><td class="text-center" field="First Name"><input type="text" name="row[' + guestID + '][firstName]" value="" class="input-medium" rowID="#row-' + guestID + '"><div class="i-container" style="margin-left:10px;width:24px;height:24px;display:inline-block;"></div></td><td class="text-center" field="Email"><input type="text" name="row[' + guestID + '][email]" value="" class="input-medium" rowID="#row-' + guestID + '"><div class="i-container" style="margin-left:10px;width:24px;height:24px;display:inline-block;"></div></td><td class="text-center" field="Tickets No"><input type="text" name="row[' + guestID + '][ticketsNo]" value="1" class="input-mini ticketsNo" rowID="#row-' + guestID + '"><div class="i-container" style="margin-left:10px;width:24px;height:24px;display:inline-block;"></div></td><td class="text-center" field="notes"><input type="text" name="row[' + guestID + '][notes]" value="" class="input-xxlarge" rowID="#row-' + guestID + '"><div class="i-container" style="margin-left:10px;width:24px;height:24px;display:inline-block;"></div></td><input type="hidden" name="row[' + guestID + '][mobile]" value=""><input type="hidden" name="row[' + guestID + '][extraData][company]" value=""><input type="hidden" name="row[' + guestID + '][responsible]" value=""><td class="text-center"><button class="btn btn-danger btn-small" title="Remove Guest" onclick="removeRow(\'#row-' + guestID + '\')"><i class="icon-remove"></i></button></td></tr>');
	checkAll();
}

function checkRow(rowID)
{
	var row = $(rowID),
		hasError = false;
		
	row.removeClass('alert-error').removeClass('alert-success').removeClass('alert-warning');
	row.find('.i-container i').remove();
	
	row.find('td').each(function(index,element){
		var field = $(element).attr('field') || null,
			value = $(element).find(':input').val() || '';
		
		if(field == null || field == '') return true;
		
		if(field == 'Email' && (value == '' || !isValidEmailAddress(value))){
			$(element).find('.i-container').html('<i class="icon-exclamation-sign" style="font-size:20px;" title="Invalid Email"></i>');
			row.addClass('alert-error'); 
			hasError = true;
			isError = true;
			errorCount++;
		}else if(field == 'Group')
		{
			
		}
		else if(field == 'rawData')
		{
			row.addClass('alert-error'); 
			hasError = true;
			isError = true;
			errorCount++;
		}
		else if(value == '')
		{
			$(element).find('.i-container').html('<i class="icon-info-sign" style="font-size:20px;" title="'+field+' is Empty"></i>');
			row.addClass('alert-warning'); 
			hasError = true;
		}
	});
	if(!hasError) row.addClass('alert-success'); 
	return parseInt(row.find('.ticketsNo').val()) || 1;
}

function checkAll()
{
	var ticketsNo = 0;
	isError = false;
	errorCount = 0;
	$('#upload-table tbody tr.alert').each(function(index, element) {
		ticketsNo += checkRow(element);
    });
	$('.numGuests').html(ticketsNo);
	$('#tooManyInvites strong').html($('.numGuests').html() - totalTickets);
	if(parseInt($('.numGuests').html()) > totalTickets)
	{
		$('#tooManyInvites').show();
		isError = true;
		errorCount++;
	}else
		$('#tooManyInvites').hide();
	
	return !isError;
}

function removeRow(rowID)
{
	//uploadTable.fnDeleteRow($(rowID).get(0));
	$(rowID).remove();
	checkAll();
}

$(document).ready(function(e) {
	$('.datepicker').datepicker();

	checkAll();
	
	$('#confirm-guests-form').submit(function(e) {
		checkAll();
        if(isError)
			bootbox.alert("There are still <strong>"+errorCount+"</strong> issues on your spreadsheet.  Please correct them all before continuing.");
		return !isError;
    });
	$(document).on('change','#upload-table :input',function(e) {
        checkAll();
    });
	
	<?php if(!is_array($guests) || sizeof($guests) < 1): ?>
	addRow();
	<?php endif;?>
});
</script>