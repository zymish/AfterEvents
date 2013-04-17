<div class='row-fluid'>
	<div class='span12'>
		<table class='table table-striped table-bordered' id='reg-form'>
			<thead>
				<tr>
					<th width='40'>No.</th>
					<th>Field Name</th>
					<th>Type</th>
					<th>Required</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><i class='icon icon-reorder'></i> 01</td>
					<td><input type='text' value='First Name'></td>
					<td>
						<select>
							<option>Text Input</option>
							<option>Drop-Down Select</option>
							<option>Multi-Line Text Input</option>
							<option>Check Box</option>
						</select>
					</td>
					<td><input type='checkbox' checked='checked'></td>
				</tr>
				<tr>
					<td><i class='icon icon-reorder'></i> 02</td>
					<td><input type='text' value='Last Name'></td>
					<td>
						<select>
							<option>Text Input</option>
							<option>Drop-Down Select</option>
							<option>Multi-Line Text Input</option>
							<option>Check Box</option>
						</select>
					</td>
					<td><input type='checkbox' checked='checked'></td>
				</tr>
				<tr>
					<td><i class='icon icon-reorder'></i> 03</td>
					<td><input type='text' value='Email'></td>
					<td>
						<select>
							<option>Text Input</option>
							<option>Drop-Down Select</option>
							<option>Multi-Line Text Input</option>
							<option>Check Box</option>
						</select>
					</td>
					<td><input type='checkbox' checked='checked'></td>
				</tr>
				<tr>
					<td><i class='icon icon-reorder'></i> 04</td>
					<td><input type='text' value='Ticket Type'></td>
					<td>
						<select>
							<option>Text Input</option>
							<option selected='selected'>Drop-Down Select</option>
							<option>Multi-Line Text Input</option>
							<option>Check Box</option>
						</select>
					</td>
					<td><input type='checkbox' checked='checked'></td>
				</tr>
				<tr>
					<td><i class='icon icon-reorder'></i> 05</td>
					<td><input type='text' value='Phone'></td>
					<td>
						<select>
							<option>Text Input</option>
							<option>Drop-Down Select</option>
							<option>Multi-Line Text Input</option>
							<option>Check Box</option>
						</select>
					</td>
					<td><input type='checkbox'></td>
				</tr>
			</tbody>
		</table>
		<button class='btn' onclick='newRow()'><i class='icon icon-plus'></i> Add Field</button>
		<button class='btn' onclick='viewForm()'><i class='icon icon-eye-open'></i> Preview Registration Form</button>
		<button class='btn' onclick='saveForm()'><i class='icon icon-save'></i> Save Changes</form>
	</div>
</div>
<script type='text/javascript'>
function newRow()
{
	$('#reg-form tbody').append("<tr><td><i class='icon icon-reorder'></i> 06</td></td><td><input type='text' placeholder='Field Name'></td><td><select><option>Text Input</option><option>Drop-Down Select</option><option>Multi-Line Text Input</option><option>Check Box</option></select></td><td><input type='checkbox'></td></tr>");
}
</script>