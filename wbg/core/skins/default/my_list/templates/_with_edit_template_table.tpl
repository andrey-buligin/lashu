<?php
global $_CFG;
$dir = WBG_GLOBAL::path2url(__FILE__);

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
<div style="padding-bottom:25px">
	<div class="button"><input type="button" value=" Add object " onclick="_ml_withselect_onclick(0)"></div>
	'.@$this->template_buttons.'
	<div class="button right"><input type="submit" style="color:red" value=" Delete objects " name="delete" onclick="return delete_elements(\''.$this->add_to_get.'\')"></div>
</div>

<table  onmouseover="mylist_parse_table(this)">
	<tr><th><input type="checkbox" class="checkbox" onclick="check_all(this)"/></th>'.$HTML_header.'</tr>
	'.implode("",$line).'
</table>
</form>';
?>