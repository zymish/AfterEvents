<div class='row-fluid'>
	<button class='btn' title='Import List' onclick='importList()'><i class='icon icon-signin'></i> <span class='hidden-phone'>Import List</span></button>
	<button class='btn' title='Export List'><i class='icon icon-signout'></i> <span class='hidden-phone'>Export List</span></button>
	<button class='btn btn-success' title='Add Guest' onclick='addGuest()'><i class='icon icon-plus'></i> <span class='hidden-phone'>Add Guest</span></button>
	<button class='btn btn-danger' title='Clear All Guests' onclick='clearGuests()'><i class='icon icon-remove'></i> <span class='hidden-phone'>Clear All Guests</span></button>
</div>
<br>
<div class="row-fluid">
	<div class="span12">
		<table class='table table-striped' id='guest-data'>
			<thead>
				<tr>
					<th>Name</th>
					<th>Email</th>
					<th>Phone</th>
					<th>Street</th>
					<th>City</th>
					<th>State</th>
					<th>Zipcode</th>
					<th title='Have they agreed to the Terms and Conditions?'>Agree</th>
					<th title='Do they want to receive more info from Toyota?'>ToyotaInfo</th>
					<th title='Do they want to be contacted by a local dealership?'>DealerContact</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Joe Cool</td>
					<td>joe@cool.com</td>
					<td>555.555.5555</td>
					<td>555 Main St.</td>
					<td>Central City</td>
					<td>Ca</td>
					<td>93454</td>
					<td>Yes</td>
					<td>Yes</td>
					<td>No</td>
				</tr>
				<tr>
					<td>Joe Cool</td>
					<td>joe@cool.com</td>
					<td>555.555.5555</td>
					<td>555 Main St.</td>
					<td>Central City</td>
					<td>Ca</td>
					<td>93454</td>
					<td>Yes</td>
					<td>Yes</td>
					<td>No</td>
				</tr>
				<tr>
					<td>Joe Cool</td>
					<td>joe@cool.com</td>
					<td>555.555.5555</td>
					<td>555 Main St.</td>
					<td>Central City</td>
					<td>Ca</td>
					<td>93454</td>
					<td>Yes</td>
					<td>Yes</td>
					<td>No</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div id='import-list' class='modal hide fade'>
	<div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    	<h3>Import List</h3>
    </div>
    <div class="modal-body">
		<input type='file'>
	</div>
    <div class="modal-footer"><button type="button" class="btn btn-success" onClick="$('#import-list').modal('hide')">OK</button></div>
</div>
<script type='text/javascript'>
function importList()
{
	$('#import-list').modal();
}
function addGuest()
{
	$('#guest-data tr:last').after("<tr><td><input type='text' placeholder='Name'></td><td><input type='text' placeholder='Email'></td><td><input type='text' placeholder='Phone'></td><td><input type='text' placeholder='Street'></td><td><input type='text' placeholder='City'></td><td><input type='text' placeholder='State'></td><td><input type='text' placeholder='Zip code'></td><td><input type='text'></td><td><input type='text'></td><td><input type='text'></td></tr>");
}
function clearGuests()
{
	$('#guest-data').html('<tr><td>Guests successfully cleared.</td></tr>');
}
</script>