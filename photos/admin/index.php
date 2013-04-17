<?php
require_once('../../includes/startup.php');

$showGallery = false;

if(isset($_REQUEST['eventCode'],$_REQUEST['password'])):
	$eventCode = $_REQUEST['eventCode'];
	$password = $_REQUEST['password'];
	if(in_array($password,array('Kr5ggM923','yNB46W2A'))):
		if($password == 'Kr5ggM923')
			$type = 'concourse';
		else
			$type = 'meetGreet';
			
		$event = $eventManager->getEventByAppID($eventCode);
		if($event):
			$showGallery = true;
			$eventID = $event['uid'];
			$projectID = $event['projectID'];
		endif;
	endif;
else:

endif;

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>BlackBerry Presents Alicia Keys - Photos</title>
    <meta charset="UTF-8" />
    <meta name="description" content="ecPanel">
    <meta name="author" content="Boundless Ether, LLC">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <link rel="icon" type="image/png" href="<?= SITE_ROOT ?>img/favicon.png">
    <link rel="stylesheet" type="text/css" media="screen" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css">
    <link rel='stylesheet' href='<?=SITE_ROOT?>css/bootstrap.min.css'>
	<link rel='stylesheet' href='<?=SITE_ROOT?>css/bootstrap-responsive.min.css'>
	<link rel='stylesheet' href='<?=SITE_ROOT?>css/jquery.fileupload-ui.css'>
    <link rel="stylesheet" href="<?=SITE_ROOT?>css/fileupload.style.css">
    <link rel="stylesheet" href="<?=SITE_ROOT?>css/style.css">
<link rel="stylesheet" href="http://blueimp.github.com/cdn/css/bootstrap-responsive.min.css">
<!--[if lt IE 7]><link rel="stylesheet" href="http://blueimp.github.com/cdn/css/bootstrap-ie6.min.css"><![endif]-->
<link rel="stylesheet" href="http://blueimp.github.com/Bootstrap-Image-Gallery/css/bootstrap-image-gallery.min.css">
<noscript><link rel="stylesheet" href="<?=SITE_ROOT?>css/jquery.fileupload-ui-noscript.css"></noscript>
    
    <link rel="stylesheet" type="text/css" media="screen" href="<?= SITE_ROOT ?>css/bbak_custom.css">
    
    <script type='text/javascript' src='<?=SITE_ROOT?>js/jquery.min.js'></script>
</head>
<body>
	<div id="logo" style="margin:50px auto 15px auto;text-align:center;">
    <img src="<?= SITE_ROOT ?>img/logo.png" alt="BlackBerry" />
</div>
<?php if(!$showGallery):?>
	<div id="login_box">
		<form id="loginform" class="form-vertical" action="" method="GET">
			<input type="hidden" name="action" value="login">
			<div class="input-prepend">
				<span class="add-on"><i class="icon-globe"></i></span><input type="text" placeholder="Event Code" name="eventCode">
			</div>
			<div class="input-prepend">
				<span class="add-on"><i class="icon-lock"></i></span><input type="password" placeholder="Password" name="password">
			</div>
			<input type="submit" class="btn btn-inverse" value="View Photos">
		</form>
	</div>
<?php else:?>
<div class="container">

    <!-- The file upload form used as target for the file upload widget -->
    <form id="fileupload" action="<?=SITE_ROOT?>actions/photoUpload.php" method="POST" enctype="multipart/form-data">
    	<input type="hidden" name="eventID" value="<?=$eventID?>">
        <input type="hidden" name="projectID" value="<?=$projectID?>">
        <input type="hidden" name="type" value="<?=$type?>">
        <!-- Redirect browsers with JavaScript disabled to the origin page -->
        <noscript><input type="hidden" name="redirect" value="<?=$_SERVER['SCRIPT_NAME']?>"></noscript>
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="span7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="icon-plus icon-white"></i>
                    <span>Add files...</span>
                    <input type="file" name="files[]" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="icon-upload icon-white"></i>
                    <span>Start upload</span>
                </button>
                <button type="reset" class="btn btn-warning cancel">
                    <i class="icon-ban-circle icon-white"></i>
                    <span>Cancel upload</span>
                </button>
                <!--<button type="button" class="btn btn-danger delete">
                    <i class="icon-trash icon-white"></i>
                    <span>Delete</span>
                </button>
				<div class='btn btn-warning'><span onclick='$("#toggle-checky").click()'>Select All&nbsp;&nbsp;</span><input id='toggle-checky' type="checkbox" class="toggle"></div>-->
            </div>
            <!-- The global progress information -->
            <div class="span4 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="bar" style="width:0%;"></div>
                </div>
                <!-- The extended global progress information -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The loading indicator is shown during file processing -->
        <div class="fileupload-loading"></div>
        <br>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
    </form>
    <br>
    
</div>
<!-- modal-gallery is the modal dialog used for the image gallery -->
<div id="modal-gallery" class="modal modal-gallery hide fade" data-filter=":odd" tabindex="-1">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3 class="modal-title"></h3>
    </div>
    <div class="modal-body"><div class="modal-image"></div></div>
    <div class="modal-footer">
        <a class="btn modal-download" target="_blank">
            <i class="icon-download"></i>
            <span>Download</span>
        </a>
        <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000">
            <i class="icon-play icon-white"></i>
            <span>Slideshow</span>
        </a>
        <a class="btn btn-info modal-prev">
            <i class="icon-arrow-left icon-white"></i>
            <span>Previous</span>
        </a>
        <a class="btn btn-primary modal-next">
            <span>Next</span>
            <i class="icon-arrow-right icon-white"></i>
        </a>
    </div>
</div>
<script>
var eventID = '<?=$eventID?>';
var projectID = '<?=$projectID?>';
var type = '<?=$type?>';
</script>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
        <td class="name"><span>{%=file.name%}</span></td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td>
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td>{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary start">
                    <i class="icon-upload icon-white"></i>
                    <span>Start</span>
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <!--<td width='150'>{% if (!i) { %}
            <button class="btn btn-warning cancel">
                <i class="icon-ban-circle icon-white"></i>
                <span>Cancel</span>
            </button>
        {% } %}</td>-->
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        {% if (file.error) { %}
            <td></td>
            <td class="name"><span>{%=file.name%}</span></td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
        {% } else { %}
            <td class="preview">{% if (file.thumbnail_url) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" data-gallery="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
            {% } %}</td>
            <td class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" data-gallery="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
            </td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td colspan="2"></td>
        {% } %}
        <!--<td width='150'>
            <button class="btn btn-danger delete" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                <i class="icon-trash icon-white"></i>
                <span>Delete</span>
            </button>
            <input type="checkbox" name="delete" value="1" class="toggle">
        </td>-->
    </tr>
{% } %}
</script><?php endif;?>

<script src='<?=SITE_ROOT?>js/bootstrap.min.js'></script>
<script src='<?=SITE_ROOT?>js/bootbox.min.js'></script>
<script src="<?=SITE_ROOT?>js/vendor/jquery.ui.widget.js"></script>
<script src="http://blueimp.github.com/JavaScript-Templates/tmpl.min.js"></script>
<script src="http://blueimp.github.com/JavaScript-Load-Image/load-image.min.js"></script>
<script src="http://blueimp.github.com/JavaScript-Canvas-to-Blob/canvas-to-blob.min.js"></script>
<script src="http://blueimp.github.com/Bootstrap-Image-Gallery/js/bootstrap-image-gallery.min.js"></script>
<script src="<?=SITE_ROOT?>js/jquery.iframe-transport.js"></script>
<script src="<?=SITE_ROOT?>js/jquery.fileupload.js"></script>
<script src="<?=SITE_ROOT?>js/jquery.fileupload-fp.js"></script>
<script src="<?=SITE_ROOT?>js/jquery.fileupload-ui.js"></script>
<script src="<?=SITE_ROOT?>js/afterevent.js"></script>
<script src="<?=SITE_ROOT?>js/photoupload.main.js"></script>

</body>
</html>