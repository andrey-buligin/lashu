<?php 
function make_uninstall(){ 
mysql_query("DELETE FROM wbg_modules WHERE id='1'");
mysql_query("DROP TABLE IF EXISTS _mod_textlist");
unlink("/usr/local/www/sites/projects_andrej/cesu_festivals/wbg/modules/input/textlist_input/textlist_input.php");
unlink("/usr/local/www/sites/projects_andrej/cesu_festivals/wbg/modules/input/textlist_input/_list_functions.php");
unlink("/usr/local/www/sites/projects_andrej/cesu_festivals/wbg/modules/input/textlist_input/_list_template_table.tpl");
unlink("/usr/local/www/sites/projects_andrej/cesu_festivals/wbg/modules/input/textlist_input/_translations.php");
unlink("/usr/local/www/sites/projects_andrej/cesu_festivals/wbg/modules/input/textlist_input/onclick.js");
unlink("/usr/local/www/sites/projects_andrej/cesu_festivals/wbg/modules/input/textlist_input/popup.copy_data.php");
unlink("/usr/local/www/sites/projects_andrej/cesu_festivals/wbg/modules/input/textlist_input/popup.move_data.php");
unlink("/usr/local/www/sites/projects_andrej/cesu_festivals/wbg/modules/input/textlist_input/wbg_make_search.php");
unlink("/usr/local/www/sites/projects_andrej/cesu_festivals/wbg/modules/input/textlist_input/wbg_seo_sitemap.php");
unlink("/usr/local/www/sites/projects_andrej/cesu_festivals/wbg/modules/input/textlist_input/wbg_set_crosslink.php");
unlink("/usr/local/www/sites/projects_andrej/cesu_festivals/wbg/modules/input/textlist_input/__template.php");

	function deldir($dir) {
		$files = glob($dir."*");
		foreach ($files as $value){
			if (is_dir($value)){
				deldir($value."/");
			} else {
				unlink($value);
			}
		}
		rmdir($dir);
	}
 deldir("/usr/local/www/sites/projects_andrej/cesu_festivals/wbg/modules/input/textlist_input");
	unlink("/usr/local/www/sites/projects_andrej/cesu_festivals/wbg/modules/input/textlist_input/_uninstall_module.php");
	unlink("/usr/local/www/sites/projects_andrej/cesu_festivals/wbg/modules/input/textlist_input/_install.log");
	rmdir("/usr/local/www/sites/projects_andrej/cesu_festivals/wbg/modules/input/textlist_input/");

} ?>