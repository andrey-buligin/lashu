<?php
/**
 * @outerfile
 */
$HTML_TITLE = 'Copy objects';

include_once(dirname(__FILE__).'/../../../config/config.php');
include_once($_CFG['path_to_cms'].'/core/config.php');
include_once($_CFG['path_to_cms'].'core/libraries/tree/tree_visuals.class.php');

$HTML_CONTENT = '';

if (!isset($_POST['lang'])){
	$_POST['lang'] = mysql_result(mysql_query("SELECT language FROM wbg_tree_categories WHERE id=".$_GET['id']),0,0);
}

$sitetree = new tree_visuals(0, $_POST['lang'], "wbg_tree_categories", "wbg_tree_categories");
$sitetree->activate_category($_GET['id']);
$dir = dirname(str_replace($_CFG['path_to_cms'], $_CFG['url_to_cms'],__FILE__)).'/';
$sitetree->js_with_onclick_action = $dir.'onclick.js';


$options = '';
foreach ($_CFG['language_name'] as $key=>$value) {
	$options .= '<option value="'.$key.'"'.($key==$_POST['lang']?' selected':'').'>'.$value.'</option>';
}

$HTML_CONTENT .= '
<form method="post" action="" id="mainform">
	<div style="padding:5px; margin-bottom:10px; background:#bbbbbb">Language: <select name="lang" onchange=document.getElementById("mainform").submit()>'.$options.'</select></div>
</form>
<script>
function tree_do_onclick($id){
	if (!confirm("Sure?")) return;
	window.opener.window.document.getElementById("list_action").value = "copy";
	window.opener.window.document.getElementById("list_value").value = $id
	window.opener.window.document.getElementById("mainform").submit();
	window.close();
}
</script>
';


include_once($_CFG['path_to_skin'].'categories/popups/popup.set_mirror.tpl.php');


?>