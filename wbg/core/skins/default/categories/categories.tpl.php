<?php $OVERFLOW = 'style="overflow:hidden"';?>
<?php include_once(dirname(__FILE__).'/../_common/_html_header.tpl.php');?>
<?php include_once(dirname(__FILE__).'/../_common/top.tpl.php');?>
	<style>
		.mini {padding:3px}
		.mini, .mini * {font-size:9px}
	</style>
	<script>
		var $CURRENT_LANG = "<?php echo $_CFG['language']?>";
		function resize(){
			update_container("wbg-left-block", 30, <?php echo $top+120?>)
			update_container("site-content-container", 70, <?php echo $top+172?>)
		}
		function wbg_additional_info($button){
			var $X = findPosX($button);
			var $Y = findPosY($button);
			wbg_show_dropdown_menu($X-100, $Y+22, 118, "add_info", document.getElementById("addmenus").innerHTML);
		}
		function hide_left_menu($obj){
			if (document.getElementById("left-menu").style.display == "none"){
				$obj.firstChild.src="images/cat-collapse.gif";
				document.getElementById("left-menu").style.display = "";
				update_container("site-content-container", 70, <?php echo $top+172?>)
				update_container("wbg-left-block", 30, <?php echo $top+120?>)
			} else {
				$obj.firstChild.src="images/cat-collapse2.gif";
				document.getElementById("left-menu").style.display = "none";
				update_container("site-content-container", 100, <?php echo $top+172?>)
			}
		}
	</script>
	<div id="addmenus" style="display:none">
		<div style="padding:3px; background:#ffffff; border:1px solid #dddddd" class="dropdown-menu">
			<div style="padding:1px 2px 3px 2px; font-weight:bold"><?php echo __CTP_1__?></div>
			<a href="#" onclick="tree_change_display_mode(0); return false"><?php echo __CTP_2__?></a>
			<a href="#" onclick="tree_change_display_mode(1); return false"><?php echo __CTP_3__?></a>
			<a href="#" onclick="tree_change_display_mode(2); return false"><?php echo __CTP_4__?></a>
			<a href="#" onclick="tree_change_display_mode(3); return false"><?php echo __CTP_5__?></a>
		</div>
	</div>
	<table id="wbg-content"  width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td><a href="#" onclick="hide_left_menu(this); return false"><img src="images/cat-collapse.gif" border="0" style="margin:0px 5px 0px 5px"/></a></td>
			<td class="left-cat" style="padding-top:<?php echo $top+80?>px"  id="left-menu">
				<script>wbg_show_header("<?php echo __CTP_6__?>", '<img src="images/cat-create.gif" border="0" style="margin-right:2px; cursor:pointer" onclick="tree_DoAction(\'popup_create_root\'); contextMenu_remove();" title="<?php echo __CTP_7__?>"/><img src="images/cat-more.gif" border="0" style="margin-right:2px; cursor:pointer" onclick="wbg_additional_info(this)" title="<?php echo __CTP_7__?>"/>')</script>
				<div class="grey-block">
					<div id="wbg-left-block" style="overflow:auto">
						<code>
							<?php echo $sitetree->draw_tree();?>
						</code>
					</div>
				</div>
				<script>update_container("wbg-left-block", 30, <?php echo $top+120?>)</script>
			</td>
			<td class="right" style="padding-top:<?php echo $top+80?>px;" width="100%">
				<script>wbg_show_header('<?php echo __CTP_8__?> : <span id="current_category_title" style="color:#d58800">&nbsp;</span>')</script>
				<div class="grey-block">
					<div id="content_mode_selector">&nbsp;</div>
					<iframe src="<?php echo $_CFG['url_to_cms'].'core/categories/iframe_categories.php?lang='.@$_GET['lang']?>" id="site-content-container" frameborder="0" style="border:1px solid #f1f1f1"></iframe>
				</div>
				<script>update_container("site-content-container", 70, <?php echo $top+172?>)</script>
				<div class="grey-block mini" style="background:#e3e2e2; height:18px">
				<div id="content-footer" style="float:right; margin-right:15px"></div>
				</div>
			</td>
		</tr>
	</table>

</body>
</html>