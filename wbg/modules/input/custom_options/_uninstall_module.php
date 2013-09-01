<?php 
function make_uninstall(){ 
mysql_query("DELETE FROM wbg_modules WHERE id='14'");
mysql_query("DROP TABLE IF EXISTS _mod_product_parametr");
unlink("/usr/local/www/sites/projects_andrej/ojmar/wbg/modules/input/product_parametr/__template.php");
unlink("/usr/local/www/sites/projects_andrej/ojmar/wbg/modules/input/product_parametr/product_parametr.php");

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
 deldir("/usr/local/www/sites/projects_andrej/ojmar/wbg/modules/input/product_parametr");
	unlink("/usr/local/www/sites/projects_andrej/ojmar/wbg/modules/input/product_parametr/_uninstall_module.php");
	unlink("/usr/local/www/sites/projects_andrej/ojmar/wbg/modules/input/product_parametr/_install.log");
	rmdir("/usr/local/www/sites/projects_andrej/ojmar/wbg/modules/input/product_parametr/");

} ?>