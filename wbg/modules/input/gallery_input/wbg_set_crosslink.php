<?php

include_once (dirname(__FILE__).'/gallery_input.php');

TEXTLIST::$sql_table	= "_mod_textlist";
$HTML_CONTENT = TEXTLIST::show_list_for_crosslinks($_POST['category_id']);


?>