<center><div id='reg-box'>
	<form accept-charset="UTF-8" id='regForm' class='form-vertical' method='post'>
		<input type="hidden" name="action" value="register">
		<div class='input-prepend'>
			<span class='add-on'><i class='icon-user'></i></span><input type='text' placeholder='First Name' name='firstName' value='<?=($fill?$user['firstName']:'');?>'>
		</div>
		<div class='input-prepend'>
			<span class='add-on'><i class='icon-user'></i></span><input type='text' placeholder='Last Name' name='lastName' value='<?=($fill?$user['lastName']:'');?>'>
		</div><br><br>
		<div class='input-prepend'>
			<span class='add-on'><i class='icon-envelope'></i></span><input type='email' placeholder='Email' name='email' value='<?=($fill?$user['email']:'');?>' disabled>
		</div>
		<div class='input-prepend'>
			<span class='add-on'><i class='icon-phone'></i></span><input type='text' placeholder='Mobile Number' name='mobile' value='<?=($fill?$user['mobile']:'');?>'>
		</div><br><br>
		<div class='input-prepend'>
			<span class='add-on'><i class='icon-lock'></i></span><input type='password' placeholder='Password' name='password'>
		</div>
		<div class='input-prepend'>
			<span class='add-on'><i class='icon-lock'></i></span><input type='password' placeholder='Confirm Password' name='passConfirm'>
		</div><br><br>
		<input type='submit' class='btn btn-inverse' value='Register'>
	</form>
</div></center>