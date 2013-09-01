<?php

if (!defined("WBG_CONFIG_LOADED") OR !$COPY_ALLOWED){
	die();
}

$SQL_str = "SELECT * FROM _mod_portfolio WHERE category_id=".$SOURCE['id']."";
$sql_res = mysql_query($SQL_str);
while ($arr = mysql_fetch_assoc($sql_res)) {
	$SQL_str = array();
	foreach ($arr as $key=>$value) {
		if ($key == 'id') 			continue;
		if ($key == 'category_id') 	continue;
		$SQL_str[] = $key."='".addslashes($value)."'";
	}

	$SQL_str[] = "category_id=".$TARGET['id']."";
	$SQL_str = "INSERT INTO _mod_portfolio SET ".implode(',',$SQL_str)."";
	mysql_query($SQL_str);
}

?>