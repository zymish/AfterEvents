<?php require_once('event-nav.php'); ?>
<br>
<form accept-charset="UTF-8" id="edit-event" method="post" action="" class="form-horizontal" enctype="multipart/form-data">
<input type="hidden" name="uid" value="<?= $event['uid'] ?>">
    <div class="row-fluid">
        <div class="span7">
<!-- START LEFT COLUMN -->   

<div class='widget-box'>
    <div class='widget-title'>
        <h5>Event Information</h5>
        <div class="buttons">
        	<button class="btn btn-success" onClick="$('#edit-event').submit()"><i class="icon-save"></i> Save Event</button>
        </div>
    </div>
    <div class="widget-content">
        <div class="control-group">
            <label class="control-label">Event Title:</label>
            <div class="controls">
                <input type='text' name="title" placeholder="Event Title" value="<?= $event['title'] ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Date / Time:</label>
            <div class="controls">
                <div class="input-append" id="startDateTime">
                    <input type="text" name="start" placeholder="MM/dd/yyyy HH:mm">
                    <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                </div>
            </div>
        </div>
		<div class='control-group'>
			<label class='control-label'>Will Call Location:</label>
			<div class='controls'>
				<textarea name='extraData[willCallLoc]' placeholder='Will Call Location'><?=$event['extraData']['willCallLoc']?></textarea>
			</div>
		</div>
		<div class='control-group'>
			<label class='control-label'>Hospitality Location:</label>
			<div class='controls'>
				<textarea name='extraData[hospLoc]' placeholder='Hospitality Location'><?=$event['extraData']['hospLoc']?></textarea>
			</div>
		</div>
		<div class='control-group'>
			<label class='control-label'>Doors Open:</label>
			<div class='controls'>
				<input type='text' name='extraData[doorsOpen]' placeholder='Doors Open' value='<?=$event['extraData']['doorsOpen']?>'>
			</div>
		</div>
		<div class='control-group'>
			<label class='control-label'>Will Call Open:</label>
			<div class='controls'>
				<input type='text' name='extraData[willCallOpen]' placeholder='Will Call Open' value='<?=$event['extraData']['willCallOpen']?>'>
			</div>
		</div>
		<div class='control-group'>
			<label class='control-label'>Will Call Close:</label>
			<div class='controls'>
				<input type='text' name='extraData[willCallClose]' placeholder='Will Call Close' value='<?=$event['extraData']['willCallClose']?>'>
			</div>
		</div>
		<div class='control-group'>
			<label class='control-label'>Hospitality Open:</label>
			<div class='controls'>
				<input type='text' name='extraData[hospOpen]' placeholder='Hospitality Open' value='<?=$event['extraData']['hospOpen']?>'>
			</div>
		</div>
        <div class='control-group'>
			<label class='control-label'>Hospitality Close:</label>
			<div class='controls'>
				<input type='text' name='extraData[hospClose]' placeholder='Hospitality Close' value='<?=$event['extraData']['hospClose']?>'>
			</div>
		</div>
		<div class='control-group'>
			<label class='control-label'>Administrative Notes:</label>
			<div class='controls'>
				<textarea name='extraData[adminNotes]' placeholder='Administrative Notes'><?=$event['extraData']['adminNotes']?></textarea>
			</div>
		</div>
    </div>
</div>

<div class='widget-box'>
    <div class='widget-title'>
        <h5>Venue Information</h5>
        <div class="buttons">
        	<button class="btn btn-success" onClick="$('#edit-event').submit()"><i class="icon-save"></i> Save Event</button>
        </div>
    </div>
    <div class="widget-content">
        <div class="control-group">
            <label class="control-label">Venue Name:</label>
            <div class="controls">
                <input id="venueSearch" type='text' name="venue[name]" placeholder="Venue Name" autocomplete="off" value="<?= ($venue)?$venue['name']:"" ?>">
                <input type='hidden' name="venue[uid]" value="<?= ($venue)?$venue['uid']:"" ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Address:</label>
            <div class="controls">
                <input type="text" id="venueAddress" name="venue[address]" placeholder="Address" value="<?= ($venue)?$venue['address']:"" ?>"><br>
                <input type="text" id="venueAddress2" name="venue[address2]" placeholder="Address Continued" value="<?= ($venue)?$venue['address2']:"" ?>"><br>
                <input type="text" id="venueCity" name="venue[city]" placeholder="City" value="<?= ($venue)?$venue['city']:"" ?>"><br>
                <input type="text" id="venueState" name="venue[state]" placeholder="State / Providence" value="<?= ($venue)?$venue['state']:"" ?>"><br>
                <input type="text" id="venueZipcode" name="venue[zipcode]" placeholder="Postal Code" value="<?= ($venue)?$venue['zipcode']:"" ?>"><br>
                <input type="text" id="venueCountry" name="venue[country]" placeholder="Country" value="<?= ($venue)?$venue['country']:"" ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Parking Information:</label>
            <div class="controls">
                <textarea name="extraData[parking]" placeholder="Parking Information"><?= (isset($event['extraData']['parking']))?$event['extraData']['parking']:"" ?></textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Office Phone:</label>
            <div class="controls">
                <input type="text" name="venue[phone]" placeholder="Office Phone" value="<?= ($venue)?$venue['phone']:"" ?>">
            </div>
        </div>
    </div>
</div>
            
<!-- START RIGHT COLUMN -->
        </div>
        <div class="span5">
            <div class='widget-box'>
                <div class='widget-title'>
                    <h5>Venue Maps and Images</h5>
                    <div class="buttons">
                        <button class="btn btn-success" onClick="$('#edit-event').submit()"><i class="icon-save"></i> Save Event</button>
                    </div>
                </div>
                <div class="widget-content">
                    
                    <div class="control-group">
                        <label class="control-label">Map Preview:<br>
                        	<a href="#" class="btn btn-info" onClick="refreshMap()"><i class="icon-refresh"></i></a></label>
                        <div class="controls">
                            <div id="map-preview"></div>
                            <div class="help-block">Map is auto-generated from address.</div>
                        </div>
                    </div>
					
					<hr>
                    <?php if($venue && !empty($venue['venueMap'])): ?>
                    <div class="control-group">
                        <label class="control-label">Current Map:</label>
                        <div class="controls">
                            <img src="<?= UPLOAD_URL . "venues/" . $venue['venueMap'] ?>" class="row-fluid" />
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="control-group">
                        <div class="controls">
                            <input type="file" name="venueMap">
                        </div>
                    </div>
					<hr>
                    <?php if($venue && !empty($venue['seatingChart'])): ?>
                    <div class="control-group">
                        <label class="control-label">Current Seating Chart:</label>
                        <div class="controls">
                            <img src="<?= UPLOAD_URL . "venues/" . $venue['seatingChart'] ?>" class="row-fluid" />
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="control-group">
                        <div class="controls">
                            <input type="file" name="seatingChart">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
function refreshMap()
{
	$('#map-preview').html('<iframe class="row-fluid" style="min-height:300px;" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q='+($('#venueAddress').val()).replace(" ","+")+',+'+($('#venueCity').val()).replace(" ","+")+',+'+($('#venueState').val()).replace(" ","+")+'+'+($('#venueZipcode').val()).replace(" ","+")+'&amp;ie=UTF8&amp;output=embed"></iframe>');
}
$(document).ready(function () {
    $(".staff").tokenInput('<?= SITE_ROOT ?>actions/getStaff.php',{
		theme:'bootstrap',
		preventDuplicates:true,
		animateDropdown:false,
		resultsLimit:15,
		minChars:2
	});
	refreshMap();
	$('#startDateTime').datetimepicker({
		format: 'MM/dd/yyyy HH:mm PP',
		language: 'en',
		pick12HourFormat: true
    });
	
	var picker = $('#startDateTime').data('datetimepicker');
	picker.setLocalDate(new Date(<?= date('Y',strtotime($event['start'])) ?>,<?= date('m',strtotime($event['start']))-1 ?>,<?= date('d,H,i',strtotime($event['start'])) ?>)); 
	
});
</script>