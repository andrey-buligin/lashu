<?php
global $_CFG;
$dir = WBG_GLOBAL::path2url(__FILE__);

$HTML = '
<script>
$translation_1 = "'.__MYL_C_DEL_.'";
function _ml_withselect_onclick($id){
	if (window.Popup){
		window.Popup.close();
	}
	window.Popup = window.open("'.$this->popup_window['src'].'?edit="+$id+"&'.$this->add_to_get.'","","'.$this->popup_window['attributes'].'");
}
</script>
<script type="text/javascript" src="'.$dir.'js/_with_delete.js"></script>
<script type="text/javascript" src="'.$dir.'js/_with_select.js"></script>



<form action="" method="post" name="mainform">
<input type="button" value=" '.__MYL_B_ADD_.' " class="button3" onclick="_ml_withselect_onclick(0)">
<input type="submit" value=" '.__MYL_B_DEL_.' " class="button3" onclick="return delete_elements(\''.$this->add_to_get.'\')" name="delete">
<table  onmouseover="mylist_parse_table(this)" style="margin-top:10px">
	<tr><th><input type="checkbox" class="checkbox" onclick="check_all(this)"/></th>'.$HTML_header.'</tr>
	'.implode("",$line).'
</table>
</form>';
?>