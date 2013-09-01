<?php 

define("NOAUTH_IN_WBG", true);
include(dirname(__FILE__).'/../config/config.php');
include(dirname(__FILE__).'/config.php');
include(dirname(__FILE__).'/actions.php');


//======================================================================================
// [[[ Avtorizacija

	if (!isset($_CFG['server_settings'])){ // Esli voobshe ne zadano v konfige
		echo serialize(array('error'=> "Server settings undefined"));
		exit;
	}
	
	if ($_CFG['server_settings']['server_ip'] != $_SERVER['REMOTE_ADDR']){
		echo serialize(array('error'=> "Authorization failed for IP [".$_SERVER['REMOTE_ADDR']."]"));
		exit;
	}

// ]]] Avtorizacija
//======================================================================================


$OUT 				= array();
$OUT['wbg_version'] = $_CFG['version'];
$output_modules	 	= array(-1);
$USERS				= array();

//======================================================================================

$SQL_str = "SELECT id, login FROM wbg_users";
$sql_res = mysql_query($SQL_str);
while ($arr = mysql_fetch_assoc($sql_res)){
	$USERS[$arr['id']] = $arr['login'];
}

$SQL_str = "SELECT * FROM wbg_modules order by title";
$sql_res = mysql_query($SQL_str);
while ($arr = mysql_fetch_assoc($sql_res)){

	if ($arr['type'] == 2){
		$output_modules[] = $arr['id'];
	}
	
	//--------------------------------------------------------------------------------------
	// [[[ Ustanavlivajem datu poslednego izmenenija modulja
	
		$arr['last_update_time'] = @filectime($_CFG['path_to_modules'].$arr['file']);
		if ($arr['type'] == 1){
			$dir_to_check_files = $_CFG['path_to_modules'].dirname($arr['file']);
		} else {
			$dir_to_check_files = preg_replace("/\\.php$/si", "", $_CFG['path_to_modules'].$arr['file']);
		}
		$files = glob($dir_to_check_files."/*");
		foreach ($files as $file){
			$arr['last_update_time'] = MAX($arr['last_update_time'], filectime($file));
		}

	// ]]] Ustanavlivajem datu poslednego izmenenija modulja
	//--------------------------------------------------------------------------------------
	
	$OUT['all_modules'][] = $arr;
}

//======================================================================================

$SQL_str = "SELECT * FROM ".(@$_CFG['categories']['sql_table']?$_CFG['categories']['sql_table']:'wbg_tree_categories')." WHERE active=1 AND enabled=1 AND output_module IN (".implode(",", $output_modules).")";
$sql_res = mysql_query($SQL_str);
while ($arr = mysql_fetch_assoc($sql_res)){
	$OUT['output_modules_examples'][$arr['output_module']] = $arr;
}

//======================================================================================

$SQL_str = "SELECT date,action,target,ip,user,category_id FROM wbg_logs WHERE date > ".strtotime("now -1 month")." ORDER BY date DESC";
$sql_res = mysql_query($SQL_str);
while ($arr = mysql_fetch_assoc($sql_res)){
	$arr['action_title'] = $_CFG['log_actions'][$arr['action']];
	$arr['action_user'] = @$USERS[$arr['user']];
	$OUT['last_logs'][] = $arr;
}
//======================================================================================



echo serialize($OUT);

?>