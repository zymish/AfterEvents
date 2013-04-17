<div style="padding:0 10px">
<div class="row-fluid">
	<?php 
	if(is_array($ticketTypes))
	foreach($ticketTypes as $i => $type):
	if($i % 3 == 2): ?>
</div>
<div class="row-fluid">
	<?php endif; ?>
	<div class="span4">
        <div class='widget-box'>
            <div class='widget-title'>
                <span class='icon'>
                    <i class='icon-film'></i>
                </span>
                <h5><?= htmlentities($type['name']) ?></h5>
                <div class="buttons">
                    <div class="btn-group">
                        <button class="btn btn-link" onClick="editTicketTypeModal('<?= intval($type['uid']) ?>')"><i class='icon-edit'></i></button>
                    </div>
                </div>
            </div>
            <div class='widget-content'>
                <div class="row-fluid">
                    <div class="span5">
                        <div class="well well-small"><?= htmlentities($type['description']) ?></div>
                    </div>
                    <div class="span4">
                        <ul class="unstyled">
                            <li>Total Tickets: <strong><?= intval($type['total']) ?></strong></li>
                            <li>Price: <strong><?= money_format('%(#7n',$type['price']) ?></strong></li>
                        </ul>
                    </div>
                    <div class="span3">
                        <ul class="unstyled">
                            <li>Available: <strong><?=$type['total'] - $type['assigned']?></strong></li>
                            <li>Assigned: <strong><?=$type['assigned']?></strong></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>   
    </div>
    <?php endforeach; ?>
</div>
</div>