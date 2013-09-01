<?php include_once(dirname(__FILE__).'/../_common/_html_header.tpl.php');?>
<?php include_once(dirname(__FILE__).'/../_common/top.tpl.php');?>


	<table id="wbg-content">
		<tr>
			<td class="left" style="padding-top:<?php echo $top+80?>px">
				<script>wbg_show_header("Users groups")</script>
				<div class="grey-block">
					<div id="wbg-left-block" style="overflow:auto">
						<code>
							<?php echo $sitetree->draw_tree();?>
						</code>
					</div>
				</div>
				
				<script>update_container("wbg-left-block", 20, <?php echo $top+340?>, 15)</script>
				<br>
				<script>wbg_show_header("<?php echo WBG::txt("Root users group")?>")</script>
				<div class="grey-block">
					<div id="wbg-left-block" style="overflow:auto">
						<table align="center">
							<tr>
								<td style="padding:10px 0px">
									<div class="button" style=" margin-bottom:5px;"><input type="button" value=" <?php echo WBG::txt("Create root group")?> " onclick="tree_DoAction('popup_create_new', '0')"></div>								
								</td>
							</tr>
						</table>
					</div>
				</div>
				
				
				
			</td>
			<td class="right" style="padding-top:<?php echo $top+80?>px;">
				<script>wbg_show_header('Current group : <span id="group_name"></span>')</script>
				<div id="content_mode_selector">&nbsp;</div>
				<div class="grey-block">
					<iframe src="<?php echo $_CFG['url_to_cms'].'core/users/iframe_users.php'?>?cat=<?php echo @$_GET['cat']?>" id="users-container" style="border:0px"></iframe>
				</div>
				<script>update_container("users-container", 80, <?php echo $top+157?>, 5)</script>
			</td>
		</tr>
	</table>

</body>
</html>