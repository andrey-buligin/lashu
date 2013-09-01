<?php include_once(dirname(__FILE__).'/../_common/_html_header.tpl.php');?>
<?php include_once(dirname(__FILE__).'/../_common/top.tpl.php');?>


	<table id="wbg-content">
		<tr>
			<td class="left" style="padding-top:<?php echo $top+80?>px">
				<script>wbg_show_header("Templates")</script>
				<div class="grey-block">
					<div id="wbg-left-block" style="overflow:auto">
						<code>
							<?php echo $sitetree->draw_tree();?>
						</code>
					</div>
				</div>
				<script>update_container("wbg-left-block", 20, <?php echo $top+130?>, 15)</script>
			</td>
			<td class="right" style="padding-top:<?php echo $top+80?>px;">
				<script>wbg_show_header('Current group : <span id="group_name">&nbsp;</span>')</script>
				<div class="grey-block">
					<iframe src="<?php echo $_CFG['url_to_cms'].'core/templates/iframe_templates.php?lang='.@$_GET['lang']?>&cat=<?php echo @$_GET['cat']?>" id="templates-container"></iframe>
				</div>
				<script>update_container("templates-container", 80, <?php echo $top+130?>, 5)</script>
			</td>
		</tr>
	</table>

</body>
</html>