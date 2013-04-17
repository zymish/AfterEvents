<div class='row-fluid'>
	<div class='span12' id='note-actions'>
		<button class='btn'><i class='icon icon-trash'></i></button>
		<button class='btn'><i class='icon icon-edit'></i></button>
	</div>
	<hr>
</div>
<div class='row-fluid' id='my-notes'>
	<table class='span12 table table-striped'>
		<thead>
			<tr>
				<th><input type='checkbox' class='edit'></th>
				<th>Title</th>
				<th>Last Modified</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><input type='checkbox' class='edit'></td>
				<td>Developer Meeting Notes</td>
				<td>Jan 12</td>
			</tr>
			<tr>
				<td><input type='checkbox' class='edit'></td>
				<td>Materials Needed</td>
				<td>12:34</td>
			</tr>
			<tr>
				<td><input type='checkbox' class='edit'></td>
				<td>Don't forget these things</td>
				<td>12/31/12</td>
			</tr>
		</tbody>
	</table>
</div>
<script type='text/javascript'>
$(document).ready(function()
{
	$('#note-actions').hide();
	$('.edit').click(function()
	{
		if($('.edit').is(':checked'))
		{
			$('#note-actions').show();
		}
		else
		{
			$('#note-actions').hide();
		}
	});
});
</script>