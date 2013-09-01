<?php 
function make_uninstall(){ 
mysql_query("DELETE FROM wbg_modules WHERE id='25'");
mysql_query("DROP TABLE IF EXISTS _mod_galleries");
unlink("F:\Apache\htdocs\fans\wbg\modules\input\gallery_input\gallery_input.php");
unlink("F:\Apache\htdocs\fans\wbg\modules\input\gallery_input\_list_functions.php");
unlink("F:\Apache\htdocs\fans\wbg\modules\input\gallery_input\_list_template_table.tpl");
unlink("F:\Apache\htdocs\fans\wbg\modules\input\gallery_input\_translations.php");
unlink("F:\Apache\htdocs\fans\wbg\modules\input\gallery_input\onclick.js");
unlink("F:\Apache\htdocs\fans\wbg\modules\input\gallery_input\popup.copy_data.php");
unlink("F:\Apache\htdocs\fans\wbg\modules\input\gallery_input\popup.move_data.php");
unlink("F:\Apache\htdocs\fans\wbg\modules\input\gallery_input\wbg_make_search.php");
unlink("F:\Apache\htdocs\fans\wbg\modules\input\gallery_input\wbg_seo_sitemap.php");
unlink("F:\Apache\htdocs\fans\wbg\modules\input\gallery_input\wbg_set_crosslink.php");
unlink("F:\Apache\htdocs\fans\wbg\modules\input\gallery_input\__template.php");

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
 deldir("F:\Apache\htdocs\fans\wbg\modules/input/gallery_input");
	unlink("F:\Apache\htdocs\fans\wbg\modules/input/gallery_input/_uninstall_module.php");
	unlink("F:\Apache\htdocs\fans\wbg\modules/input/gallery_input/_install.log");
	rmdir("F:\Apache\htdocs\fans\wbg\modules/input/gallery_input/");

} ?>