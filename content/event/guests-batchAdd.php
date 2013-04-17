<?php require_once('event-nav.php'); ?>
<br>
<?php if(is_array($messages)) foreach($messages as $message): ?>
    <div class="row-fluid">
        <div class="alert alert-<?= $message['type'] ?>" style="margin:12px auto;">
        <?php if(isset($message['icon'])):?><i class="<?= $message['icon'] ?>"></i>&nbsp;<?php endif; ?>
        <?= $message['msg'] ?></div>
    </div>
<?php endforeach; ?> 