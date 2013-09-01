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
<script type="text/javascript" src="'.$dir.'js/_with_select.js"></script>

<table  onmouseover="mylist_parse_table(this)" id="my_list_table">
	<tr>'.$HTML_header.'</tr>
	'.implode("",$line).'
</table>';
?>