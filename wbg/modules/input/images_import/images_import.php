<?php

include_once($_CFG['path_to_cms'].'core/libraries/wbg_parse_template.class/wbg_parse_template.class.php');
include_once($_CFG['path_to_cms'].'modules/components/imgResizes.php');

if ($_CFG['user']['interface_language']==1){
	define("_TXL_BTNSAVE_", "Saglabāt");
	define("__TXL_SAVED_", "Saglabāts. Time: ".date('H:i:s'));
} else if ($_CFG['user']['interface_language']==2) {
	define("_TXL_BTNSAVE_", "Сохранить");
	define("__TXL_SAVED_", "Сохранeн. Time: ".date('H:i:s'));
} else {
	define("_TXL_BTNSAVE_", "Save");
	define("__TXL_SAVED_", "Saved. Time: ".date('H:i:s'));
}

//TODO
// Add to DB record which folders have been imported, to which articles added etc.

function main(){
	global $_CFG;
	
	if (isSet($_POST['import_data'])){ // Esli eto bil save dannih , to delajem SAVE
		$ERROR = import_data( $_POST['folder'] );
		if (@$ERROR){
			unset($_GET['saved']);
		} else {
			$message = '<div style="color:green;padding:7px 10px">'.__TXL_SAVED_.'</div>';
		}
	}
	
	$tpl = new wbg_parse_template();
	//$tpl->url_to = $_CFG['url_to_cms'].'core/libraries/wbg_parse_template.class/';
	$tpl->path_server = $_CFG['path_server'];
	$tpl->with_css = true;
	
	$header = '<input type="button" value="'._TXL_BTNSAVE_.'" class="button" onclick=window.sendform() style="float:right;">'.(@$message?$message:'<br><br>').'';
	
	$OUT_form = '<form method="post" action="" id="my-edit-form"  enctype="multipart/form-data">'.(@$ERROR?'<div style="color:red;padding:5px">'.$ERROR.'</div>':'');
	$OUT_form .= $header;
	$OUT_form .= $tpl->make_parsing(file_get_contents(dirname(__FILE__)."/_template.php"));
	$OUT_form .=  '<input type="hidden" name="import_data" value="1"></form>';
	$OUT_form .= '
	<script>
		$win_temp = window.document.location.href.split("?");
		function sendform(){
			window.document.getElementById("my-edit-form").action = $win_temp[0]+"?saved";
			window.document.getElementById("my-edit-form").submit()
		}
	</script>
	<script>
		function init2(){
			$string = \'<input type="button" value="'._TXL_BTNSAVE_.'" class="button" onclick=window.frames[1].window.sendform()> \';
			window.parent.window.document.getElementById(\'work-area-save\').innerHTML = $string;
		}
	</script>';	
	
	return $OUT_form;
}

function import_data( $folder = 'tmp'){
	global $_CFG;	
	$images = array();
	
	$imgWidth  = $_CFG['image_default_width'];
	$imgHeight = $_CFG['image_default_height'];
	
	if (is_numeric( $_POST['width'] )) $imgWidth = $_POST['width'];
	if (is_numeric( $_POST['height'] )) $imgHeight = $_POST['height'];
	
    if ($handle = opendir( $_CFG['image_import_folder'].'/'.$folder )) {
        while (false !== ($file = readdir( $handle ))) {
            if ($file != "." && $file != "..") {
                echo "Converting $file<br/>";
                $images[] = '<img src="images/import/'.$folder.'/'.$file.'" alt="'.$file.'" title="" />';
                $imageSrc = $_CFG['image_import_folder'].'/'.$folder.'/'.$file;
                resizeImageTwoTimes($imageSrc, $imgWidth, $imgHeight, 'resizeItself');
            }
        }
        closedir($handle);
        $articleContent = array('title'    => $folder.' images',
                                'date'     => time(),
                                'lead'	   => '',
                                'text'     => implode( '<br/><br/>', $images )
                           );
        addNewArticleWithImages( $folder, addslashes(serialize($articleContent)) );
        return true;
    } else{
        return false;
    }
}

function addNewArticleWithImages( $folder = 'tmp', $imagesContent = '' ) {
    global $_CFG;
    
    $sql_table  = '_mod_textlist';
	$sql_string = "
		category_id= '".$_CFG['image_import_articles_folder']."',
		ins_title 	='Images imported from ".$folder."',
		doc_url 	='',
		content 	='".$imagesContent."',
		active 		='0'";
		
	$sql_string .= ",owner='".$_CFG['user']['id']."'";
	$sql_string .= ",created='".time()."'";
	echo "select max(sort_id) from ".$sql_table." where category_id = '".$_CFG['image_import_articles_folder']."'";
	$sort_id = mysql_result(mysql_query("select max(sort_id) from ".$sql_table." where category_id = '".$_CFG['image_import_articles_folder']."'"),0,0)+1;
	$sql_string .= ",sort_id='".$sort_id."'";
	$language = mysql_result(mysql_query("select language  from wbg_tree_categories where id=".$_CFG['image_import_articles_folder']),0,0);
	$sql_string .= ",lang='".$language."'";
	mysql_query("INSERT INTO ".$sql_table." SET ".$sql_string);
	$_GET['edit'] = mysql_insert_id();
	$module_id = mysql_result(mysql_query("SELECT input_module FROM wbg_tree_categories WHERE id=".$_CFG['image_import_articles_folder']),0,0);
	WBG::save_to_log(1, "Images imported from ".$folder, 4, $_CFG['image_import_articles_folder'], $module_id);
}


?>