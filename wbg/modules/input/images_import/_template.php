<?php 

global $_CFG;

$directories = array();
if ( $handle = opendir( $_CFG['image_import_folder'] ))
{
    while ( false !== ($file = readdir( $handle )) ) {
        if ( ($file != "." && $file != "..") && is_dir( $_CFG['image_import_folder'].'/'.$file) ) {
          $directories[$file] = $file;
        }
    }
    closedir( $handle );
}
$this->content['width']  = $_CFG['image_default_width'];
$this->content['height'] = $_CFG['image_default_height'];

$this->textline("Import your images from specified folder into new article");
$this->select("folder", "Please select folder", $directories );
$this->smalltext("width","Images Width[px]", 10);
$this->smalltext("height","Images Height[px]", 10);

?>
<?php
$this->tr("", '<input type="submit" name="import_data" value="Import" class="button"/>');
?>

