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
<body>
<div style="position:absolute;bottom:-1px" id="sizer">&nbsp;</div>

<div style="padding:1px 2px">
	<script>
	wbg_show_header("Current Category: <?php echo $title?>");
	</script>

<div id="content_mode_selector">&nbsp;</div>
	<div id="current_category_title" style="display:none">&nbsp;</div>
	<div id="Resizingimages" style="background:#f1f1f1; padding: 10px;">
		<div>System is resizing your images. It might take some time. Please wait.</div>
		<div>
		<?php 
            $sql_res = mysql_query("SELECT id, image_small FROM _mod_portfolio WHERE category_id=".$_GET['id']);
            while ($photo = @mysql_fetch_assoc($sql_res)) {
                
                $currentGallery = $_CFG['portfolioManager']->getCurrentPorfolioGallery();
			    
			    $sizes = $_CFG['portfolioManager']->getSizesArray();
			    $fixedSizes = $_CFG['portfolioManager']->getFixedSizesFlagArray();
			    
				resizePortfolioImages( unserialize($photo['image_small']), $sizes, $fixedSizes );
            }
        ?>
		</div>
	</div>
	<div class="grey-block mini" style="background:#e3e2e2; height:25px; padding-top:5px; border:1px solid #bfbfbf">
		<div id="content-footer" style="float:right; margin-right:15px"></div>
	</div>
</div>
<script>
	window.opener.location.href = window.opener.location.href;
	window.close();
</script>


