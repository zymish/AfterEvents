<?php require_once('event-nav.php'); ?>
<div class='widget-box'>
	<div class='widget-title'>
		<h5>Start Here</h5>
	</div>
	<div class='widget-content'>
		<div class='row-fluid'>
			<button class='btn span4' title='Upload Spreadsheet' onclick='uploadSpreadsheet()'>Upload Guest Spreadsheet</button>
			<a href="<?= SITE_ROOT . "event.guests-assignTickets/".$projectID."/".$eventID ?>" class='btn span4' title='Assign Tickets to Guests'>Assign Tickets</a>
			<a href="<?=SITE_ROOT?>event.hospitality/<?=$projectID?>/<?=$eventID?>/order" class="btn span4" title="Order Hospitality Guests">Order Hospitality</a>
		</div>
	</div>
</div>
<div class='row-fluid'>
	<div class='span6'>
	    <div class='widget-box'>
			<div class='widget-title'>
				<h5>Latest Messages</h5>
			</div>
			<div class='widget-content nopadding updates'>
				<div class='new-update clearfix'>
					<div class='update-done'>
						<h4>Loading Updates <i class='icon icon-spinner icon-spin'></i></h4>
					</div>
				</div>
            </div>
		</div>
		<div class='widget-box'>
			<div class='widget-title'>
				<h5>Key Contacts</h5>
			</div>
			<div class='widget-content nopadding'>
				<table class='table table-striped table-bordered table-condensed table-hover'>
					<thead>
						<tr>
							<th>Group</th>
							<th>Name</th>
							<th>Email</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Ticketing</td>
							<td>Reba Alexander</td>
							<td><a href='mailto:reba@ncompassonline.com'>reba@ncompassonline.com</a></td>
						</tr>
						<tr>
							<td>Hospitality</td>
							<td>Grace Stevens</td>
							<td><a href='mailto:grace.stevens@ncompassonline.com'>grace.stevens@ncompassonline.com</a></td>
						</tr>
						<tr>
							<td>Security</td>
							<td>Leroy Michaux</td>
							<td><a href='mailto:leroy.michaux@ncompassonline.com'>leroy.michaux@ncompassonline.com</a></td>
						</tr>
						<tr>
							<td>Management</td>
							<td>Molly Williams</td>
							<td><a href='mailto:molly.williams@ncompassonline.com'>molly.williams@ncompassonline.com</a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class='span6'>
		<div class='widget-box'>
            <div class='widget-title'>
                <h5>Event Information</h5>
            </div>
            <div class='widget-content'>
				<div class='row-fluid'>
					<div class='span6'>
						<ul class='unstyled'>
							<li>
							<?php 
								$date1 = new DateTime(date('Y-m-d H:i:s'));
								$date2 = new DateTime($event['start']);
								$interval = $date1->diff($date2);
								echo ($interval->y > 0?$interval->y . ' years':'').($interval->m > 0 && $interval->y > 0?', ':'').($interval->m > 0?$interval->m.' months':'').($interval->d > 0 && $interval->m > 0?', ':'').($interval->d > 0?$interval->d.' days':''); ?>
							<?=($date2 > $date1?'until':'since')?> event</li>
							<li><h4>Address:</h4></li>
							<li><?=$venue['address']?><?=$venue['address2']?></li>
							<li><?=$venue['city']?><?=(!empty($venue['state'])?', '.$venue['state']:'')?></li>
							<li><?=$venue['zipcode']?></li>
							<li><?=$venue['phone']?></li>
							<li>&nbsp;</li>
							<li><strong>Will Call Location:</strong> <?=$event['extraData']['willCallLoc']?></li>
							<li><strong>Hospitality Location:</strong> <?=$event['extraData']['hospLoc']?></li>
							<li>&nbsp;</li>
							<li><h4>Schedule:</h4></li>
							<li><strong>Doors Open:</strong> <?=$event['extraData']['doorsOpen']?></li>
							<li>&nbsp;</li>
							<li><strong>Will Call Open:</strong> <?=$event['extraData']['willCallOpen']?></li>
							<li><strong>Will Call Close:</strong> <?=$event['extraData']['willCallClose']?></li>
							<li>&nbsp;</li>
							<li><strong>Hospitality Open:</strong> <?=$event['extraData']['hospOpen']?></li>
                            <li><strong>Hospitality Close:</strong> <?=$event['extraData']['hospClose']?></li>
							<li>&nbsp;</li>
							<li><?=$event['description']?></li>
						</ul>
					</div>
					<div class='span6'>
						<div id="map-preview"></div><br>
					</div>
				</div>
            </div>
        </div>
	</div>
</div>
<div class='row-fluid'>
	<div class='span6'>
	</div>
	<div class='span6'>
        <div class='widget-box'>
            <div class='widget-title'>
                <h5>Weather Information</h5>
            </div>
			<div class='widget-content weatherDisplay'>
				<?php if(isset($venue['state']) && isset($venue['city'])):
					require_once('content/event/getWeather.php');
						$weatherState = json_decode($weather, true);
						if(is_array($weatherState['history']['observations'])):
						foreach($weatherState['history']['observations'] as $observation):
							if($observation['date']['hour'] != '20')
							continue;?>
						Condition: <strong><?=$observation['conds'];?></strong><br>
						Temperature: <strong><?=$observation['tempi'];?>&deg;F</strong> (<?=$observation['tempm']?>&deg;C)<br>
						<?php endforeach;
						else:?>
						Currently: <strong><?=$weatherState['current_observation']['weather'];?></strong><br>
						Temperature: <strong><?=$weatherState['current_observation']['temp_f']?>&deg;F</strong> (<?=$weatherState['current_observation']['temp_c']?>&deg;C)<br>
						<?php endif;
					else:?>
					Venue information required for weather display.
					<?php endif;?>
            </div>
        </div>
	</div>
</div>
<div class='modal hide' id='upload-spreadsheet'>
<form accept-charset="UTF-8" method='post' action='<?= SITE_ROOT . 'event.guests-upload/'.$projectID.'/'.$eventID ?>' enctype='multipart/form-data'>
	<input type='hidden' name='action' value='uploadCSV'>
	<div class='modal-header'>
		<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
		<h3>Upload Spreadsheet</h3>
	</div>
	<div class='modal-body'>
	    <h5>Please upload XLS files only.</h5>
        <input type='file' name='file' class='input-block-level'>
        <i class='icon-question-sign' title='System is able to accept the following spreadsheet types: .csv, .xls'></i>
	</div>
	<div class='modal-footer'>
		<a href='#' class='btn' data-dismiss='modal'>Cancel</a>
		<button type='submit' class='btn btn-primary'>Upload</button>
	</div>
</form>
</div>
<script type='text/javascript'>
function refreshMap()
{
	var state = '<?=$venue['state']?>';
	var city = '<?=$venue['city']?>';
	var address = '<?=$venue['address']?>';
	var zip = '<?=$venue['zipcode']?>';
	$('#map-preview').html('<iframe class="row-fluid" style="min-height:300px;" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q='+(address).replace(" ","+")+',+'+(city).replace(" ","+")+',+'+(state).replace(" ","+")+'+'+(zip).replace(" ","+")+'&amp;ie=UTF8&amp;output=embed"></iframe>');
}
function uploadSpreadsheet()
{
	$('#upload-spreadsheet').modal();
}
$(document).ready(function(e) {
	$('select').select2();
    $('input[type=checkbox],input[type=radio],input[type=file]').uniform();
	$('.datepicker').datepicker();
	refreshMap();
});
$(document).ready(function(){
	postAction('getEventUpdates.php',{eventID:<?=$eventID?>,limit:3},function(d){
		$('.updates').html('');
		$.each(d.updates,function(index,value){
			$('.updates').append(
			"<div class='new-update clearfix'><div class='update-done'><strong>" + value.title + "</strong><span>" + value.description + "</span></div><div class='update-date'><span class='update-day'>" + value.day +"</span>" + value.month + "</div></div>"
			);
		});
		$('.updates').append(
			"<a class='btn btn-block' href='<?=SITE_ROOT . 'event.messages/'.$projectID.'/'.$eventID?>'>Read All</a>"
		);
	},function(d){
		bootbox.alert(d.msg);
	});
});
</script>