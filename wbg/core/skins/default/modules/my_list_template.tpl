<?php
global $_CFG;
$dir = WBG_GLOBAL::path2url(__FILE__);

$HTML = '
<script>
function _ml_withselect_onclick($id){
	if (window.Popup){
		window.Popup.close();
	}
	window.Popup = window.open("'.$this->popup_window['src'].'?edit="+$id+"&'.$this->add_to_get.'","","'.$this->popup_window['attributes'].'");
}
</script>
<script type="text/javascript" src="'.$dir.'js/_with_delete.js"></script>
<script type="text/javascript" src="'.$dir.'js/_with_select.js"></script>
<script type="text/javascript" src="'.$dir.'js/_dinamic_row_insert.js"></script>

<form action="" method="post" name="mainform">
<div class="button" style=" margin-bottom:5px"><input type="button" value=" Add new module manually " onclick="_ml_withselect_onclick(0)"></div>
<br style="clear:both;"/>


<table  onmouseover="mylist_parse_table(this)" id="my_list_table">
	<tr>'.$HTML_header.'</tr>
	'.implode("",$line).'
</table>
</form>';
?>