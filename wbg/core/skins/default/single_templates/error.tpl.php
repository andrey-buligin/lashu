<?php
$_CFG['version'] = ". Content management system .";

if (!$nocategory_error){

	$CURRENT_CAT = $web->category_data[$web->active_category];

	$MODULE_IN = mysql_fetch_assoc(mysql_query("SELECT * FROM wbg_modules WHERE id=".$CURRENT_CAT['input_module']));
	$MODULE_IN['title'] = $MODULE_IN ? $MODULE_IN['title'] : 'None';

	$MODULE_OUT = mysql_fetch_assoc(mysql_query("SELECT * FROM wbg_modules WHERE id=".$CURRENT_CAT['output_module']));
	$MODULE_OUT['title'] = $MODULE_OUT ? $MODULE_OUT['title'] : '<span style="color:red; font-weight:bold">None</span>';

	$TEMPLATE_OUT = mysql_fetch_assoc(mysql_query("SELECT * FROM wbg_templates WHERE id=".$CURRENT_CAT['output_template']));
	$TEMPLATE_OUT['title'] = $TEMPLATE_OUT ? $TEMPLATE_OUT['title'] : '<span style="color:red; font-weight:bold">None !!!</span>';

	$locationbar = array();
	foreach ($web->active_tree as $value) {
		$locationbar[] .= $web->category_data[$value]['title'];
	}
} else if ($nocategory_error){

	$ERROR_nocat = '<br/><span style="font-size:24px; color:#08515a;">'.@$ERROR.'</span>';
	$ERROR = '';

}

?>
<?php include_once(dirname(__FILE__).'/../_common/_html_header.tpl.php')?>
<body>
<style>
	#info td {padding-left:15px}
</style>
<script>
	$width = window.document.body.clientWidth;
	$str = '<table cellspacing="0" cellpadding="0" align="center" width="'+($width>920?'920px':'98%')+'">';
	document.write($str);
</script>
	<tr>
		<td><img src="images/startpage/bg-left.png" border="0"/></td>
		<td width="100%" style="background:url('images/startpage/bg.png') top repeat-x" align="center"><img src="images/startpage/bg-center.png" border="0"/></td>
		<td><img src="images/startpage/bg-right.png" border="0"/></td>
	</tr>
	<tr>
		<td colspan="3" align="center" style="white-space:nowrap">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td><img src="images/startpage/spacer-left.gif" border="0"/></td>
					<td width="100%"><img src="images/startpage/spacer.gif" width="100%" height="1"/></td>
					<td><img src="images/startpage/spacer-right.gif" border="0"/></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<div style="position:absolute;left:0px;top:80px;text-align:center;width:100%">
	<a href="http://www.web-gooroo.com" target="_blank"><img src="images/startpage/logo.gif" border="0" style="margin-bottom:95px"/></a>
<table align="center" width="700">
	<tr>
		<td><img src="images/warning.gif" border="0"/></td>
		<td width="100%" align="left">
			<span style="font-size:38px; color:#f7a208 ; font-weight:bold"><?php echo @$ERROR_prefix?></span>
			<span style="font-size:24px; color:#08515a; margin-left:10px"><?php echo @$ERROR?></span>
		</td>
	</tr>
	<tr>
		<td></td>
		<td align="left">
			<?php echo @$ERROR_nocat?>
			<?php if (!$nocategory_error) {?>
			Location: <?php echo @implode(' :: ',@$locationbar)?>
			<table id="info" style="border-top:1px solid #eeeeee; border-bottom:1px solid #eeeeee;  margin-top:10px">
				<tr>
					<td colspan="2" style="padding:10px 0px"><b>Current category information:</b></td>
				</tr>
				<tr>
					<td style="color:#999999">ID:</td>
					<td><?php echo @$CURRENT_CAT['id']?></td>
				</tr>
				<tr>
					<td style="color:#999999">Title:</td>
					<td><?php echo @$CURRENT_CAT['title']?></td>
				</tr>
				<tr>
					<td style="color:#999999">Language:</td>
					<td><?php echo @$_CFG['language_name'][$CURRENT_CAT['language']]?></td>
				</tr>
				<tr>
					<td colspan="2" style="padding:20px 0px 10px 0px"><b>Current category settings:</b></td>
				</tr>
				<tr>
					<td style="color:#999999">Output template:</td>
					<td><?php echo @$TEMPLATE_OUT['title']?></td>
				</tr>
				<tr>
					<td style="color:#999999">Output module:</td>
					<td><?php echo @$MODULE_OUT['title']?></td>
				</tr>
				<tr>
					<td style="color:#999999">Input module:</td>
					<td><?php echo @$MODULE_IN['title']?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>
			<?php } ?>
			<br/><br/>
			More information about this screen you can get on website : <a href="http://www.web-gooroo.com" target="_blank" style="color:#000000">www.web-gooroo.com</a>
		</td>
	</tr>
</table>

</div>
</body>
</html>