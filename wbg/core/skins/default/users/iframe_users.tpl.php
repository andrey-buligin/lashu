<?php include_once(dirname(__FILE__).'/../_common/_html_header.tpl.php');?>
<body onload="init()" style="background:#f7f7f7">
<div style="padding:15px 5px;">
	<?php echo $HTML_data; ?>

<script>
function init(){
	window.parent.window.document.getElementById("group_name").innerHTML = "<?php echo $HTML_title?>";
}
var $messages_active = new Array();
function mark_message($id){
	unmark_all();
	$obj = document.getElementById("tr["+$id+"]");
	$obj.className = "active";
	$messages_active.push($obj)
}
function unmark_all(){
	while ($obj = $messages_active.pop()){
		if ($obj.className == "active"){
			$obj.className = "";
		}
	}
}

function change_mode($mode){
	document.location.href="<?php echo $_SERVER['PHP_SELF']?>?cat=<?php echo $_GET['cat']?>&mode="+$mode;
}
</script>
</div>
</body>
</html>