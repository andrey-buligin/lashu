<?php

include_once($_CFG['path_to_cms'].'core/libraries/wbg_parse_template.class/wbg_parse_template.class.php');
include_once($_CFG['path_to_cms'].'modules/libraries/portfoliomanager.class/portfoliomanager.php');

if ($_CFG['user']['interface_language']==1){
	define("_TXL_BTNSAVE_", "Saglabāt");
	define("__TXL_SAVED_", "Saglabāts. Time: ".date('H:i:s'));
} else if ($_CFG['user']['interface_language']==0) {
	define("_TXL_BTNSAVE_", "Сохранить");
	define("__TXL_SAVED_", "Сохранeн. Time: ".date('H:i:s'));
} else {
	define("_TXL_BTNSAVE_", "Save");
	define("__TXL_SAVED_", "Saved. Time: ".date('H:i:s'));
}

function main(){
	global $_CFG;
	
	$_CFG['portfolioManager'] = new PortfolioManager( $_CFG['portfolio_folder_id'] );
	if (isSet($_POST['saved_data'])){ // Esli eto bil save dannih , to delajem SAVE
		save_data(@$ERROR);
		if (@$ERROR OR mysql_error()){
			unset($_GET['saved']);
			$message = '<div style="color:green;padding:7px 10px">Error occured: '.mysql_error().'</div>';
		} else {
			$message = '<div style="color:green;padding:7px 10px">'.__TXL_SAVED_.'</div>';
		}
	}
	if ( !isSet( $_GET['edit'] ) )
	{
		$configId = 1;
	} else {
		$configId = $_GET['edit'];
	}
	$query   = "SELECT * FROM _mod_website_config WHERE id = $configId";
	$content = @mysql_fetch_assoc(mysql_query( $query ));
	
	$tpl = new wbg_parse_template ($content);
	//$tpl->url_to = $_CFG['url_to_cms'].'core/libraries/wbg_parse_template.class/';
	$tpl->path_server = $_CFG['path_server'];
	$tpl->with_css = true;
	
	$header = '<input type="button" value="'._TXL_BTNSAVE_.'" class="button" onclick=window.sendform() style="float:right;">'.(@$message?$message:'<br><br>').'';
	
	$OUT_form = '<form method="post" action="" id="my-edit-form"  enctype="multipart/form-data">'.(@$ERROR?'<div style="color:red;padding:5px">'.$ERROR.'</div>':'');
	$OUT_form .= $header;
	$OUT_form .= $tpl->make_parsing(file_get_contents(dirname(__FILE__)."/_template.php"));
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
	
	if ( !isSet( $_GET['edit'] ) )
	{
		$configId = 1;
	} else {
		$configId = $_GET['edit'];
	}
	
	$tpl = new wbg_parse_template();
	$tpl->get_elements_before_save( null );
	$tpl->path_server = $_CFG['path_server'];
	$tpl->serialize_data = false;
	$insertFields = $tpl->get_data_for_save($_POST, $ERROR);
	if ( !isset($insertFields['blocks_left'])) $insertFields['blocks_left'] = '';
	if ( !isset($insertFields['blocks_right'])) $insertFields['blocks_right'] = '';
	unset( $insertFields['saved_data'] );
	foreach ($insertFields as $name => $val) {
		if (is_array( $val )) $val = serialize( $val );
		$insertFields[$name] = $name . " = '" . mysql_escape_string( trim( $val ) ). "'";
	}
	if ( !@mysql_result(mysql_query("SELECT id FROM _mod_website_config WHERE id = $configId"), 0, 0) ) {
		$query = "INSERT INTO _mod_website_config SET ".implode(',', $insertFields).", id = $configId";
	} else {
		$query = "UPDATE _mod_website_config SET ".implode(',', $insertFields)." WHERE id = $configId";
	}
	//echo $query;
	mysql_query( $query );
}

?>