<?php
/**
* @desc Eto failik v kotorom opisivajutsa vse razdeli sistemi
*/

$_CFG['sections']['wbg_starts'] = 'categories';  // Eto TITLE razdela kotorij nuzhno s samogo nachala zagruzitj


$title = "categories";
$_CFG['sections'][$title]['name'] 				= __SCT_1__;
$_CFG['sections'][$title]['from_directory'] 	= 'core/';
$_CFG['sections'][$title]['permissions'] 		= 'core/_permissions/';

$title = "messages";
$_CFG['sections'][$title]['name'] 				= __SCT_2__;
$_CFG['sections'][$title]['from_directory'] 	= 'core/';
$_CFG['sections'][$title]['permissions'] 		= 'core/_permissions/';

$title = "templates";
$_CFG['sections'][$title]['name'] 				= __SCT_3__;
$_CFG['sections'][$title]['from_directory'] 	= 'core/';
$_CFG['sections'][$title]['permissions'] 		= 'core/_permissions/';

$title = "modules";
$_CFG['sections'][$title]['name'] 				= __SCT_4__;
$_CFG['sections'][$title]['from_directory'] 	= 'core/';
$_CFG['sections'][$title]['permissions'] 		= 'core/_permissions/';

$title = "administration";
$_CFG['sections'][$title]['name'] 				= __SCT_5__;
$_CFG['sections'][$title]['from_directory'] 	= 'core/';
$_CFG['sections'][$title]['permissions'] 		= 'core/_permissions/';

$title = "developer";
$_CFG['sections'][$title]['name'] 				= __SCT_6__;
$_CFG['sections'][$title]['from_directory'] 	= 'core/';
$_CFG['sections'][$title]['permissions'] 		= 'core/_permissions/';

//======================================================================================c
 // [[[ Submenus

$title = "settings";
$_CFG['sections'][$title]['name'] 				= __SCT_7__;
$_CFG['sections'][$title]['from_directory'] 	= 'core/';
$_CFG['sections'][$title]['permissions'] 		= 'core/_permissions/';

$title = "mysql";
$_CFG['sections'][$title]['name'] 				= "MySQL sync";
$_CFG['sections'][$title]['from_directory'] 	= 'core/';
$_CFG['sections'][$title]['permissions'] 		= 'core/_permissions/';

$title = "filemanager";
$_CFG['sections'][$title]['name'] 				= __SCT_9__;
$_CFG['sections'][$title]['from_directory'] 	= 'core/';
$_CFG['sections'][$title]['permissions'] 		= 'core/_permissions/';

//$title = "backup";
//$_CFG['sections'][$title]['name'] 				= __SCT_10__;
//$_CFG['sections'][$title]['from_directory'] 	= 'core/';
//$_CFG['sections'][$title]['permissions'] 		= 'core/_permissions/';

$title = "update";
$_CFG['sections'][$title]['name'] 				= __SCT_11__;
$_CFG['sections'][$title]['from_directory'] 	= 'core/';
$_CFG['sections'][$title]['permissions'] 		= 'core/_permissions/';

$title = "tools";
$_CFG['sections'][$title]['name'] 				= __SCT_12__;
$_CFG['sections'][$title]['from_directory'] 	= 'core/';
$_CFG['sections'][$title]['permissions'] 		= 'core/_permissions/';

$title = "users";
$_CFG['sections'][$title]['name'] 				= __SCT_13__;
$_CFG['sections'][$title]['from_directory'] 	= 'core/';
$_CFG['sections'][$title]['permissions'] 		= 'core/_permissions/';

$title = "logs";
$_CFG['sections'][$title]['name'] 				= __SCT_14__;
$_CFG['sections'][$title]['from_directory'] 	= 'core/';
$_CFG['sections'][$title]['permissions'] 		= 'core/_permissions/';


$title = "todo";
$_CFG['sections'][$title]['name'] 				= __SCT_15__;
$_CFG['sections'][$title]['from_directory'] 	= 'core/';
$_CFG['sections'][$title]['permissions'] 		= 'core/_permissions/';

$title = "syslog";
$_CFG['sections'][$title]['name'] 				= __SCT_16__;
$_CFG['sections'][$title]['from_directory'] 	= 'core/';
$_CFG['sections'][$title]['permissions'] 		= 'core/_permissions/';

$title = "seo";
$_CFG['sections'][$title]['name'] 				= "SEO Management";
$_CFG['sections'][$title]['from_directory'] 	= 'core/';
$_CFG['sections'][$title]['permissions'] 		= 'core/_permissions/';


// ]]] Submenus
//=========================================================================
// Objavljajem kakije razdeli javljajutsa na samom dele podrazdelami

$_CFG['subsections']['logs'] 			= "administration";
$_CFG['subsections']['users'] 			= "administration";
$_CFG['subsections']['settings'] 		= "administration";
$_CFG['subsections']['filemanager'] 	= "administration";
//$_CFG['subsections']['backup'] 		= "administration";
$_CFG['subsections']['seo'] 			= "administration";

$_CFG['subsections']['mysql'] 			= "developer";
$_CFG['subsections']['tools'] 			= "developer";
$_CFG['subsections']['update'] 			= "developer";
$_CFG['subsections']['todo'] 			= "developer";
$_CFG['subsections']['syslog'] 			= "developer";

//=========================================================================
//
if (count($_CFG['language_name'])>1){
	foreach ($_CFG['language_name'] as $key=>$value) {
		$_CFG['sublinks']['messages']['links'][]		= "&lang=".$key;
		$_CFG['sublinks']['messages']['titles'][]		= mb_strtoupper($value, "utf8");
	}
}
if (count($_CFG['language_name'])>1){
	foreach ($_CFG['language_name'] as $key=>$value) {
		$_CFG['sublinks']['categories']['links'][]		= "&lang=".$key;
		$_CFG['sublinks']['categories']['titles'][]		= mb_strtoupper($value, "utf8");
	}
}

$_CFG['sublinks']['templates']['titles'][]		= "OUTPUT TEMPLATES";
$_CFG['sublinks']['templates']['links'][]		= "&cat=1&lang=".$_CFG['language'];
$_CFG['sublinks']['templates']['titles'][]		= "USER TEMPLATES";
$_CFG['sublinks']['templates']['links'][]		= "&cat=3&lang=".$_CFG['language'];
$_CFG['sublinks']['templates']['titles'][]		= "PROPERTY TEMPLATES";
$_CFG['sublinks']['templates']['links'][]		= "&cat=2&lang=".$_CFG['language'];
$_CFG['sublinks']['templates']['titles'][]		= "PREDEFINED TEMPLATES";
$_CFG['sublinks']['templates']['links'][]		= "&cat=4&lang=".$_CFG['language'];


$_CFG['sublinks']['modules']['titles'][]		= "INPUT MODULES";
$_CFG['sublinks']['modules']['links'][]			= "&cat=1&lang=".$_CFG['language'];
$_CFG['sublinks']['modules']['titles'][]		= "OUTPUT MODULES";
$_CFG['sublinks']['modules']['links'][]			= "&cat=2&lang=".$_CFG['language'];
$_CFG['sublinks']['modules']['titles'][]		= "STANDALONE MODULES";
$_CFG['sublinks']['modules']['links'][]			= "&cat=3&lang=".$_CFG['language'];
$_CFG['sublinks']['modules']['titles'][]		= "COMPONENTS";
$_CFG['sublinks']['modules']['links'][]			= "&cat=4&lang=".$_CFG['language'];
$_CFG['sublinks']['modules']['titles'][]		= "LIBRARIES";
$_CFG['sublinks']['modules']['links'][]			= "&cat=5&lang=".$_CFG['language'];
?>