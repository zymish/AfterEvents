<div class='row-fluid' id='project-settings'>
	<div class='span12'>
		<table class='table table-striped'>
			<thead>
				<tr>
					<th>Page</th>
					<th>Description</th>
					<th>Enabled</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Overview</td>
					<td>This page shows general information about the project, with multiple widgets for displaying live data.</td>
					<td>
						<input type='checkbox' checked='checked' disabled='true'>
					</td>
				</tr>
				<tr>
					<td>Discussion</td>
					<td>This page contains logs for all discussions on various parts of the projet.</td>
					<td>
						<input type='checkbox' checked='checked' disabled='true'>
					</td>
				</tr>
				<tr>
					<td>Outline</td>
					<td>This page shows the outline/general workflow for various parts of the projcet.</td>
					<td>
						<input type='checkbox' checked='checked'>
					</td>
				</tr>
				<tr>
					<td>Departments Overview</td>
					<td>This page lists the departments associated with the project, as well as the personnel in those departments.</td>
					<td>
						<input type='checkbox' checked='checked'>
					</td>
				</tr>
				<tr>
					<td>Department Permissions</td>
					<td>This page allows the user to choose which departments have access to what parts of the site.</td>
					<td>
						<input type='checkbox' checked='checked'>
					</td>
				</tr>
				<tr>
					<td>Projet Staff</td>
					<td>This page displays all staff associated with the project and provides options for managing personnel.</td>
					<td>
						<input type='checkbox' checked='checked'>
					</td>
				</tr>
				<tr>
					<td>Event Staff</td>
					<td>This page displays all staff associated with the event (if any) and provides options for managing personnel.</td>
					<td>
						<input type='checkbox' checked='checked'>
					</td>
				</tr>
				<tr>
					<td>Client</td>
					<td>A preview of what the client will see when logged in to the software.</td>
					<td>
						<input type='checkbox' checked='checked'>
					</td>
				</tr>
				<tr>
					<td>Assets Pages</td>
					<td>Pages for viewing, editing, and uploading assets for the project.</td>
					<td>
						<input type='checkbox' checked='checked'>
					</td>
				</tr>
				<tr>
					<td>Registration</td>
					<td>Pages for editing registration forms and viewing guest data.</td>
					<td>
						<input type='checkbox' checked='checked'>
					</td>
				</tr>
				<tr>
					<td>Task List</td>
					<td>Displays tasks associated with the project.</td>
					<td>
						<input type='checkbox' checked='checked'>
					</td>
				</tr>
				<tr>
					<td>Sample Disabled Page</td>
					<td>This page is disabled, and will not be displayed.</td>
					<td>
						<input type='checkbox'>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<script type='text/javascript'>
$(document).ready(function()
{
	$(':checkbox').iphoneStyle();
});
</script>