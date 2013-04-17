<div class='row-fluid'>
	<div class='span12 btn-group'>
		<button class='btn' title='Add Note'><i class='icon icon-plus'></i></button>
		<button class='btn disabled note-actions' title='Delete Selected'><i class='icon icon-trash'></i></button>
		<button class='btn disabled note-actions' title='Edit Selected'><i class='icon icon-edit'></i></button>
	</div>
	<hr>
</div>
<div class='row-fluid' id='my-notes'>
	<div class='span12'>
		<table class='table table-striped'>
			<thead>
				<tr>
					<th style='width:20px;'><input type='checkbox' id='check-all'></th>
					<th>Title</th>
					<th>Last Modified</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><input type='checkbox' class='edit'></td>
					<td><a href='<? SITE_ROOT ?>project.notes?note=1'>Developer Meeting Notes</a></td>
					<td>Jan 12</td>
				</tr>
				<tr>
					<td><input type='checkbox' class='edit'></td>
					<td><a href='<? SITE_ROOT ?>project.notes?note=2'>Materials Needed</a></td>
					<td>12:34</td>
				</tr>
				<tr>
					<td><input type='checkbox' class='edit'></td>
					<td><a href='<? SITE_ROOT ?>project.notes?note=2'>Don't forget these things</a></td>
					<td>12/31/12</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<script type='text/javascript'>
function editsVisible()
{
	if($('.edit').is(':checked'))
	{
		$('.note-actions').removeClass('disabled');
	}
	else
	{
		$('.note-actions').addClass('disabled');
	}
}
$('[type=checkbox]').click(function()
{
	editsVisible();
});
$('#check-all').click(function()
{
	if($('.edit').is(':checked'))
	{
		$('.edit').prop('checked',false);
	}
	else
	{
		$('.edit').prop('checked',true);
	}
	editsVisible();
});
</script>