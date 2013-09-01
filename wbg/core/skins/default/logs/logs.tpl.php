<?php $OVERFLOW = 'style="overflow:hidden"';?>
<?php include_once(dirname(__FILE__).'/../_common/_html_header.tpl.php');?>
<?php include_once(dirname(__FILE__).'/../_common/top.tpl.php');?>

	<style type="text/css">
		#frame * {vertical-align:middle}
		#frame .subs {margin-left:20px}
	</style>
	<table id="wbg-content">
		<tr>
			<td class="left" style="padding-top:<?php echo $top+80?>px">
				<script>wbg_show_header("Logs filter")</script>
				<div class="grey-block">
					<div id="wbg-left-block" style="overflow:auto">
						<code>
							<form method="post" action="<?php echo $_CFG['url_to_cms'].'core/logs/iframe_logs.php'?>" name="frame" id="frame" target="alogsframe">
								<div style="padding:0px 8px; line-height:20px">
									<?php
									include_once($_CFG['path_to_cms'].'core/actions.php');
									$data = '';
									foreach($_CFG['log_sections'] as $key=>$value){
										echo '<input type="checkbox" name="type['.$key.']"  id="name="type['.$key.']"" value="1" '.(@$_CHECKED[$key]?'checked':'').'/>'.$value.'<br/>';
										if (isSet($_CFG['log_subsections'][$key])) {
											foreach($_CFG['log_subsections'][$key] as $key2=>$value2){
												echo '<div class="subs"><input type="checkbox" id="type['.$key2.']" name="type['.$key2.']" value="1" '.(@$_CHECKED[$key2]?'checked':'').'/>'.$value2.'</div>';
											}
										}
									}
									?>
								</div>
								<div style="margin:5px; background:#ffffff; height:20px; padding-left:80px; padding-top:3px"><div class="button white"><input type="submit" name="change_type" value="Filter"/></div></div>
							</form>
						</code>
					</div>
				</div>
				<script>update_container("wbg-left-block", 20, <?php echo $top+130?>, 15)</script>
			</td>
			<td class="right" style="padding-top:<?php echo $top+80?>px;">
				<script>wbg_show_header('Current group : <span id="current_category_title">&nbsp;</span>')</script>
				<div class="grey-block">
					<iframe src="<?php echo $_CFG['url_to_cms'].'core/logs/iframe_logs.php'?>" name="alogsframe" id="alogsframe" style="border:0px"></iframe>
				</div>
				<script>update_container("alogsframe", 80, <?php echo $top+130?>, 5)</script>
			</td>
		</tr>
	</table>

</body>
</html>