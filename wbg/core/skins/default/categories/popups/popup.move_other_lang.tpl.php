<?php

$options = '';
foreach ($_CFG['language_name'] as $key=>$value) {
	$options .= '<option value="'.$key.'"'.($key==$_POST['lang']?' selected':'').'>'.$value.'</option>';
}

$HTML_CONTENT .= '
<form method="post" action="" id="mainform">
<div style="padding:5px; margin-bottom:10px; background:#bbbbbb">Language: <select name="lang" onchange=document.getElementById("mainform").submit()>'.$options.'</select></div>
</form>';

$HTML_CONTENT .= $sitetree->draw_tree();


include_once(dirname(__FILE__).'/../../popup.default.tpl.php');
?>