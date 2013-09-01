<?php

if (!defined("WBG_CONFIG_LOADED") OR !$DELETE_ALLOWED){
	die();
}


$SQL_str = "DELETE FROM _mod_partners WHERE category_id=".$TARGET['id'];
mysql_query($SQL_str);

?>