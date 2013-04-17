<div id="login_box">
    <form accept-charset="UTF-8" id="loginform" class="form-vertical" action="<?= SITE_ROOT ?>login" method="post">
        <input type="hidden" name="action" value="login">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-user"></i></span><input type="text" placeholder="Email" name="username">
        </div>
        <div class="input-prepend">
            <span class="add-on"><i class="icon-lock"></i></span><input type="password" placeholder="Password" name="password">
        </div>
        <input type="submit" class="btn btn-inverse" value="Login">
        <a href="#" onclick="showRecoverForm()">Lost password?</a>
    </form>
    <form accept-charset="UTF-8" id="recoverform" action="<?= SITE_ROOT ?>login" class="form-vertical" method="post" style="display:none;">
    	<input type="hidden" name="action" value="recoverPassword">
        <span class="add-on"><i class="icon-envelope"></i></span><input type="text" placeholder="E-mail address" name='email'>
        <input type="submit" class="btn btn-inverse" value="Recover">
        <a href="#" onclick="showLoginForm()">Back to login</a>
    </form>
</div>
<script type='text/javascript'>
function showRecoverForm()
{
	$('#loginform').fadeOut('fast',function(){
		$('#recoverform').fadeIn('fast');
	});
}
function showLoginForm()
{
	$('#recoverform').fadeOut('fast',function(){
		$('#loginform').fadeIn('fast');	
	});
}
</script>