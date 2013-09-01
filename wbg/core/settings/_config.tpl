<?php
/**
 * @desc Eto glavnij config Webadmina
 */

	$_CFG['ERROR_REPORTING'] = "{{ERROR_REPORTING}}";
	error_reporting({{ERROR_REPORTING}});

	$_CFG['START_CAT'] = {{START_CAT}};

// *******************************************************************************
// <<< Website languages.  Starts with 1 !!!!! 0 - is reserved !!!

	$_CFG['language_default'] = {{LANGUAGE_DEFAULT}}; // Language opens in WebGooRoo by default

{{LANGUAGE_PREFIX}}

{{LANGUAGE_NAME}}

// >>> Website languages
// *******************************************************************************
// <<< Pathes

	$_CFG['path_url']			= "{{PATH_URL}}"; // Esli root to "/";

	$_CFG['cms_name']			= 'wbg';
	list($_CFG['path_server'])	= explode($_CFG['cms_name'], dirname(__FILE__));

	$_CFG['path_url_full']		= $_SERVER['SERVER_NAME'] . $_CFG['path_url'];
	$_CFG['path_to_cms'] 		= $_CFG['path_server'] . $_CFG['cms_name'].'{{SLASH}}';
	$_CFG['path_to_templates'] 	= $_CFG['path_to_cms'] . 'templates{{SLASH}}';
	$_CFG['path_to_modules'] 	= $_CFG['path_to_cms'] . 'modules{{SLASH}}';
	$_CFG['path_to_translations'] = $_CFG['path_to_cms'] . "core{{SLASH}}translations{{SLASH}}";


	$_CFG['url_to_cms']			= $_CFG['path_url'] . $_CFG['cms_name']."/";
	$_CFG['url_to_modules'] 	= $_CFG['url_to_cms'] . 'modules/';
	$_CFG['url_to_templates'] 	= $_CFG['url_to_cms'] . 'templates/';

	$_CFG['url_to_skin']		= $_CFG['url_to_cms'] . "core/skins/default/";
	$_CFG['path_to_skin']		= $_CFG['path_to_cms']. "core/skins/default/";

	$_CFG['url_to_cms_full']	= "http://".$_SERVER['HTTP_HOST'] . $_CFG['url_to_cms'];

// >>> Pathes
// *******************************************************************************
// <<< DB

	$_CFG['sql']['host'] 		= "{{SQL_HOST}}";
	$_CFG['sql']['login'] 		= "{{SQL_LOGIN}}";
	$_CFG['sql']['password'] 	= "{{SQL_PASSWORD}}";
	$_CFG['sql']['database'] 	= "{{SQL_DATABASE}}";

	$sql_link = mysql_connect($_CFG['sql']['host'],$_CFG['sql']['login'],$_CFG['sql']['password']) or WBG_GLOBAL::wbg_die("Can't connect to database [".$_CFG['sql']['database']."] on [".$_CFG['sql']['host']."] with username [".$_CFG['sql']['login']."]");
	mysql_select_db ($_CFG['sql']['database'],$sql_link) or die ("Cant change database");

// >>> DB
// *******************************************************************************
// <<< Degug nastrojki

	{{DEBUG_MODE_IP}}

// >>> Degug nastrojki
// *******************************************************************************


	$_CFG['cache_mode'] = {{CACHE_MODE}};
	$_CFG['cache_directory']	= $_CFG['path_to_cms']. "{{CACHE_DIR}}";

	include_once(dirname(__FILE__).'/config.additional.php');
	include_once(dirname(__FILE__)."/../core/global_functions.php");

// *******************************************************************************

	$_CFG['interface_language'][0] = "Russian";
	$_CFG['interface_language'][1] = "Latvian";
	$_CFG['interface_language'][2] = "English";

	date_default_timezone_set("Etc/GMT");

?>