<?php $OVERFLOW = 'style="overflow:hidden"';?>
<?php include_once(dirname(__FILE__).'/../_common/_html_header.tpl.php');?>
<?php include_once(dirname(__FILE__).'/../_common/top.tpl.php');?>

<script>
	function resize(){
		update_container("wbg-left-block", 20, <?php echo $top+157?>, 15);
		update_container("messages-container", 80, <?php echo $top+122?>, 5);
	}
</script>

	<table id="wbg-content">
		<tr>
			<td class="left" style="padding-top:<?php echo $top+80?>px">
				<script>wbg_show_header("Message groups")</script>
				<div class="grey-block">
					<div id="wbg-left-block" style="overflow:auto">
						<code>
							<?php echo $HTML_TREE?>
						</code>
					</div>
				</div>
				<script>update_container("wbg-left-block", 20, <?php echo $top+157?>, 15)</script>
				<div style="border:1px solid #cccccc; background:#eeeeee;  margin-top:5px; padding:5px 10px 11px 10px">
					<div class="button" style=" margin-bottom:5px;"><input type="button" value=" Add new root group " onclick="tree_DoAction('popup_create_new', '0')"></div>&nbsp;
				</div>
			</td>
			<td class="right" style="padding-top:<?php echo $top+80?>px;">
				<script>wbg_show_header('Current group : <span id="group_name">&nbsp;</span>')</script>
				<div class="grey-block">
					<iframe src="<?php echo $_CFG['url_to_cms'].'core/messages/iframe_messages.php?lang='.$_GET['lang']?>" id="messages-container"></iframe>
				</div>
				<script>update_container("messages-container", 80, <?php echo $top+122?>, 5)</script>
			</td>
		</tr>
	</table>
</body>
</html>