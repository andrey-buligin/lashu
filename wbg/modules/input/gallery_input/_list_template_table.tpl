<?php
global $_CFG;
$dir = str_replace($_CFG['path_to_cms'], $_CFG['url_to_cms'], __FILE__);
$dir = dirname($dir).'/';

$HTML = '
<script>
$translation_1 = "'.__MYL_C_DEL_.'";
function _ml_withselect_onclick($id){
	document.location.href = "'.$_SERVER['PHP_SELF'].'?edit="+$id+"&'.$this->add_to_get.'";
}
</script>
<script type="text/javascript" src="'.$dir.'js/_with_delete.js"></script>
<script type="text/javascript" src="'.$dir.'js/_with_select.js"></script>



<form action="" method="post" name="mainform" id="mainform">
<input type="hidden" value="" name="list_action" id="list_action">
<input type="hidden" value="" name="list_value" id="list_value">
<div style="padding-bottom:25px">
	<div class="button"><input type="button" value=" Add object " onclick="_ml_withselect_onclick(0)"></div>
	<div class="button" style="float:right"><input type="submit" style="color:red" value=" Delete objects " name="delete" onclick="return delete_elements()"></div>
	<div class="button"><input type="button" value=" Copy objects " name="copy" onclick="open_popup(\''.$_CFG['current_category']['module_dir']."popup.copy_data.php?id=".$_CFG['current_category']['id']."".'\', 600, 700)"></div>
	<div class="button"><input type="button" value=" Move objects " name="move"  onclick="open_popup(\''.$_CFG['current_category']['module_dir']."popup.move_data.php?id=".$_CFG['current_category']['id']."".'\', 600, 700)"></div>
</div>

<table  onmouseover="mylist_parse_table(this)">
	<tr><th><input type="checkbox" class="checkbox" onclick="check_all(this)"/></th>'.$HTML_header.'</tr>
	'.implode("",$line).'
</table>
</form>';
?>