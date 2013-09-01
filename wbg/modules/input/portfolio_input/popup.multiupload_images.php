<?php
include_once(dirname(__FILE__).'/../../../config/config.php');
include_once($_CFG['path_to_cms'].'/core/config.php');
include_once($_CFG['path_to_cms'].'/modules/libraries/portfoliomanager.class/portfoliomanager.php');
include_once($_CFG['path_to_cms'].'/modules/components/imgResizes.php');

$_CFG['portfolioManager'] = new PortfolioManager();

$HTML_TITLE = 'Resizing images';
$HTML_CONTENT = 'Data';
$OVERFLOW = 'style="overflow:hidden"';
$title = @mysql_result(mysql_query("SELECT title FROM ".(@$_CFG['categories']['sql_table']?$_CFG['categories']['sql_table']:'wbg_tree_categories')." WHERE id='".$_GET['id']."'"),0,0)
?>
<?php include_once($_CFG['path_to_skin'].'/_common/_html_header.tpl.php');?>

<link rel="stylesheet" href="http://blueimp.github.com/cdn/css/bootstrap.min.css">
<!-- Generic page styles -->
<link rel="stylesheet" href="css/multiupload/style.css">
<!-- Bootstrap styles for responsive website layout, supporting different screen sizes -->
<!--<link rel="stylesheet" href="http://blueimp.github.com/cdn/css/bootstrap-responsive.min.css">-->
<!-- Bootstrap CSS fixes for IE6 -->
<!--[if lt IE 7]><link rel="stylesheet" href="http://blueimp.github.com/cdn/css/bootstrap-ie6.min.css"><![endif]-->
<!-- Bootstrap Image Gallery styles -->
<link rel="stylesheet" href="http://blueimp.github.com/Bootstrap-Image-Gallery/css/bootstrap-image-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="css/multiupload/jquery.fileupload-ui.css">
<!-- Shim to make HTML5 elements usable in older Internet Explorer versions -->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

<body>

<div style="padding:1px 2px">
	<script>
	wbg_show_header("Current Category: <?php echo $title?>");
	</script>

<div id="content_mode_selector">&nbsp;</div>
	<div id="current_category_title" style="display:none">&nbsp;</div>
	<div id="Resizingimages" style="background:#f1f1f1; padding: 10px;">
		<div><strong>Please drag and drop images you want to add to current category</strong></div>
		<div id="multiupload">
    		<form id="fileupload" action="<?php echo $_CFG['url_to_modules'].'/libraries/multiupload/index.php?id='.$_GET['id'];?>" method="POST" enctype="multipart/form-data">
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
<!--                        <button type="button" class="btn btn-danger delete">-->
<!--                            <i class="icon-trash icon-white"></i>-->
<!--                            <span>Delete</span>-->
<!--                        </button>-->
                        <input type="checkbox" class="toggle">
                    </div>
                    <!-- The global progress information -->
                    <div class="span5 fileupload-progress fade">
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
            
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
        <td class="name"><span>{%=file.name%}</span></td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td>
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="icon-upload icon-white"></i>
                    <span>{%=locale.fileupload.start%}</span>
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn btn-warning">
                <i class="icon-ban-circle icon-white"></i>
                <span>{%=locale.fileupload.cancel%}</span>
            </button>
        {% } %}</td>
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
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else { %}
            <td class="preview">{% if (file.thumbnail_url) { %}
                <img src="{%=file.thumbnail_url%}">
            {% } %}</td>
            <td class="name">
                <a href="{%=file.url%}" target="_blank" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
            </td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td colspan="3"></td>
        {% } %}
        <!--<td class="delete">
            <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
                <i class="icon-trash icon-white"></i>
                <span>{%=locale.fileupload.destroy%}</span>
            </button>
            <input type="checkbox" name="delete" value="1">
        </td>-->
    </tr>
{% } %}
</script>
        	<h2 id="drag-drop-here">Drag and drop here</h2>
		</div>
	</div>
	<div class="grey-block mini" style="background:#e3e2e2; height:25px; padding-top:5px; border:1px solid #bfbfbf">
		<div id="content-footer" style="float:right; margin-right:15px"></div>
	</div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="js/multiupload/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="http://blueimp.github.com/JavaScript-Templates/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="http://blueimp.github.com/JavaScript-Load-Image/load-image.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="http://blueimp.github.com/JavaScript-Canvas-to-Blob/canvas-to-blob.min.js"></script>

<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="js/multiupload/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="js/multiupload/jquery.fileupload.js"></script>
<!-- The File Upload file processing plugin -->
<script src="js/multiupload/jquery.fileupload-fp.js"></script>
<!-- The File Upload user interface plugin -->
<script src="js/multiupload/jquery.fileupload-ui.js"></script>
<!-- The localization script -->
<script src="js/multiupload/locale.js"></script>
<!-- The main application script -->
<script src="js/multiupload/main.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->
<!--[if gte IE 8]><script src="js/multiupload/jquery.xdr-transport.js"></script><![endif]-->