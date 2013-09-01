<?php 
function make_uninstall(){ 
mysql_query("DELETE FROM wbg_modules WHERE id='1'");
unlink("/usr/local/www/sites/projects_andrej/wake/wbg/modules/libraries/textlist.class/textlist.class.php");
unlink("/usr/local/www/sites/projects_andrej/wake/wbg/modules/libraries/textlist.class/onclick.js");
unlink("/usr/local/www/sites/projects_andrej/wake/wbg/modules/libraries/textlist.class/popup.copy_data.php");
unlink("/usr/local/www/sites/projects_andrej/wake/wbg/modules/libraries/textlist.class/popup.move_data.php");
unlink("/usr/local/www/sites/projects_andrej/wake/wbg/modules/libraries/textlist.class/_list_template_table.tpl");

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
 deldir("/usr/local/www/sites/projects_andrej/wake/wbg/modules/libraries/textlist.class");
	unlink("/usr/local/www/sites/projects_andrej/wake/wbg/modules/libraries/textlist.class/_uninstall_module.php");
	unlink("/usr/local/www/sites/projects_andrej/wake/wbg/modules/libraries/textlist.class/_install.log");
	rmdir("/usr/local/www/sites/projects_andrej/wake/wbg/modules/libraries/textlist.class/");

} ?>