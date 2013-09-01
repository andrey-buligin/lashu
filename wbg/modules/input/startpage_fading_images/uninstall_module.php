<?php function make_uninstall(){ 
mysql_query("DELETE FROM ins_modules WHERE id='5'");
unlink("/usr/local/www/sites/projects_andrej/nlcc/in_site/modules/input/home_page/home_page.php");
unlink("/usr/local/www/sites/projects_andrej/nlcc/in_site/modules/input/home_page/_template.php");

    function deldir($dir) {
       $dh=opendir($dir);
       while ($file=readdir($dh)) {
           if($file!="." && $file!="..") {
               $fullpath=$dir."/".$file;
               if(!is_dir($fullpath)) {
                   unlink($fullpath);
               } else {
                   deldir($fullpath);
               }
           }
       }
       closedir($dh);
       if(rmdir($dir)) {
           return true;
       } else {
           return false;
       }
    }
 deldir("/usr/local/www/sites/projects_andrej/nlcc//usr/local/www/sites/projects_andrej/nlcc/in_site/modules/input/home_page");
unlink("/usr/local/www/sites/projects_andrej/nlcc/in_site/modules/input/home_page/uninstall_module.php");
unlink("/usr/local/www/sites/projects_andrej/nlcc/in_site/modules/input/home_page/install.log");
rmdir("/usr/local/www/sites/projects_andrej/nlcc/in_site/modules/input/home_page/");

} ?>