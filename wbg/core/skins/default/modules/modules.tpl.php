<?php include_once(dirname(__FILE__).'/../_common/_html_header.tpl.php');?>
<?php include_once(dirname(__FILE__).'/../_common/top.tpl.php');?>


	<script>
		function download_module_new(){
			var $cat = window.$active_categories.split(";");
			if($cat.length > 3){
				alert("Select only one category where to install module!");
				return;
			}
			$id = prompt("Enter module ID from ["+document.getElementById("modulebank").value+"]");
			if (!$id) return;
			if (window.Popup){window.Popup.close()}
			window.Popup = open("<?php echo $_CFG['url_to_cms']?>core/modules/popups/popup.install_module.php?bank="+document.getElementById("modulebank").value+"&id="+$id+"&lang=<?php echo $_GET['lang']?>&current_cat="+$cat[1],"","width=750,height=600,scrollbars=yes,resizable=yes,left=200,top=100");
		}
	</script>

	<table id="wbg-content">
		<tr>
			<td class="left" style="padding-top:<?php echo $top+80?>px">
				<script>wbg_show_header("Modules groups")</script>
				<div class="grey-block">
					<div id="wbg-left-block" style="overflow:auto">
						<code>
							<?php echo $HTML_TREE?>
						</code>
					</div>
				</div>
				<script>update_container("wbg-left-block", 20, <?php echo $top+350?>, 15)</script>
				<br/>
				<script>wbg_show_header("Module download")</script>
				<div class="grey-block">
					<div id="wbg-left-block" style="overflow:auto">
							<?php
							include_once($_CFG['path_to_cms'].'config/modulebanks.php');
							$options = '';
							foreach ($_CFG['modulebank'] as $key=>$value) {
								$key = str_replace("http://", "", $key);
								$options .= '<option value="'.$key.'">'.$value.'</option>';
							}
							?>
<table align="center">
	<tr>
		<td colspan="2" align="center" style="padding-top:10px"><b>Select modules repository:</b></td>
	<tr>
		<td align="center"><select id="modulebank"><?php echo $options?></select></td>
	</tr>
	<tr>
		<td style="padding:10px 0px">
			<div class="button"><input type="button" value=" View modules " onclick="open('http://'+document.getElementById('modulebank').value, '', '')" ></div>
			<div class="button"><input type="button" value=" Install module " onclick="download_module_new()"></div>
		</td>
	</tr>
	<tr>
		<td></td>
	</tr>
</table>
					</div>
				</div>

			</td>
			<td class="right" style="padding-top:<?php echo $top+80?>px;">
				<script>wbg_show_header('Current group : <span id="group_name">&nbsp;</span>')</script>
				<div class="grey-block">
					<iframe src="<?php echo $_CFG['url_to_cms'].'core/modules/iframe_modules.php?lang='.@$_GET['lang']?>&cat=<?php echo @$_GET['cat']?>" id="modules-container"></iframe>
				</div>
				<script>update_container("modules-container", 80, <?php echo $top+130?>, 5)</script>
			</td>
		</tr>
	</table>
</body>
</html>