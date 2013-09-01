<?php include_once(dirname(__FILE__).'/../_common/_html_header.tpl.php');?>
<body onload="init()" style="background:#f7f7f7; border:0px">
<div style="background:#e0e0e0; padding:10px 0px">
	<?php echo $HTML_filter?>
</div>
<div style="padding:10px">
	<?php echo $HTML_data; ?>
</div>
<script>

function init(){
	$elements = "<?php echo @implode(",", array_keys($_POST['type']))?>";
	if (window.parent.window.mark_checkbox){
		window.parent.window.mark_checkbox($elements.split(","));
	}
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
</script>
</body>
</html>