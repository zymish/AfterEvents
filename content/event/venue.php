<?php require_once('event-nav.php'); ?>
<?php if(!$venue): ?>
	<div class="alert"><i class="icon-globe"></i> There is currently no venue information for this event.</div>
<?php 
	return;
endif; ?>
<div class="row-fluid">
	<div class="span6">
        <div class='row-fluid'>
            <div class='span12'>
                <div class='widget-box'>
                    <div class='widget-title'>
                        <h5>Venue Map</h5>
                        <div class="buttons">
                            <div class="btn-group">
                                <button class="btn btn-link"><i class='icon-edit'></i></button>
                            </div>
                		</div>
                    </div>
                    <div class='widget-content nopadding'>
                       <iframe class="row-fluid" style="min-height:400px;" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?= str_replace(" ","+",$venue['address']) ?>,+<?= str_replace(" ","+",$venue['city']) ?>,+<?= str_replace(" ","+",$venue['state']) ?>+<?= str_replace(" ","+",$venue['zipcode']) ?>&amp;ie=UTF8&amp;output=embed"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="roow-fluid">
            <div class='span12'>
                <div class='widget-box'>
                    <div class='widget-title'>
                        <h5>Parking Information</h5>
                    </div>
                    <div class='widget-content'>
                    	<?= (isset($event['extraData']['hospLoc']))?'<strong>Hospitality Location:</strong> '.$event['extraData']['hospLoc']:"" ?><br>
						<?= (isset($event['extraData']['willCallLoc']))?'<strong>Will Call Location:</strong> '.$event['extraData']['willCallLoc']:''?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
	<div class="span6">
	    <div class="row-fluid">
            <div class='span12'>
                <div class='widget-box'>
                    <div class='widget-title'>
                        <h5>Location Information</h5>
                    </div>
                    <div class='widget-content'>
                        <div class='row-fluid'>
                            <strong><?= $venue['name'] ?></strong>
                            <address>
                                <?= $venue['address'] ?><br>
                                <?= (!empty($venue['address2']))?$venue['address2']."<br>":"" ?>
                                <?= (!empty($venue['city']))?$venue['city'].",":"" ?> <?= $venue['state'] ?> <?= $venue['zipcode'] ?><br>
                                <?= (!empty($venue['country']))?$venue['country']."<br>":"" ?>
                                <?= $venue['phone'] ?>
                            </address>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	    <div class="row-fluid">
            <div class='span12'>
                <div class='widget-box'>
                    <div class='widget-title'>
                        <h5>Maps</h5>
                    </div>
                    <div class='widget-content clearfix'>
                        <?php if(!empty($venue['venueMap'])): ?>
                            <span class="row-fluid span6">Venue Map</span>
                        <?php endif; ?>
                        <?php if(!empty($venue['seatingChart'])): ?>    
                            <span class="row-fluid span6">Seating Map</span>
                        <?php endif; ?>
                        <br />
                        <?php if(!empty($venue['venueMap'])): ?>
                            <a onclick="showMap('venueMap')"><img class="row-fluid span6" src='<?= UPLOAD_URL."venues/".$venue['venueMap'] ?>'></a>
                        <?php endif; ?>
                        <?php if(!empty($venue['seatingChart'])): ?>
                            <a onclick="showMap('seatingChart')"><img class="row-fluid span5" src='<?= UPLOAD_URL."venues/".$venue['seatingChart'] ?>'></a>
                        <?php endif; ?>
                        <small class="span12 text-right padded"><em>Click the thumbnails to enlarge the maps.</em></small>
                    </div>
                </div>
            </div>
        </div>
        <div class="roow-fluid">
            <div class='span12'>
                <div class='widget-box'>
                    <div class='widget-title'>
                        <h5>Notes</h5>
                    </div>
                    <div class='widget-content'>
                    	Misc notes.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(!empty($venue['venueMap'])): ?>
<div class='modal hide' id='venueMap'>
    <img class="span11" src='<?= UPLOAD_URL."venues/".$venue['venueMap'] ?>'>
</div>
<?php endif; ?>
<?php if(!empty($venue['seatingChart'])): ?>
<div class='modal hide' id='seatingChart'>
    <img class="span11" src='<?= UPLOAD_URL."venues/".$venue['seatingChart'] ?>'>
</div>
<?php endif; ?>
<script type="text/javascript">
function showMap(map)
{
	$('#'+map).modal();
}
</script>