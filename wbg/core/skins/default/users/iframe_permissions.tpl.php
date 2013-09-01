<?php include_once(dirname(__FILE__).'/../_common/_html_header.tpl.php');?>
<body onload="init()" style="background:#efefef">

<?php echo $HTML_data; ?>

<script>
function init(){
	window.parent.window.document.getElementById("group_name").innerHTML = "<?php echo $HTML_title?>";
}

function show_hide_section($section, $mode, $obj){
	if (document.getElementById("subsection_"+$section)){
		document.getElementById("subsection_"+$section).style.display = $mode ? "" : "none";
	}
	$obj = $obj.parentNode;
	if ($mode==1){
		$obj.className = "yes";
		$obj.nextSibling.className = "yes";
		$obj.nextSibling.nextSibling.className = "";
		$obj.nextSibling.nextSibling.nextSibling.className = "";
	} else {
		$obj.className = "no";
		$obj.nextSibling.className = "no";
		$obj.previousSibling.className = "";
		$obj.previousSibling.previousSibling.className = "";
	}
}
function change_mode($mode){
	document.location.href="<?php echo $_SERVER['PHP_SELF']?>?cat=<?php echo $_GET['cat']?>&mode="+$mode;
}
</script>
<style>
	.yes {background:#92d58b !important;color:#ffffff !important}
	.no {background:#fec3c5 !important;color:#ffffff !important}
	.access_header {background:#08515A;color:#FFFFFF;font-size:11px;text-align:left;padding:2px 5px;border-right:1px solid #FFFFFF}
	
</style>
</body>
</html>