<?php include_once(dirname(__FILE__).'/../_common/_html_header.tpl.php');?>
<body onload="init()" style="background:#f7f7f7">
<div style="padding:15px 5px;">

<?php
$HTML_unregistered = '';
foreach ($for_HTML_unregistered_modules as $value) {
	$HTML_unregistered .=
	'<tr>
		<td>'.$value['title'].'</td>
		<td>'.$value['file'].'</td>
		<td>'.$value['categories'].'</td>
		<td><input type="text" style="width:100%" name="desc['.$value['title'].']" value=""/></td>
		<td><input type="submit" name="reg['.$value['title'].']" value="'.Register.'" class="button"/></td>
	</tr>';
}
if ($HTML_unregistered){
	$HTML_unregistered = '
	<form method="post" action="'.$_SERVER['PHP_SELF'].'?cat='.$_GET['cat'].'" name="">
	<table width="100%" class="my_list">
		<tr>
			<th width="10%" nowrap>'.(Module_name).'</th>
			<th width="25%" nowrap>'.(Module_file).'</th>
			<th width="10%" nowrap>'.(Module_Category).'</th>
			<th width="55%" nowrap>'.(Description).'</th>
			<th>&nbsp;</th>
		</tr>
		'.$HTML_unregistered.'
	</table>
	</form>
	<br/>';
}
?>

<?php echo $HTML_message?>
<?php echo $HTML_unregistered?>
<?php echo $HTML_data; ?>
<script>
function init(){
	window.parent.window.document.getElementById("group_name").innerHTML = "<?php echo $HTML_title?>";
	if (window.parent.window.activate_submenu){
		window.parent.window.activate_submenu("modules&cat=<?php echo $_GET['type']?>");
	}
}

var $modules_active = new Array();
function mark_module($id){
	unmark_all();
	$obj = document.getElementById("tr["+$id+"]");
	$obj.className = "active";
	$modules_active.push($obj)
}
function unmark_all(){
	while ($obj = $modules_active.pop()){
		if ($obj.className == "active"){
			$obj.className = "";
		}
	}
}
function delete_module($id){
	if (window.Popup){
		window.Popup.close();
	}
	window.Popup = window.open($url_to_cms+"core/modules/popups/popup.delete_module.php?id="+$id,"","width=700,height=500,resizable=yes,scrollbars=yes,left=200, top=100");
}
</script>
</div>
</body>
</html>