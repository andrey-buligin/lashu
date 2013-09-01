<?php

include_once (dirname(__FILE__).'/textlist_input.php');

TEXTLIST::$sql_table	= "_mod_textlist";
$HTML_CONTENT = TEXTLIST::show_list_for_crosslinks($_POST['category_id']);


?>