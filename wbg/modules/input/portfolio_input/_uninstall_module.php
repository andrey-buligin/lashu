<?php 
function make_uninstall(){ 
mysql_query("DELETE FROM wbg_modules WHERE id='1'");
mysql_query("DROP TABLE IF EXISTS _mod_banners");
unlink("/usr/local/www/sites/projects_andrej/ojmar/wbg/modules/input/banners/banners.php");
unlink("/usr/local/www/sites/projects_andrej/ojmar/wbg/modules/input/banners/__template.php");
unlink("/usr/local/www/sites/projects_andrej/ojmar/wbg/modules/input/banners/wbg_copy_content.php");
unlink("/usr/local/www/sites/projects_andrej/ojmar/wbg/modules/input/banners/wbg_delete_content.php");

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
 deldir("/usr/local/www/sites/projects_andrej/ojmar/wbg/modules/input/banners");
	unlink("/usr/local/www/sites/projects_andrej/ojmar/wbg/modules/input/banners/_uninstall_module.php");
	unlink("/usr/local/www/sites/projects_andrej/ojmar/wbg/modules/input/banners/_install.log");
	rmdir("/usr/local/www/sites/projects_andrej/ojmar/wbg/modules/input/banners/");

} ?>