<?php require_once('event-nav.php'); ?>
<?php if(!checkPermission(array($projectID,'events',$eventID,'guests','view'))) continue;?>
<style>
.spaceMe li{padding:5px;}
</style>
<h4>What would you like to do?</h4>
<ul class="unstyled inline spaceMe">
	<li>
		<button class="btn btn-large" title="Upload Spreadsheet" onclick='uploadSpreadsheet()'>
			<i class="icon-upload icon-3x"></i><br><br>Upload Spreadsheet<br>&nbsp;
		</button>
    </li>
    <li>
		<a href="<?= SITE_ROOT . "event.guests-upload/".$projectID."/".$eventID ?>" class="btn btn-large" title="Invite New Guests">
			<i class="icon-group icon-3x"></i><br><br>Invite New Guests<br>&nbsp;
		</a>
	</li>
    <?php if(checkPermission(array($projectID,'events',$eventID,'guests','invite-noEmail'))): ?>
	<li>
		<a href='<?=SITE_ROOT?>event.guests-upload/<?=$projectID?>/<?=$eventID?>?email=noEmail' class='btn btn-large' title='Invite Guests (No Email)'>
			<i class='icon-group icon-3x'></i><br><br>Invite New Guests<br>(No Email)
		</a>
	</li>
	<?php endif; ?>
	<li>
		<a href="<?=SITE_ROOT?>event.guests-assignTickets/<?=$projectID?>/<?=$eventID?>" class="btn btn-large" title="Manage Guest List" onclick='$("#guests-invited-btn").click()'>
			<i class="icon-group icon-3x"></i><br><br>Manage My Guest List<br>&nbsp;
		</a>
    </li>
    <li>
		<a href="<?=SITE_ROOT?>event.hospitality/<?=$projectID?>/<?=$eventID?>/order" class="btn btn-large" title="Order Hospitality for Guests">
			<i class="icon-credit-card icon-3x"></i><br><br>Order Hospitality<br>&nbsp;
		</a>
	</li>
    
	<li>
		<a href='<?=SITE_ROOT?>event.messages/<?=$projectID?>/<?=$eventID?>?nav=sendEmail' class='btn btn-large' title='Send Guest Email'>
			<i class='icon-envelope icon-3x'></i><br><br>Send Guest Email<br>&nbsp;
		</a>
	</li>
	
	<?php if(checkPermission(array($projectID,'events',$eventID,'guests','all','view'))): ?>
	<li>
		<a href='<?=SITE_ROOT?>event.guests-invited/<?=$projectID?>/<?=$eventID?>' class='btn btn-large' title='All Guests'>
			<i class='icon-group icon-3x'></i><br><br>View All Guests<br>&nbsp;
		</a>
	</li>
	<li>
		<a href="<?=SITE_ROOT?>actions/printTicketList.php?eventID=<?=$eventID?>" target="_blank" class="btn btn-large" title="Print Guest List">
			<i class="icon-print icon-3x"></i><br><br>Print Ticket Allocations By<br>BU and Group
		</a>
	</li>
	<li>
		<a href="<?=SITE_ROOT?>actions/printGuestList.php?eventID=<?=$eventID?>" target="_blank" class="btn btn-large" title="Print Guest List">
			<i class="icon-print icon-3x"></i><br><br>Print Guest List By<br>Guest Last Name
		</a>
		
	</li>
    <li>
    	<a href="<?=SITE_ROOT?>actions/printGuestList.php?eventID=<?=$eventID?>&sort=BU" target="_blank" class="btn  btn-large" title="Print Guest List">
			<i class="icon-print icon-3x"></i><br><br>Print Guest List By<br>Business Unit
		</a>
    </li>
	<?php endif; ?>
</ul>
<div class='modal hide' id='download-guest-list'>
    <form accept-charset="UTF-8" action="" method="post" onSubmit="return false">
        <div class='modal-header'>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Download Guest List</h3>
        </div>
        <div class='modal-body'>
            <strong>Choose Spreadsheet Type</strong><br>
            <label><input type='radio' name='filetype' value='csv' disabled> CSV (.csv)</label>
            <label><input type='radio' name='filetype' value='xls' disabled> Excel Spreadsheet (.xls)</label>
            <label><input type='radio' name='filetype' value='pdf' disabled> Adobe Reader PDF (.pdf)</label>
            <label><input type='radio' name='filetype' value='html' disabled> Hyper Text Markup Language (.html)</label>
        </div>
        <div class='modal-footer'>
            <a href='#' class='btn' data-dismiss='modal'>Cancel</a>
            <button type='submit' class='btn btn-primary' disabled>Download</button>
        </div>
    </form>
</div>
<div class='modal hide' id='upload-spreadsheet'>
<form accept-charset="UTF-8" method="post" action="<?= SITE_ROOT . "event.guests-upload/".$projectID."/".$eventID ?>" enctype="multipart/form-data">
	<input type="hidden" name="action" value="uploadCSV">
	<div class='modal-header'>
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Upload Spreadsheet</h3>
	</div>
	<div class='modal-body'>
	    <h5>Please upload XLS files only.</h5>
        <input type='file' name="file" class="input-block-level">
        <i class='icon-question-sign' title='System is able to accept the following spreadsheet types: .csv, .xls'></i>
	</div>
	<div class='modal-footer'>
		<a href='#' class='btn' data-dismiss='modal'>Cancel</a>
		<button type='submit' class='btn btn-primary'>Upload</button>
	</div>
</form>
</div>
<script type='text/javascript'>
function downloadGuestList()
{
	$('#download-guest-list').modal();
}
function uploadSpreadsheet()
{
	$('#upload-spreadsheet').modal();
}
$(document).ready(function(e) {
	$('.datepicker').datepicker();
});
</script>