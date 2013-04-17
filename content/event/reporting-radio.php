<table class="table report-table">
	<legend>Radio:</legend>
	<thead>
    	<tr>
        	<th nowrap>&nbsp;</th>
            <th nowrap>New Value</th>
            <th nowrap>Server Value</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        	<td>Station Name:</td>
            <td><input type="text" value="<?=(isset($report['stationName']))?$report['stationName']:$generated['stationName'] ?>" class="input-block-level" name='stationName'></td>
            <td><div class="help-inline"><?=$generated['stationName']?></div></td>
        </tr>
        <tr>
        	<td>Giveaway:</td>
            <td><input type="text" value="<?=(isset($report['giveaway']))?$report['giveaway']:$generated['giveaway'] ?>" class="input-block-level" name='giveaway'></td>
            <td><div class="help-inline"><?=$generated['giveaway']?></div></td>
        </tr>
        <tr>
        	<td>Upload Audio:</td>
			<td colspan="2">
            	<ul class="unstyled radio-audio-files">
                    <?php if(!is_array($report['radioAudio'])) $report['radioAudio'] = array('');
                        foreach($report['radioAudio'] as $i => $url): ?>
                    <li>
                    	<div>
                        <input type="file" class="input-block-level" name='radioAudio[<?=$i?>]'> &nbsp;
                        <div class="help-inline"><?=(!empty($url))?"<a href='".UPLOAD_URL.$projectID."/".$eventID."/".$url."' target='_blank'>Download Current File</a>":""?></div> &nbsp;
                        <button type="button" class="btn btn-small btn-danger" onclick='removeComment(this)'><i class="icon-remove"></i></button>
                        </div>
                    </li>
                	 <?php endforeach; ?>
                </ul>
                <button type='button' class="btn btn-info btn-mini" onclick="addNewFileRow('.radio-audio-files','radioAudio[]')">Add More...</button>
                </td>
                
        </tr>
        <tr>
        	<td>Upload Images::</td>
            <td colspan="2">
                <ul class="inline unstyled">
                    <?php if(!is_array($report['radioImg'])) $report['radioImg'] = array('','','');
                        for($i=3;$i>sizeof($report['radioImg']);$i)$report['radioImg'][] = '';
                            
                        foreach($report['radioImg'] as $i => $url): ?>
                    <li><div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                            <img src="<?=(!empty($url))?UPLOAD_URL.$projectID."/".$eventID."/".$url:"http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image"?>">
                        </div>
                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                        <div>
                            <span class="btn btn-info btn-file">
                            <span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                            <input type="file" class="unstyled" name='radioImg[<?=$i?>]'></span>
                            <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
                        </div>
                    </div></li>
                    <?php endforeach; ?>
                </ul>
            </td>
        </tr>
        <tr>
        	<td>Notes:</td>
            <td colspan="2"><input type="text" value="<?=(isset($report['radioNotes']))?$report['radioNotes']:$generated['radioNotes'] ?>" class="input-xxlarge" name='radioNotes'></td>
        </tr>
	</tbody>
</table>
<button type='submit' class="btn btn-success btn-block"><i class="icon-save"></i> Save</button>