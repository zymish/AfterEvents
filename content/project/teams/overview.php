<div class='row-fluid' id='dept-overview'>
	<div class='span12'>
		<table class='table table-striped'>
			<thead>
				<tr>
					<th>Department Name</th>
					<th>Department Staff</th>
					<th>Department Head Contact</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr id='creative'>
					<td>Creative</td>
					<td>Jeff, Dave, Stanley</td>
					<td>Jeff@creative.net</td>
					<td>
						<div class='btn-group' style='display:inline;'>
							<button class='btn btn-info'><a href='<?= SITE_ROOT ?>project.departments.permissions'><i class='icon icon-check'></i></a></button>
							<button class='btn btn-warning'><i class='icon icon-edit'></i></button>
							<button class='btn btn-danger' onclick='removeDept("#creative")'><i class='icon icon-remove'></i></button>
						</div>
					</td>
				</tr>
				<tr id='legal'>
					<td>Legal</td>
					<td>Sarah, Harry</td>
					<td>sarah@legal.net</td>
					<td>
						<div class='btn-group'>
							<button class='btn btn-info'><a href='<?= SITE_ROOT ?>project.departments.permissions'><i class='icon icon-check'></i></a></button>
							<button class='btn btn-warning'><i class='icon icon-edit'></i></button>
							<button class='btn btn-danger' onclick='removeDept("#legal")'><i class='icon icon-remove'></i></button>
						</div>
					</td>
				</tr>
				<tr id='copyright'>
					<td>Copyright</td>
					<td>Harry</td>
					<td>harry@copyright.net</td>
					<td>
						<div class='btn-group'>
							<button class='btn btn-info'><a href='<?= SITE_ROOT ?>project.departments.permissions'><i class='icon icon-check'></i></a></button>
							<button class='btn btn-warning'><i class='icon icon-edit'></i></button>
							<button class='btn btn-danger' onclick='removeDept("#copyright")'><i class='icon icon-remove'></i></button>
						</div>
					</td>
				</tr>
				<tr id='management'>
					<td>Management</td>
					<td>Mike</td>
					<td>mike@management.net</td>
					<td>
						<div class='btn-group'>
							<button class='btn btn-info'><a href='<?= SITE_ROOT ?>project.departments.permissions'><i class='icon icon-check'></i></a></button>
							<button class='btn btn-warning'><i class='icon icon-edit'></i></button>
							<button class='btn btn-danger' onclick='removeDept("#management")'><i class='icon icon-remove'></i></button>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div id='dept-edit' class='modal hide fade'>
	<div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    	<h3>Edit Department</h3>
    </div>
    <div class="modal-body">
		<input type='text' placeholder='Department name'>
		<input type='text' placeholder='Department staff'>
	</div>
    <div class="modal-footer"><button type="button" class="btn btn-success" onClick="$('#dept-edit').modal('hide')">OK</button></div>
</div>
<script type='text/javascript'>
function removeDept(dept)
{
 $(dept).html('<td colspan="3">This department has been removed.</td>');
}
$('.btn-warning').click(function()
{
	$('#dept-edit').modal();
});
</script>