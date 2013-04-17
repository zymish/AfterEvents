	<table class="table image-row report-branding-table">
		<legend>Branding:</legend>
		<tbody>
			<tr>
				<td>External Venue Branding:</td>
				<td style='min-width:705px;'>
					Details: &nbsp;
					<input type="text" placeholder="" value="<?=$report['extBrandDetails']?>" class="input-xxlarge" name='extBrandDetails'>
					<ul class="inline unstyled">
						<?php if(!is_array($report['extBrandImg'])) $report['extBrandImg'] = array('','','');
							for($i=3;$i>sizeof($report['extBrandImg']);$i)$report['extBrandImg'][] = '';
								
							foreach($report['extBrandImg'] as $i => $url): ?>
						<li><div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
								<img src="<?=(!empty($url))?UPLOAD_URL.$projectID."/".$eventID."/".$url:"http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image"?>">
							</div>
							<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
							<div>
								<span class="btn btn-info btn-file">
								<span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
								<input type="file" class="unstyled" name='extBrandImg[<?=$i?>]'></span>
								<a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
							</div>
						</div></li>
						<?php endforeach; ?>
					</ul>
				</td>
			</tr>
			<tr>
				<td>Internal Venue Branding:</td>
				<td style='min-width:705px;'>
					Details: &nbsp;
					<input type="text" placeholder="" value="<?=$report['intBrandDetails']?>" class="input-xxlarge" name='intBrandDetails'>
					<br>
					<ul class="inline unstyled">
						<?php if(!is_array($report['intBrandImg'])) $report['intBrandImg'] = array('','','');
							for($i=3;$i>sizeof($report['intBrandImg']);$i)$report['intBrandImg'][] = '';
								
							foreach($report['intBrandImg'] as $i => $url): ?>
						<li><div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
								<img src="<?=(!empty($url))?UPLOAD_URL.$projectID."/".$eventID."/".$url:"http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image"?>">
							</div>
							<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
							<div>
								<span class="btn btn-info btn-file">
								<span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
								<input type="file" class="unstyled" name='intBrandImg[<?=$i?>]'></span>
								<a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
							</div>
						</div></li>
						<?php endforeach; ?>
					</ul>
				</td>
			</tr>
			<tr>
				<td>Concourse:</td>
				<td style='min-width:705px;'>
					Details: &nbsp;
					<input type="text" placeholder="" value="<?=$report['concourseDetails']?>" class="input-xxlarge" name='concourseDetails'>
					<br>
					<ul class="inline unstyled">
						<?php if(!is_array($report['concourseImg'])) $report['concourseImg'] = array('','','');
							for($i=3;$i>sizeof($report['concourseImg']);$i)$report['concourseImg'][] = '';
								
							foreach($report['concourseImg'] as $i => $url): ?>
						<li><div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
								<img src="<?=(!empty($url))?UPLOAD_URL.$projectID."/".$eventID."/".$url:"http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image"?>">
							</div>
							<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
							<div>
								<span class="btn btn-info btn-file">
								<span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
								<input type="file" class="unstyled" name='concourseImg[<?=$i?>]'></span>
								<a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
							</div>
						</div></li>
						<?php endforeach; ?>
					</ul>
				</td>
			</tr>
			<tr>
				<td>Jumbotron:</td>
				<td style='min-width:705px;'>
					Details: &nbsp;
					<input type="text" placeholder="" value="<?=$report['jumboDetails']?>" class="input-xxlarge" name='jumboDetails'>
					<br>
					<ul class="inline unstyled">
						<?php if(!is_array($report['jumboImg'])) $report['jumboImg'] = array('','','');
							for($i=3;$i>sizeof($report['jumboImg']);$i)$report['jumboImg'][] = '';
								
							foreach($report['jumboImg'] as $i => $url): ?>
						<li><div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
								<img src="<?=(!empty($url))?UPLOAD_URL.$projectID."/".$eventID."/".$url:"http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image"?>">
							</div>
							<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
							<div>
								<span class="btn btn-info btn-file">
								<span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
								<input type="file" class="unstyled" name='jumboImg[<?=$i?>]'></span>
								<a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
							</div>
						</div></li>
						<?php endforeach; ?>
					</ul>
				</td>
			</tr>
			<tr>
				<td>Stage Screens:</td>
				<td style='min-width:705px;'>
					Details: &nbsp;
					<input type="text" placeholder="" value="<?=$report['stageDetails']?>" class="input-xxlarge" name='stageDetails'>
					<br>
					<ul class="inline unstyled">
						<?php if(!is_array($report['stageImg'])) $report['stageImg'] = array('','','');
							for($i=3;$i>sizeof($report['stageImg']);$i)$report['stageImg'][] = '';
								
							foreach($report['stageImg'] as $i => $url): ?>
						<li><div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
								<img src="<?=(!empty($url))?UPLOAD_URL.$projectID."/".$eventID."/".$url:"http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image"?>">
							</div>
							<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
							<div>
								<span class="btn btn-info btn-file">
								<span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
								<input type="file" class="unstyled" name='stageImg[<?=$i?>]'></span>
								<a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
							</div>
						</div></li>
						<?php endforeach; ?>
					</ul>
				</td>
			</tr>
			<tr>
				<td>Additional Branding:</td>
				<td style='min-width:705px;'>
					Details: &nbsp;
					<input type="text" placeholder="" value="<?=$report['addtlBrandDetails']?>" class="input-xxlarge" name='addtlBrandDetails'>
					<br>
					<ul class="inline unstyled">
						<?php if(!is_array($report['addtlBrandImg'])) $report['addtlBrandImg'] = array('','','');
							for($i=3;$i>sizeof($report['addtlBrandImg']);$i)$report['addtlBrandImg'][] = '';
								
							foreach($report['addtlBrandImg'] as $i => $url): ?>
						<li><div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
								<img src="<?=(!empty($url))?UPLOAD_URL.$projectID."/".$eventID."/".$url:"http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image"?>">
							</div>
							<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
							<div>
								<span class="btn btn-info btn-file">
								<span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
								<input type="file" class="unstyled" name='addtlBrandImg[<?=$i?>]'></span>
								<a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
							</div>
						</div></li>
						<?php endforeach; ?>
					</ul>
				</td>
			</tr>
			<tr>
				<td>Any Competitor Branding or Activity:</td>
				<td style='min-width:705px;'>
					Details:<br>
					<input type="text" placeholder="" value="<?=$report['competeDetails']?>" class="input-xxlarge" name='competeDetails'>
					<br>
					<ul class="inline unstyled">
						<?php if(!is_array($report['competeImg'])) $report['competeImg'] = array('','','');
							for($i=3;$i>sizeof($report['competeImg']);$i)$report['competeImg'][] = '';
								
							foreach($report['competeImg'] as $i => $url): ?>
						<li><div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
								<img src="<?=(!empty($url))?UPLOAD_URL.$projectID."/".$eventID."/".$url:"http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image"?>">
							</div>
							<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
							<div>
								<span class="btn btn-info btn-file">
								<span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
								<input type="file" class="unstyled" name='competeImg[<?=$i?>]'></span>
								<a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
							</div>
						</div></li>
						<?php endforeach; ?>
					</ul>
				</td>
			</tr>
		</tbody>
	</table>
<button type='submit' class="btn btn-success btn-block"><i class="icon-save"></i> Save</button>