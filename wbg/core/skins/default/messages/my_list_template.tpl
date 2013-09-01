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
function _ml_open_copy(){
	if (window.Popup){
		window.Popup.close();
	}
	window.Popup = window.open("'.$_CFG['url_to_cms'].'core/messages/popups/popup.copy_messages.php","","width=600,height=600,scrollbars=yes,resizable=yes, left=200, top=100");
}
</script>
<script type="text/javascript" src="'.$dir.'js/_with_delete.js"></script>
<script type="text/javascript" src="'.$dir.'js/_with_select.js"></script>
<script type="text/javascript" src="'.$dir.'js/_dinamic_row_insert.js"></script>

<form action="" method="post" name="mainform">
	<div class="button" style=" margin-bottom:5px;"><input type="button" value=" '.__MYL_B_ADD_.' " onclick="_ml_withselect_onclick(0)"></div>
	<div style="float:left">&nbsp;</div>
	<div class="button" style=" margin-bottom:5px;"><input type="button" value=" '.__MYL_C_MOVE_.' " class="button3" onclick="_ml_open_copy()"></div>
	<div style="float:left">&nbsp;</div>
	<div class="button" style=" margin-bottom:5px;"><input type="submit" value=" '.__MYL_B_DEL_.' " onclick="return delete_elements(\''.$this->add_to_get.'\')" name="delete"></div>
	<br style="clear:both;"/>

<table  onmouseover="mylist_parse_table(this)" id="my_list_table">
	<tr><th><input type="checkbox" class="checkbox" onclick="check_all(this)"/></th>'.$HTML_header.'</tr>
	'.implode("",$line).'
</table>
</form>';
?>