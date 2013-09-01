<?php include_once(dirname(__FILE__).'/../_common/_html_header.tpl.php');?>
<?php include_once(dirname(__FILE__).'/../_common/top.tpl.php');?>
<?php
//@todo nuzhno chtobi messages - sozdanije roota normalno bilo
$HTML_data = '';
if (!isset($FILE_with_data)) $FILE_with_data = array();

foreach ($FILE_with_data as $key=>$value) {
	$HTML_data .=
	'<tr>
		<td>'.dirname($value['file']).'</td>
		<td style="padding:0px 10px; font-weight:bold">'.basename($value['file']).'</td>
		<td>'.$value['text'].'</td>
	</tr>';
}
?>
<div style="padding-top:<?php echo $top+80?>px;">
	<div style="padding:0px 15px">
		<script>wbg_show_header("Todo searcher")</script>
		<div class="grey-block" style="background:#efefef; padding:10px 4px">
			<?php echo $HTML_CONTENT?>
			<LINK REL="StyleSheet" HREF="<?php echo $_CFG['url_to_skin']?>my_list/my_list.css" type="text/css" />
			<table class="my_list">
				<tr>
					<th>Dir</th>
					<th>File</th>
					<th>Comment</th>
				</tr>
				<?php echo $HTML_data?>
			</table>
		</div>
	</div>
</div>
</body>
</html>