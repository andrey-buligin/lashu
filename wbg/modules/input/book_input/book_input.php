<?php


include_once($_CFG['path_to_cms'].'core/libraries/wbg_parse_template.class/wbg_parse_template.class.php');

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


function main(){
	global $_CFG;

	if (isSet($_POST['saved_data'])){ // Esli eto bil save dannih , to delajem SAVE
		save_data(@$ERROR);
		if (@$ERROR){
			unset($_GET['saved']);
		} else {
			$message = '<div style="color:green;padding:7px 10px">'.__TXL_SAVED_.'</div>';
		}
	}
	$content = @file_get_contents(dirname(__FILE__).'/__saved_data_'.$_CFG['current_category']['id']);
	$content = @unserialize(stripslashes($content));

	$tpl = new wbg_parse_template ($content);
	//$tpl->url_to = $_CFG['url_to_cms'].'core/libraries/wbg_parse_template.class/';
	$tpl->path_server = $_CFG['path_server'];
	$tpl->with_css = true;

	$header = '<input type="button" value="'._TXL_BTNSAVE_.'" class="button" onclick=window.sendform() style="float:right;">'.(@$message?$message:'<br><br>').'';

	$OUT_form = '<form method="post" action="" id="my-edit-form"  enctype="multipart/form-data">'.(@$ERROR?'<div style="color:red;padding:5px">'.$ERROR.'</div>':'');
	$OUT_form .= $header;
	$OUT_form .= $tpl->make_parsing(file_get_contents(dirname(__FILE__)."/__template.php"));
	$OUT_form .=  '<input type="hidden" name="saved_data" value="1"></form>';
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

function save_data(){
	global $_CFG;
	$tpl = new wbg_parse_template ();
	$tpl->get_elements_before_save(file_get_contents(dirname(__FILE__)."/__template.php"));
	$tpl->path_server = $_CFG['path_server'];
	$tpl->serialize_data = true;
	$save_array = $tpl->get_data_for_save($_POST, $ERROR);

	$filename = dirname(__FILE__).'/__saved_data_'.$_CFG['current_category']['id'];
	$fp = fopen($filename, "w+");
	fputs($fp, stripslashes($save_array));
	fclose($fp);
}

?>