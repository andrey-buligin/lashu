<?php
/**
 * Eto failik v kotorom lezhat vse dejstvija ih oboznachenija.
 * Eti dannije zatem ispolzujutsa dlja sohranenija i pokaza statistiki
 * po dejstvijam usera v inSite
 */

$_CFG['log_actions'] = array (
		1 => "Create",
		2 => "Update",
		3 => "Delete",
		4 => "Move",
		5 => "Copy",
		6 => "Insert",
		7 => "Activate/Deactivate",
		8 => "Enable/Disable",
		9 => "Login",
		10 => "Logout",
		11 => "Set mirror",
		12 => "Update permissions",
		13 => "Login failed",
		14 => "<span style='color:red'>Hacking</span>",
		15 => "Update Template",
		16 => "Create directory",
		17 => "Overwrite",
		18 => "Upload");

// Index 4 - unikalen. On dolzhen vsegda bitj prisvojen Moduljam
$_CFG['log_sections'][0] = "Categories";
$_CFG['log_sections'][1] = "Messages";
$_CFG['log_sections'][2] = "Templates";
$_CFG['log_sections'][3] = "Images";
$_CFG['log_sections'][4] = "Modules";
$_CFG['log_sections'][5] = "Security";
$_CFG['log_sections'][6] = "Users";
$_CFG['log_sections'][7] = "File Manager";
$_CFG['log_sections'][8] = "Sets";

$sql_res = mysql_query("SELECT id,title FROM wbg_modules WHERE type=1 ORDER BY title");
while ($arr = mysql_fetch_array($sql_res)) {
	$_CFG['log_subsections'][4][$arr['id']] = $arr['title'];
}

?>