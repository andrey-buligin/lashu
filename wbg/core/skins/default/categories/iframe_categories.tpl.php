<?php define("NODOCTYPE", true)?>
<?php include_once(dirname(__FILE__).'/../_common/_html_header.tpl.php');?>
<body onload="init()" style="background:#f1f1f1">
<table width="100%">
	<tr>
		<td style="padding:10px 3px">
<?php echo $HTML_data; ?>

<script>
function init(){
	if (window.parent.window.activate_submenu){
		window.parent.window.activate_submenu();
	}
	if (window.parent.window.document.getElementById('content-footer')){
		window.parent.window.document.getElementById('content-footer').innerHTML = "&nbsp;";
	}
	if (window.init2){
		init2();
	}
}
</script>
		</td>
	</tr>
</table>

</body>
</html>