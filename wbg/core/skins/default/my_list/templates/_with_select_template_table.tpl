<?php
global $_CFG;
$dir = WBG_GLOBAL::path2url(__FILE__);

$HTML = '
<script type="text/javascript" src="'.$dir.'js/_with_select.js"></script>
<table onmouseover="mylist_parse_table(this)">
	<tr>'.$HTML_header.'</tr>
	'.implode("",$line).'
</table>';
?>