<?php $OVERFLOW = 'style="overflow:hidden"'; ?>
<?php include_once(dirname(__FILE__).'/../../_common/_html_header.tpl.php');?>
<?php $title = @mysql_result(mysql_query("SELECT title FROM ".(@$_CFG['categories']['sql_table']?$_CFG['categories']['sql_table']:'wbg_tree_categories')." WHERE id='".$_GET['cat']."'"),0,0)?>
<body>
<div style="position:absolute;bottom:-1px" id="sizer">&nbsp;</div>

<div style="padding:1px 2px">
	<script>
	function tree_ActivateCategory($x){
	}
	wbg_show_header("<?php echo $title?>");
	</script>

<div id="content_mode_selector">&nbsp;</div>
	<div id="current_category_title" style="display:none">&nbsp;</div>
	<iframe src="<?php echo $_CFG['url_to_cms'].'core/categories/iframe_categories.php?'.$_SERVER['QUERY_STRING']?>" style="width:100%;height:98%; border:0px" id="mainframe"></iframe>
	<script>
		$posY = findPosY(document.getElementById("sizer"));
		document.getElementById("mainframe").style.height = $posY-90+"px";
	</script>
	<div class="grey-block mini" style="background:#e3e2e2; height:25px; padding-top:5px; border:1px solid #bfbfbf">
		<div id="content-footer" style="float:right; margin-right:15px"></div>
	</div>
</div>



