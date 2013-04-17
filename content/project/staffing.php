<br>
<?php if(is_array($ambassadors) && sizeof($ambassadors) > 0):?>
	<h4>Brand Ambassadors</h4>
	<table class='table table-bordered table-striped table-hover table-condensed'>
		<thead>
			<tr>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Phone</th>
				<th>Email</th>
				<th>Gender</th>
				<th>Dress Size</th>
				<th>Shirt Size</th>
				<th>Pants Size</th>
				<th>Shoe Size</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($ambassadors as $user): ?>
				<tr>
					<td><input type='text' value='<?=$user['firstName']?>'></td>
					<td><input type='text' value='<?=$user['lastName']?>'></td>
					<td><input type='text' value='<?=$user['mobile']?>'></td>
					<td><a href='mailto:<?=$user['email']?>'><?=$user['email']?></a></td>
					<td>
						<select>
							<option value='0' <?php if($user['gender'] == null) echo 'selected="selected"';?>>Unknown</option>
							<option value='1' <?php if($user['gender'] == 'male') echo 'selected="selected"';?>>Male</option>
							<option value='2' <?php if($user['gender'] == 'female') echo 'selected="selected"';?>>Female</option>
						</select>
					</td>
					<td><input type='text' value='<?=$user['dressSize']?>'></td>
					<td><input type='text' value='<?=$user['shirtSize']?>'></td>
					<td><input type='text' value='<?=$user['pantsSize']?>'></td>
					<td><input type='text' value='<?=$user['shoeSize']?>'></td>
					<td>
						<button class='btn btn-inverse btn-small'>Edit</button>
					</td>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
<?php else:?>
	<div class='alert alert-info'>There are no brand ambassadors currently in the system.</div>
<?php endif;?>