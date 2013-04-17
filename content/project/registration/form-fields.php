<div class='row'>
	<br>
	<button class='btn span2' onclick='showGenReg()'>General Registration</button><button class='btn span2' onclick='showVIPReg()'>VIP Registration</button>
</div>
<div class="row-fluid" id='gen-reg'>
	<div class="span12">
		<h4>General Registration</h4>
		<table class='table table-striped'>
			<thead>
				<tr>
					<th>Order</th>
					<th>Field Name</th>
					<th>Type</th>
					<th>Values</th>
					<th>Required</th>
					<th>Validation Rules</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><i class='icon icon-reorder move-cursor'></i></td>
					<td><input type='text'></td>
					<td>
						<select>
							<option>Type</option>
							<option>Single line of text</option>
							<option>Multiple lines of text</option>
							<option>Checkbox</option>
							<option>Drop-down select</option>
						</select>
					</td>
					<td><input type='text'></td>
					<td><input type='checkbox'></td>
					<td><button class='btn' onclick='editValidationRules()'><i class='icon icon-edit'></i> Edit</button></td>
				</tr>
				<tr>
					<td><i class='icon icon-reorder move-cursor'></i></td>
					<td><input type='text'></td>
					<td>
						<select>
							<option>Type</option>
							<option>Single line of text</option>
							<option>Multiple lines of text</option>
							<option>Checkbox</option>
							<option>Drop-down select</option>
						</select>
					</td>
					<td><input type='text'></td>
					<td><input type='checkbox'></td>
					<td><button class='btn' onclick='editValidationRules()'><i class='icon icon-edit'></i> Edit</button></td>
				</tr>
				<tr>
					<td><i class='icon icon-reorder move-cursor'></i></td>
					<td><input type='text'></td>
					<td>
						<select>
							<option>Type</option>
							<option>Single line of text</option>
							<option>Multiple lines of text</option>
							<option>Checkbox</option>
							<option>Drop-down select</option>
						</select>
					</td>
					<td><input type='text'></td>
					<td><input type='checkbox'></td>
					<td><button class='btn' onclick='editValidationRules()'><i class='icon icon-edit'></i> Edit</button></td>
				</tr>
			</tbody>
		</table>
    </div>
</div>
<div class='row-fluid' id='vip-reg'>
	<div class="span12">
		<h4>VIP Registration</h4>
		<table class='table table-striped'>
			<thead>
				<tr>
					<th>Order</th>
					<th>Field Name</th>
					<th>Type</th>
					<th>Values</th>
					<th>Required</th>
					<th>Validation Rules</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><i class='icon icon-reorder move-cursor'></i></td>
					<td><input type='text'></td>
					<td>
						<select>
							<option>Type</option>
							<option>Single line of text</option>
							<option>Multiple lines of text</option>
							<option>Checkbox</option>
							<option>Drop-down select</option>
						</select>
					</td>
					<td><input type='text'></td>
					<td><input type='checkbox'></td>
					<td><button class='btn' onclick='editValidationRules()'><i class='icon icon-edit'></i> Edit</button></td>
				</tr>
				<tr>
					<td><i class='icon icon-reorder move-cursor'></i></td>
					<td><input type='text'></td>
					<td>
						<select>
							<option>Type</option>
							<option>Single line of text</option>
							<option>Multiple lines of text</option>
							<option>Checkbox</option>
							<option>Drop-down select</option>
						</select>
					</td>
					<td><input type='text'></td>
					<td><input type='checkbox'></td>
					<td><button class='btn' onclick='editValidationRules()'><i class='icon icon-edit'></i> Edit</button></td>
				</tr>
			</tbody>
		</table>
    </div>
</div>
<div id='validation-rules' class='modal hide fade'>
	<div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    	<h3>Validation Rules</h3>
    </div>
    <div class="modal-body">
		<div class='row-fluid'>
			Value
			<select class='span4'>
				<option>equal to</option>
				<option>not</option>
				<option>greater than</option>
				<option>less than</option>
				<option>greater than or equal to</option>
				<option>less than or equal to</option>
			</select>
			<input type='text' class='span3'>
			<button class='btn span1 pull-right'><i class='icon icon-remove'></i></button>
		</div>
		<button class='btn btn-info'>Add Rule</button>
	</div>
    <div class="modal-footer"><button type="button" class="btn btn-success" onClick="$('#validation-rules').modal('hide')">OK</button></div>
</div>
<button class='btn btn-success'>Save</button>
<script type='text/javascript'>
function editValidationRules()
{
	$('#validation-rules').modal({});
}
function showGenReg()
{
	$('#vip-reg').hide();
	$('#gen-reg').show();
}
function showVIPReg()
{
	$('#gen-reg').hide();
	$('#vip-reg').show();
}
$(document).ready(function()
{
	$('#vip-reg').hide();
});
</script>