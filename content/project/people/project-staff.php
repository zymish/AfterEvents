<div class='row-fluid'>
	<h4>On Project</h4>
	<table class='table table-striped project-members' id='on-project'>
		<thead>
			<tr>
				<th>Name</th>
				<th>Contact</th>
				<th>Title</th>
				<th>Department</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Frank</td>
				<td><a href='mailto:frank@goteam.com'>frank@goteam.com</a></td>
				<td>Creative Director</td>
				<td>Creative</td>
				<td>
					<div class='btn-group'>
						<button class='btn btn-info' title='Contact'><i class='icon icon-white icon-envelope'></i></button>
						<button class='btn btn-danger' title='Remove from project'><i class='icon icon-white icon-remove'></i></button>
					</div>
				</td>
			</tr>
			<tr>
				<td>Kim</td>
				<td><a href='mailto:kim@ilovehoagies.com'>kim@ilovehoagies.com</a></td>
				<td>Engineer</td>
				<td>Creative</td>
				<td>
					<div class='btn-group'>
						<button class='btn btn-info' title='Contact'><i class='icon icon-white icon-envelope'></i></button>
						<button class='btn btn-danger' title='Remove from project'><i class='icon icon-white icon-remove'></i></button>
					</div>
				</td>
			</tr>
			<tr>
				<td>Derek</td>
				<td><a href='mailto:derek@afterevent.info'>derek@afterevent.info</a></td>
				<td>Project Manager</td>
				<td>Management</td>
				<td>
					<div class='btn-group'>
						<button class='btn btn-info' title='Contact'><a href='mailto:derek@afterevent.info'><i class='icon icon-white icon-envelope'></i></a></button>
						<button class='btn btn-danger' title='Remove from project'><i class='icon icon-white icon-remove'></i></button>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	<a href='#off-project' data-toggle='collapse'>
		<h4>Off Project</h4>
	</a>
	<div class='collapse' id='off-project'>
		<table class='table table-striped project-members'>
			<thead>
				<tr>
					<th>Name</th>
					<th>Contact</th>
					<th>Title</th>
					<th>Department</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr id='off1'>
					<td id='off-name1'>Sarah</td>
					<td id='off-email1'><a href='mailto:sarah@heyguyscaniplay.com'>sarah@heyguyscaniplay.com</a></td>
					<td id='off-title1'>Human Resources Agent</td>
					<td id='off-dept1'>Human Resources</td>
					<td>
						<div class='btn-group'>
							<button class='btn btn-info' title='Contact'><a href='mailto:sarah@heyguyscaniplay.com'><i class='icon icon-white icon-envelope'></i></a></button>
							<button class='btn btn-success' title='Add to project' onclick="addStaffMember()"><i class='icon icon-white icon-plus'></i></button>
						</div>
					</td>
				</tr>
				<tr id='off2'>
					<td class='off-name'>Stan</td>
					<td class='off-email'><a href='mailto:stan@heyguyscaniplay.com'>sarah@heyguyscaniplay.com</a></td>
					<td class='off-title'>Human Resources Agent</td>
					<td class='off-dept'>Human Resources</td>
					<td>
						<div class='btn-group'>
							<button class='btn btn-info' title='Contact'><a href='mailto:stan@heyguyscaniplay.com'><i class='icon icon-white icon-envelope'></i></a></button>
							<button class='btn btn-success' title='Add to project' onclick='addStaffMember()'><i class='icon icon-white icon-plus'></i></button>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<a href='#third-party' data-toggle='collapse'>
		<h4>Third-Party</h4>
	</a>
	<div class='collapse' id='third-party'>
		<input class='span2' type='text' placeholder='Name' id='tp-name'>
		<input class='span2' type='text' placeholder='Email' id='tp-email'>
		<input class='span2' type='text' placeholder='Title' id='tp-title'>
		<input class='span2' type='text' placeholder='Username'>
		<input class='span2' type='text' placeholder='Password'>
		<button class='btn btn-success span2 pull-right' onclick='addThirdParty()'><i class='icon icon-white icon-plus'></i> Add</button>
	</div>
	<a href='#brand-ambassador' data-toggle='collapse'>
		<h4>Brand Ambassador</h4>
	</a>
	<div class='collapse' id='brand-ambassador'>
		<input class='span4' type='text' placeholder='Name' id='ba-name'>
		<input class='span3' type='text' placeholder='Email' id='ba-email'>
		<button class='btn btn-success span2 pull-right' onclick='addBrandAmbassador()'><i class='icon icon-white icon-plus'></i> Add</button>
	</div>
	<button class='btn btn-success'><a href='<?= SITE_ROOT ?>project.create-members'><i class='icon icon-white icon-plus'></i> Create Members</a></button>
</div>
<script type='text/javascript'>
function addThirdParty()
{
	var name=$('#tp-name').val();
	var email=$('#tp-email').val();
	var title=$('#tp-title').val();
	
	$('#on-project tr:last').after("<tr><td>"+name+"</td><td>"+email+"</td><td>"+title+"</td><td><div class='btn-group'><button class='btn btn-info' title='Contact'><i class='icon icon-white icon-envelope'></i></button><button class='btn btn-danger' title='Remove from project'><i class='icon icon-white icon-remove'></i></button></div></td></tr>");
	
	$('#tp-name').val('');
	$('#tp-email').val('');
	$('#tp-title').val('');
}
function addBrandAmbassador()
{
	var name = $('#ba-name').val();
	var email = $('#ba-email').val();
	
	$('#on-project tr:last').after("<tr><td>"+name+"</td><td>"+email+"</td><td>Brand Ambassador</td><td><div class='btn-group'><button class='btn btn-info' title='Contact'><i class='icon icon-white icon-envelope'></i></button><button class='btn btn-danger' title='Remove from project'><i class='icon icon-white icon-remove'></i></button></div></td></tr>");
	
	$('#ba-name').val('');
	$('#ba-email').val('');
}
</script>