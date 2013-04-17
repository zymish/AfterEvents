<form accept-charset="UTF-8" id="edit-event" method="post" action="" class="form-horizontal" enctype="multipart/form-data">
<input type="hidden" name="uid" value="<?= $event['uid'] ?>">
<div class="container">
	<div class="row">
    	<div class="span12">
        	<button class="btn btn-success pull-right" onClick="$('#edit-event').submit()"><i class="icon-save"></i> Save Event</button>
        </div>
    </div>
    <div class="row">
        <div class="span6">
<!-- START LEFT COLUMN -->   
<div class='widget-box'>
    <div class='widget-title'>
        <span class='icon'>
            <i class='icon-globe'></i>
        </span>
        <h5>Event Information</h5>
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
                <div class="input-append dateTime">
                    <input type="text" name="start" placeholder="mm/dd/yyyy hh:mm pp" value="<?= date('m/d/Y g:i A',strtotime($event['start'])) ?>">
                    <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Description:</label>
            <div class="controls">
                <textarea name="description" placeholder="Event Description"><?= $event['description'] ?></textarea>
            </div>
        </div>
    </div>
</div>
<div class='widget-box'>
    <div class='widget-title'>
        <span class='icon'>
            <i class='icon-home'></i>
        </span>
        <h5>Venue Information</h5>
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
                <input type="text" id="venueAddress" name="venue[address]" placeholder="Address" value="<?= ($venue)?$venue['address']:"" ?>">
                <input type="text" id="venueAddress2" name="venue[address2]" placeholder="Address Continued" value="<?= ($venue)?$venue['address2']:"" ?>">
                <input type="text" id="venueCity" name="venue[city]" placeholder="City" value="<?= ($venue)?$venue['city']:"" ?>">
                <input type="text" id="venueState" name="venue[state]" placeholder="State / Providence" value="<?= ($venue)?$venue['state']:"" ?>">
                <input type="text" id="venueZipcode" name="venue[zipcode]" placeholder="Postal Code" value="<?= ($venue)?$venue['zipcode']:"" ?>">
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
<div class='widget-box'>
    <div class='widget-title'>
        <span class='icon'>
            <i class='icon-film'></i>
        </span>
        <h5>Ticketing Information</h5>
        <div class="buttons">
        	<button class="btn btn-success"  disabled><i class="icon-plus"></i> Create New Ticket Type</button>
        </div>
    </div>
    <div class="widget-content nopadding">
    	<table class="table table-condensed table-striped">
        	<thead>
            	<tr>
                	<th>Ticket Type</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Allocated</th>
                </tr>
            </thead>
            <tbody>
	<?php 
        if($ticketTypes)
        while($ticketType = $ticketTypes->fetch_assoc()):
			foreach($ticketType as $field => $value)
				$ticketType[$field] = htmlentities($value);
    ?>
        	<tr>
				<td><input type="text" name="ticketTypes[<?= $ticketType['uid'] ?>][name]" value="<?= $ticketType['name'] ?>"  disabled></td>
                <td class="text-center"><div class="input-prepend">
                	<span class="add-on">$</span>
                    <input type='text' class="span1" name="ticketTypes[<?= $ticketType['uid'] ?>][price]" value="<?= $ticketType['price'] ?>"  disabled>
                </div></td>
                <td class="text-center"><input type='text' class="span1" name="ticketTypes[<?= $ticketType['uid'] ?>][total]" value="<?= $ticketType['total'] ?>" disabled></td>
                <td class="text-center">0</td>
            </tr>
	<?php
        endwhile;
    ?>
    		</tbody>
        </table>
    </div>
</div>
<div class='widget-box'>
    <div class='widget-title'>
        <span class='icon'>
            <i class='icon-film'></i>
        </span>
        <h5>Hospitality Packages</h5>
        <div class="buttons">
        	<button class="btn btn-success" disabled><i class="icon-plus"></i> Create New Hospitality Package</button>
        </div>
    </div>
    <div class="widget-content nopadding">
    	<table class="table table-condensed table-striped">
        	<thead>
            	<tr>
                	<th>Package Name</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Allocated</th>
                </tr>
            </thead>
            <tbody>
	<?php 
        if($addons)
        while($addon = $addons->fetch_assoc()):
			foreach($addon as $field => $value)
				$addon[$field] = htmlentities($value);
    ?>
        	<tr>
				<td><input type="text" name="addons[<?= $addon['uid'] ?>][name]" value="<?= $addon['name'] ?>" disabled>
                <input type="hidden" name="addons[<?= $addon['uid'] ?>][type]" value="<?= $addon['type'] ?>">
                </td>
                <td class="text-center"><div class="input-prepend">
                	<span class="add-on">$</span>
                    <input type='text' class="span1" name="addons[<?= $addon['uid'] ?>][price]" value="<?= $addon['price'] ?>" disabled>
                </div></td>
                <td class="text-center"><input type='text' class="span1" name="addon[<?= $addon['uid'] ?>][total]" value="<?= $addon['total'] ?>" disabled></td>
                <td class="text-center">0</td>
            </tr>
	<?php
        endwhile;
    ?>
    		</tbody>
        </table>
    </div>
</div>
<pre>
<?php print_r($_FILES); ?>
</pre>
<pre>
<?php print_r($_POST); ?>
</pre>
<!-- START RIGHT COLUMN -->
        </div>
        <div class="span6">
            <div class='widget-box'>
                <div class='widget-title'>
                    <span class='icon'>
                        <i class='icon-map-marker'></i>
                    </span>
                    <h5>Venue Maps and Images</h5>
                </div>
                <div class="widget-content">
                    <div class="control-group">
                        <label class="control-label">Map Preview:<br>
                        	<a href="#" class="btn btn-info" onClick="refreshMap()"><i class="icon-refresh"></i></a></label>
                        <div class="controls">
                            <div id="map-preview"></div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Venue Map:</label>
                        <div class="controls">
                            <input type="file" name="venueMap">
                        </div>
                    </div>
                    <?php if($venue && !empty($venue['venueMap'])): ?>
                    <div class="control-group">
                        <label class="control-label">Current Map:</label>
                        <div class="controls">
                            <img src="<?= UPLOAD_URL . "venues/" . $venue['venueMap'] ?>" class="row-fluid" />
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="control-group">
                        <label class="control-label">Seating Chart:</label>
                        <div class="controls">
                            <input type="file" name="seatingChart">
                        </div>
                    </div>
                    <?php if($venue && !empty($venue['seatingChart'])): ?>
                    <div class="control-group">
                        <label class="control-label">Current Seating Chart:</label>
                        <div class="controls">
                            <img src="<?= UPLOAD_URL . "venues/" . $venue['seatingChart'] ?>" class="row-fluid" />
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="span12">
        	<button class="btn btn-success pull-right" onClick="$('#edit-event').submit()"><i class="icon-save"></i> Save Event</button>
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
	$('.dateTime').datetimepicker({
		format: 'MM/dd/yyyy HH:mm PP',
		language: 'en',
		pick12HourFormat: true
    });
    $(".staff").tokenInput('<?= SITE_ROOT ?>actions/getStaff.php',{
		theme:'bootstrap',
		preventDuplicates:true,
		animateDropdown:false,
		resultsLimit:15,
		minChars:2
	});
	refreshMap();
});
</script>