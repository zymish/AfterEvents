<?php require_once('event-nav.php'); ?>
<div class="row-fluid">
	<div class='span12'>
        <div class='widget-box'>
            <div class='widget-title'>
                <h5>Event Photos</h5>
                <div class="buttons">
                	<button class="btn btn-mini btn-success" title="Upload Photos"><i class='icon icon-upload-alt'></i> Upload Photos</button>
                </div>
            </div>
            <div class='widget-content'>
                <ul class="thumbnails">
                <?php
					for($i=0;$i<20;$i++):
						if($i % 6 == 0):
					?>
                </ul>
              	<ul class='thumbnails'>
                    <?php
						endif;
				?>
				  <li class="span2">
                    <a href="#" class="thumbnail">
                      <img src="http://instasrc.com/300/300/future/normal/new?e=<?= time() + ($i * 2) ?>" alt="" /> 
                    </a>
                    <div class="actions">
                        <a title="Edit" href="#"><i class="icon-edit icon-white"></i></a>
                        <a title="Remove" href="#"><i class="icon-remove icon-white"></i></a>
                    </div>
                  </li>
				<?php
					endfor;
				?>
                  </ul>
            </div>
        </div>
    </div>
</div>