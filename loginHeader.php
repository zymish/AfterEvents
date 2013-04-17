<div id="logo" style="margin:50px auto 15px auto;text-align:center;">
    <img src="<?= SITE_ROOT ?>img/logo.png" alt="BlackBerry" />
</div>
<?php if(is_array($errors)) foreach($errors as $error): ?>
    <div class="alert alert-<?= $error['type'] ?>" style="width:600px; margin:12px auto;">
<?php if(isset($error['icon'])):?><i class="<?= $error['icon'] ?>"></i>&nbsp;<?php endif; ?>
<?= $error['msg'] ?></div>
<?php endforeach; ?> 