<?php
global $_CFG;
$dir = WBG_GLOBAL::path2url(__FILE__);
$HTML = '
<script>$translation_1 = "'.__MYL_C_DEL_.'";</script>
<script type="text/javascript" src="'.$dir.'js/_with_delete.js"></script>
<form action="" method="post" name="mainform">
<input type="submit" value=" '.__MYL_B_DEL_.' " class="button3" onclick="return delete_elements(\''.$this->add_to_get.'\')" name="delete">
<table>
	<tr>'.$HTML_header.'<th><input type="checkbox" class="checkbox" onclick="check_all(this)"/></th></tr>
	'.implode("",$line).'
</table>
</form>';
?>