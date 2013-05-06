<div class='row-fluid'>
    <div class="span12">
        <h4>Request Hospitality Form</h4>
        <div class='form-horizontal'>
            <form accept-charset="UTF-8" action="<?=SITE_ROOT?>event.hospitality/<?=$projectID?>/<?=$eventID?>#place_request" method="post">
			    <div class='control-group'>
    				<label class='control-label' for='quantity'>How many:</label>
    				<div class='controls'>
    				    <div class="alert" id="num-alert">
                        	<input type='number' min="0" value="0" class='input-mini' name="quantity" onChange="updateTotal()">
                        </div>
    				</div>
    			</div>
    			<div class='control-group'>
    				<label class='control-label' for='type'>Type:</label>
    				<div class='controls'>
                    	<div class="alert" id="type-alert">
                            <select id="hospitality_type" name="type" class="input-large" onChange="handle_hospitality()">
                                <option value='0'>Select category</option>
                                <?php if(is_array($addons))foreach($addons as $addon):?>
                                <option value='<?=$addon['uid']?>'><?=$addon['name']?></option>
                                <?php endforeach; ?>
                            </select>
                            <span id="hospitality_label"></span>
                        </div>
    				</div>
    			</div>
                <div class='control-group'>
    				<label class='control-label' for='request'>Special requests:</label>
    				<div class='controls'>
    					<textarea rows="4" class='input-xxlarge' name="request"></textarea>
    				</div>
    			</div>
    			<hr />
                <div class='control-group'>
    				<label class='control-label' for='business_unit'>Business unit:</label>
    				<div class='controls'>
    					<input type='text' name='business_unit' class='input-xlarge'>
    				</div>
    			</div>
                <div class='control-group'>
    				<label class='control-label' for='person_requesting'>Person requesting:</label>
    				<div class='controls'>
    					<input type='text' name='person_requesting' class='input-xlarge'>
    				</div>
    			</div>
                <div class='control-group'>
    				<label class='control-label' for='invoice_to'>Invoice to:</label>
    				<div class='controls'>
    					<input type='text' name='invoice_to' class='input-xlarge'>
    				</div>
    			</div>
                <div class='control-group'>
    				<label class='control-label' for='billing_address'>Billing address:</label>
    				<div class='controls'>
    					<input type='text' name='billing_address' class='input-xlarge'>
    				</div>
    			</div>
                <div class='control-group'>
    				<label class='control-label' for='city'>City:</label>
    				<div class='controls'>
    					<input type='text' name='city' class='input-xlarge'>
    				</div>
    			</div>
    			<div class='control-group'>
    				<label class='control-label' for='state'>State/Province:</label>
    				<div class='controls'>
    				    <input type='text' name='state' class='input-xlarge'>
    				</div>
    			</div>
    			<div class='control-group'>
    				<label class='control-label' for='postal'>Postal code:</label>
    				<div class='controls'>
    					<input type='text' name='postal' class='input-mini'>
    				</div>
    			</div>
                <div class='control-group'>
    				<label class='control-label' for='first-name'>Country:</label>
    				<div class='controls'>
    					<input type='text' name='country' class='input-xlarge'>
    				</div>
    			</div>
    			<hr />
    			<div class='control-group'>
    			    <label class='control-label' for='first-name'>Estimated cost:</label>
    			    <div class='controls'>
                        <table class='table table-striped table-condensed'>
                			<thead>
                				<tr>
                					<th>Description</th>
                					<th>Price</th>
                					<th>Qty</th>
                					<th>Subtotal</th>
                				</tr>
                			</thead>
                			<tbody>
                				<tr>
                					<td><span class="order-name"></span></td>
                					<td>$<span class="order-price"></span></td>
                					<td><span class="order-number"></span></td>
                					<td><strong>$<span class="order-total"></span></strong>&nbsp;&nbsp;&nbsp;<small><em>* does not include local taxes</em></small></td>
                				</tr>
                			</tbody>
                		</table>
                    </div>
                </div>
                <hr />
                <div class='control-group'>
    				<label class='control-label' for='payment_method'>Payment method:</label>
    				<div class='controls'>
    					<label class="checkbox inline"><input type="radio" name="payment_method" value="cc"> Credit Card</label>
    					<label class="checkbox inline"><input type="radio" name="payment_method" value="po"> Purchase Order</label>
                        <small><div class="help-inline">We will contact you to collect credit card information</div></small>
    				</div>
    			</div>
    			<div class='control-group'>
    				<label class='control-label' for='po_number'>PO number:</label>
    				<div class='controls'>
    					<input type='text' name='po_number' class='input-xlarge'>
    				</div>
    			</div>
                <div class='control-group'>
    				<label class='control-label'>&nbsp;</label>
    				<div class='controls'>
    					<button type="submit" class='btn btn-inverse'>Request</button>
    				</div>
    			</div>
    			
			</form>
		</div>
    </div>
</div>
<script>
var addons = {"0":{"uid":"0","name":"None","price":"0.00"}
<?php if(is_array($addons))foreach($addons as $addon):?>
,"<?=$addon['uid']?>":{"uid":'<?=$addon['uid']?>',"name":'<?=$addon['name']?>',"price":'<?=$addon['price']?>'}
<?php endforeach;?>};
var invitedGuests = <?=intval($guests->num_rows)?>;

function handle_hospitality() {
    display_hospitality_notice();
    updateTotal();
}

function display_hospitality_notice() {
	var addonID = $("#hospitality_type").val();
	if(addonID > 0)
	{
		var price = addons[addonID].price;
		if(price != '0.00')
			$('#hospitality_label').html('$'+price+' per person');
		else
			$('#hospitality_label').html('Price TBD.');
	}
	else
		$('#hospitality_label').html('');
}

function updateTotal()
{
	var index = parseInt($('[name=type]').val()) || 0,
		num = parseInt($('[name=quantity]').val()) || 0;
	
	console.log(index + ':' + num);
	$('.order-name').html(addons[index].name);
	$('.order-price').html(addons[index].price);
	$('.order-number').html(num);
	$('.order-total').html((num * addons[index].price).toFixed(2));
}

$(document).ready(function(e) {	
	updateTotal();
});
</script>