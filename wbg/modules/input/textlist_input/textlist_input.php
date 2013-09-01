<?php

include_once(dirname(__FILE__).'/_translations.php');
include_once(dirname(__FILE__).'/_list_functions.php');
include_once(dirname(__FILE__).'/../../components/tags.php');


function main(){
	global $_CFG;
	
	TEXTLIST::$template 	= dirname(__FILE__).'/__template.php';
	TEXTLIST::$sql_table	= "_mod_textlist";
	TEXTLIST::$set_new_to   = "up";
	
	//--------------------------------------------------------------------------------------
	// <<< Vizov dejstvij s elementami
	
		if (isset($_POST['delete'])){
			TEXTLIST::delete($_POST['chk_el']);
		}
		if (isset($_GET['move'])){
			TEXTLIST::move_item($_GET['dir'], $_GET['move'], $_GET['count']);
			TEXTLIST::$marked_item = $_GET['move'];
		}		
		if (isset($_GET['act'])){
			mysql_query("UPDATE ".TEXTLIST::$sql_table." SET active = IF (active = 1 , 0 , 1) WHERE id=".$_GET['act']);
		}
		if (isset($_GET['saved']) OR isset($_GET['apply'])){
			
//			if (!empty($_POST['_ins_small_images'])) {
//				foreach ($_POST['_ins_small_images'] as $src) {
//					resizeImageTwoTimes($src, 345, 215);
//				}
//			}	
//			if (!empty($_POST['lead_img']['src'])){
//				resizeImageTwoTimes($_POST['lead_img']['src'], 345, 215);
//			}
			if (isset($_POST['ins_title']))	{
				if ($_GET['from'])
				{
					$objId = $_GET['from'];
				} else {
					$objId = 1 + @mysql_result(mysql_query("SELECT id FROM ".TEXTLIST::$sql_table." ORDER BY id DESC LIMIT 1"),0,0);
				}
				$TAGS = new Tags();
				$TAGS->deleteTagsByObjId( TEXTLIST::$sql_table, $objId );
				$TAGS->createTags($_POST['tags'], TEXTLIST::$sql_table, $objId);
				@TEXTLIST::save_document($_GET['from'], $_POST, $_CFG['current_category']['id']);
			}
		}
		
		if (@$_POST['list_action'] == "copy"){
			TEXTLIST::copy_documents($_POST['chk_el'], $_POST['list_value']);
		}
		if (@$_POST['list_action'] == "move"){
			TEXTLIST::move_documents($_POST['chk_el'], $_POST['list_value']);
		}
		
	// >>> Vizov dejstvij s elementami
	//--------------------------------------------------------------------------------------
	
	if (isset($_GET['edit']) OR isset($_GET['apply'])){
		return TEXTLIST::show_form(@$_GET['from'] ? $_GET['from'] : $_GET['edit']);
	} else {
		TEXTLIST::$marked_item = @$_GET['from'];
		$copyMoveButtons = '';
		if (isset($_GET['lang']) OR isset($_GET['from']) OR isset($_GET['saved']) OR isset($_GET['cat'])) {
			$copyMoveButtons = '<script>
								   	$divs = document.getElementsByTagName("div");
								    $divs[1].innerHTML = \'<div class="button"><input type="button" value=" Add object " onclick="_ml_withselect_onclick(0)"></div>\';
								    $divs[1].innerHTML+= \'<div class="button" style="float:right"><input type="submit" style="color:red" value=" Delete objects " name="delete" onclick="return delete_elements(\\\'\\\')"></div>\';
								    $divs[1].innerHTML+= \'<div class="button"><input type="button" value=" Copy objects " name="copy" onclick="open_popup(\\\'/site/wbg/modules/libraries/textlist.class/popup.copy_data.php?id='.$_CFG['current_category']['id'].'\\\', 600, 700)"></div>\';
								    $divs[1].innerHTML+= \'<div class="button"><input type="button" value=" Move objects " name="move" onclick="open_popup(\\\'/site/wbg/modules/libraries/textlist.class/popup.move_data.php?id='.$_CFG['current_category']['id'].'\\\', 600, 700)"></div>\';
								   </script>';
		}
		
		return TEXTLIST::show_list($_CFG['current_category']['id']);
	}
}

//======================================================================================
/**
 * Funkcija resizit image 2 raza 4tob on naxodila vnutri opredelenoi ramki
 *
 * @param string $imageSrc putj faila ot direktorii images
 * @param integer $widthNeeded nuznaja dlina
 * @param integer $heightNeeded nuznaja visota
 */
function resizeImageTwoTimes($imageSrc, $widthNeeded, $heightNeeded){
	global $_CFG;
	
	$big_img_src  = $_CFG['path_server'].'images/'.$imageSrc;
	$big_img_src2 = $_CFG['path_server'].'images/resized/big/'.basename($imageSrc);
	
	$big_image_param = getimagesize($big_img_src);
	list($width, $height, $type, $attr) = $big_image_param;

	if ($width > $widthNeeded) {
		exec("/usr/local/bin/convert ".$big_img_src." -thumbnail ".$widthNeeded."x -quality 95 ".$big_img_src);
	}
	if ($height > $heightNeeded) {
		exec("/usr/local/bin/convert ".$big_img_src." -thumbnail x".$heightNeeded." -quality 95 ".$big_img_src);
	}	
}

class TEXTLIST {
	
	static $template 	= "";	
	static $sql_table 	= "";	
	static $marked_item = "";	
	static $set_new_to 	= "up";	
	
	
	//======================================================================================
	/**
		 * Funkcija pokaza spiska dokumentov v ukazannoj kategorii
		 *
		 * @param integer $category_id
		 */
		function show_list($category_id) {
			global $_CFG;
			include_once ($_CFG['path_to_cms'].'core/libraries/my_list.class/extensions/_with_edit.php');
			include_once ($_CFG['path_to_cms'].'core/libraries/free_filter.class/free_filter.class.php'); 
			
			$free_filter = new free_filter( 'doc_filter' );

            $free_filter->add_element("Owner","owner","select", array( 1=>'Bula', 4=>'Fanich'));
            $free_filter->add_element("Doc ID","id","number");
            $free_filter->add_element("Created","created","datums");
            
            $SQL_string = $free_filter->generate_sql_string();
            $OUT_filter = $free_filter->generate_filter_form();

			$my_list 							= new _with_edit();
			$my_list->sql_table 				= self::$sql_table;
			$my_list->sql_where 				= "category_id=".$category_id.($SQL_string ? ' AND '.$SQL_string : '');
			$my_list->nosort 					= true;
			$my_list->sql_order 				= "sort_id";
			$my_list->sql_direction 			= "0";
			$my_list->unique_id 				= "textlist";
			$my_list->template_table 			= file_get_contents(dirname(__FILE__).'/_list_template_table.tpl');
			$my_list->show_pagelist = 20;
	
			$my_list->style_where["id"]["condition"] = "=='".self::$marked_item."'";
			$my_list->style_where["id"]["insert"] = ' style="background:#ffe8c0"';
			
			$my_list->insert_cell("id","ID", null);
			$my_list->insert_cell("ins_title",	_TXL_TITLE_, 	"_textlist_cut_title", 		"nowrap width='80%'");
			$my_list->insert_cell("content",	"Date / time", "_textlist_show_content",	"width='15%'");
			$my_list->insert_cell("created",	_TXL_CREATED_, 	"_textlist_get_datetime");
			$my_list->insert_cell("owner",		_TXL_OWNER_, 	"_textlist_get_owner");
			$my_list->insert_cell("active",		_TXL_ISACTIVE_, "_textlist_set_active", 	"onclick='' nowrap");
			$my_list->insert_cell("sort_id",	"Sort", 		'_textlist_add_bullets', 	"onclick='' nowrap");
			
			return $OUT_filter.$my_list->show_table();		
		}
		
		function show_list_for_crosslinks($category_id) {
			global $_CFG;
			include_once ($_CFG['path_to_cms'].'core/libraries/my_list.class/extensions/_with_select.php');
			$my_list 							= new _with_select();
			$my_list->sql_table 				= self::$sql_table;
			$my_list->sql_where 				= "category_id=".$category_id;
			$my_list->nosort 					= true;
			$my_list->sql_order 				= "sort_id";
			$my_list->sql_direction 			= "0";

			$my_list->insert_cell("id","ID", null);
			$my_list->insert_cell("ins_title",	_TXL_TITLE_, 	"_textlist_cut_title", 		"nowrap");
			$my_list->insert_cell("content",	"Content", 		"_textlist_show_content",	"width='100%'");
			
			return $my_list->show_table().'
			<script>
				function _ml_withselect_onclick($item_id){
					window.opener.window.crosslink_insert("'.$_GET['field'].'", "'.$_POST['category_id'].'", "doc="+$item_id);
					window.close();
				}
			</script>';	
			
		}		
		
	//======================================================================================
	// [[[ Funkcii otobrazhenija formi	

		/**
		 * Funckija vozvrashajet formu redaktirovanija dokumenta
		 *
		 * @param integer $document_id
		 * @param string $ERROR - esli nuzhno pokazatj chto bila oshibka v forme
		 */
		function show_form($document_id, $ERROR = null) {
			global $_CFG;
			
			// 1. Dlja generacii formi iz shablona mi ispolzujem standartnij insite klass - wbg_parse_template
			include_once($_CFG['path_to_cms'].'core/libraries/wbg_parse_template.class/wbg_parse_template.class.php');
			
			// 2. Poluchajem dannije elementa
			$element_data = mysql_fetch_assoc(mysql_query("SELECT * FROM ".self::$sql_table." WHERE id='".$document_id."'"));
	
			if (isSet($element_data['content'])){ // Redaktirovanije elementa
				$content = unserialize($element_data['content']);
				$element_data['doc_url'] 	= addslashes($element_data['doc_url']);
				$element_data['ins_title'] 	= addslashes($element_data['ins_title']);
			} else {
				$content = array();
				if ($document_id == 0){ // Esli eto dobavlenije novogo elementa
					$element_data['active'] = 1;
					$element_data['doc_url'] = "";
					$element_data['ins_title'] = "";
				}
			}
	
			// 3. Generim shapku dokumenta
			$header ='
			<div style="background:#C6C7C6;">
				<table cellspacing="2" cellpadding="2" border="0" style="color:#FFFFFF">
	            	<tr>
	            		<td>'._TXL_ACTIVE_.'</td>
						<td><input type="hidden" value="" name="ins_active"><input type="checkbox" value="1" name="ins_active" '.($element_data['active']?'checked':'').'></td>
	            	</tr>
	            	<tr>
	            		<td>'._TXL_NOSAUKUMS_.'</td>
						<td style="padding-left:6px">
							<input size="40" type="text" value="'.$element_data['ins_title'].'" name="ins_title" class="default"> ('._TXL_REDZTIKAIINS_.')
						</td>
	            	</tr>
	            	<tr>
	            		<td>URL (if needed)</td>
						<td style="padding-left:6px">
							<input size="40" type="text" value="'.$element_data['doc_url'].'" name="doc_url" class="default">
						</td>
	            	</tr>
	            </table>
			</div>';
	
			// 4. Generim soderzhanije formi
			$tpl 			= new wbg_parse_template ($content);
			$tpl->with_css 	= true;
			$OUT_form 		= '<form method="post" action="" id="my-edit-form"  enctype="multipart/form-data">';
			$OUT_form 		.= ($ERROR ? '<div style="color:red;padding:5px">'.$ERROR.'</div>' : '');
			$OUT_form 		.= 		$header;
			$OUT_form 		.= 		self::_get_buttons();
			$OUT_form 		.= 		$tpl->make_parsing(file_get_contents(self::$template));
			$OUT_form 		.=  	'<input type="hidden" name="saved_data" value="1">';
			$OUT_form 		.= '</form>';
			
			$OUT_form 		.= '
			<script>
				$win_temp = window.document.location.href.split("?");
				function sendform(){
					window.document.getElementById("my-edit-form").action = $win_temp[0]+"?saved&from='.$document_id.'";
					window.document.getElementById("my-edit-form").submit()
				}
				function applyform(){
					window.document.getElementById("my-edit-form").action = $win_temp[0]+"?apply&from='.$document_id.'";
					window.document.getElementById("my-edit-form").submit();
				}
				function cancelform(){
					window.document.location.href=$win_temp[0]+"?from='.$document_id.'"
				}
			</script>';
			
			return $OUT_form;		
		}
		
		
		function _get_buttons($mode = 0){
				return
				'<script>
					function init2(){
						$string  = \'<div class="button"><input type="button" value="   '._TXL_BTNSAVE_.'   " 	onclick=window.frames[0].window.sendform()></div>\';
						$string += \'<div class="button"><input type="button" value="   '._TXL_BTNAPPLY_.'   " 	onclick=window.frames[0].window.applyform()></div>\';
						$string += \'<div class="button"><input type="button" value="   '._TXL_BTNCANCEL_.'   " onclick=window.frames[0].window.cancelform()></div>\';
						window.parent.window.document.getElementById(\'content-footer\').innerHTML = $string;
					}
				</script>
				
				<div style="text-align:right;margin-top:2px; padding-top:5px; padding-bottom:25px">
					<div class="button right"><input type="button" value="  '._TXL_BTNCANCEL_.' " class="button" onclick=cancelform()></div>
					<div class="button right"><input type="button" value="  '._TXL_BTNAPPLY_.'  " class="button" onclick=applyform()></div>
					<div class="button right"><input type="button" value="  '._TXL_BTNSAVE_.'   " class="button" onclick=sendform()></div>
				</div>';
		}
		
	
	// ]]] Funkcii otobrazhenija formi
	//======================================================================================
	// [[[ Dejstvija s dokumentami
	
	
		function save_document($document_id, $POST, $category_id) {
			global $_CFG;
			
			// Dlja sohrananije nuzhno podgruzitj parsetemplate chtobi vse elementi bili bi nomrmalno obrabotani
			// Posle processinga vse dannije ljagut v massiv 
			
			include_once($_CFG['path_to_cms'].'core/libraries/wbg_parse_template.class/wbg_parse_template.class.php');
			$tpl 	= new wbg_parse_template ();
			$tpl->get_elements_before_save(file_get_contents(self::$template));
			$tpl->serialize_data 	= true;
			$save_array 			= $tpl->get_data_for_save($_POST, $ERROR);

			// Teperj gotovim SQL stroku dlja shohranenija dannih
			$sql_string = "
				category_id 	= '".$category_id."',
				ins_title 		= '".$_POST['ins_title']."',
				doc_url 		= '".$_POST['doc_url']."',
				content 		= '".$save_array."',
				active 			= '".($_POST['ins_active']?1:0)."',
				updated			= NOW(),
				owner			= '".$_CFG['user']['id']."'";

	
			if ($document_id == 0 ){ // Dobavlenije novoij zapisi
				$sql_string .= ",created='".time()."'";
				
				if (self::$set_new_to == "up"){
					mysql_query("UPDATE ".self::$sql_table." SET sort_id = sort_id + 1 WHERE category_id = '".$category_id."'");
					$sort_id = 1;
				} else {
					$sort_id = mysql_result(mysql_query("select max(sort_id) from ".self::$sql_table." where category_id = '".$category_id."'"),0,0)+1;
				}
				$sql_string .= ",sort_id='".$sort_id."'";
				
				$language = mysql_result(mysql_query("select language  from wbg_tree_categories where id = '".$category_id."'"),0,0);
				$sql_string .= ",lang='".$language."'";
				
				mysql_query("INSERT INTO ".self::$sql_table." SET ".$sql_string);
				echo mysql_error();
				
				$_GET['from'] = mysql_insert_id();
				
				// Posle sozdanija sohranjajem dannije v log fail
				$module_id = mysql_result(mysql_query("SELECT input_module FROM wbg_tree_categories WHERE id='".$category_id."'"),0,0);
				WBG::save_to_log(1, $_POST['ins_title'], 4, $category_id, $module_id);
				echo mysql_error();
				
			} else {
				
				mysql_query("UPDATE ".self::$sql_table." SET ".$sql_string." WHERE id = '".$document_id."'");
				
				// Posle sozdanija sohranjajem dannije v log fail
				$module_id = mysql_result(mysql_query("SELECT input_module FROM wbg_tree_categories WHERE id=".$_CFG['current_category']['id']),0,0);
				WBG::save_to_log(2, $_POST['ins_title'], 4, $category_id , $module_id);
			}
			
		}
	
		/**
		 * Kopirujet dokumenti iz odnoj kategorii v druguju
		 *
		 * @param array $documents
		 * @param integer $category_id -> Nomer kategorii kuda kopirovatj
		 */
		function copy_documents($documents = array(), $category_id){
			global $_CFG;
			
			$category_data  = mysql_fetch_assoc(mysql_query("SELECT * FROM wbg_tree_categories WHERE id='".$category_id."'"));
			$last_sort_id 	= mysql_result(mysql_query("SELECT max(sort_id) FROM ".self::$sql_table." WHERE category_id='".(int)$category_id."'"),0,0);
			
			foreach ($documents as $value){
				$sql_string = '';
				
				if (self::$set_new_to == "up"){
					mysql_query("UPDATE ".self::$sql_table." SET sort_id = sort_id + 1 WHERE category_id = '".$category_id."'");
					$last_sort_id = 1;
				} else {
					$last_sort_id ++;
				}				
				
				$data = mysql_fetch_assoc(mysql_query("SELECT * FROM ".self::$sql_table." WHERE id='".$value."'"));
				unset($data['id']);

				$data['category_id'] 	= (int)$category_id;
				$data['owner'] 			= $_CFG['user']['id'];
				$data['created'] 		= time();
				$data['sort_id'] 		= $last_sort_id ;
				$data['lang'] 			= $category_data['language'];

				foreach ($data as $key2=>$value2){
					$sql_string[] = $key2."='".mysql_real_escape_string($value2)."'";
				}
				$sql_string = "INSERT INTO ".self::$sql_table." SET ".implode(",",$sql_string);
				mysql_query($sql_string);
				if (mysql_error()){echo "<br>".mysql_error()."<br>FILE:".__FILE__."<br>LINE:".__LINE__."<br>QUERY: ".$sql_string."<br>";}
				
				WBG::save_to_log(5, $data['ins_title'], 4, (int)$_POST['list_value']);
			}			
		}
		
		function move_documents($documents = array(), $category_id) {
			global $_CFG;
			
			$last_sort_id = mysql_result(mysql_query("SELECT max(sort_id) FROM ".self::$sql_table." WHERE category_id='".(int)$category_id."'"),0,0);
			foreach ($documents as $value){
				
				if (self::$set_new_to == "up"){
					mysql_query("UPDATE ".self::$sql_table." SET sort_id = sort_id + 1 WHERE category_id = '".$category_id."'");
					$last_sort_id = 1;
				} else {
					$last_sort_id ++;
				}					
				
				$sql_string = "UPDATE ".self::$sql_table." SET category_id='".(int)$category_id."',sort_id=".($last_sort_id)." WHERE id='".$value."'";
				mysql_query($sql_string);
				if (mysql_error()){echo "<br>".mysql_error()."<br>FILE:".__FILE__."<br>LINE:".__LINE__."<br>QUERY: ".$sql_string."<br>";}

				// Sohranjajem dannije o perenose
				$data = mysql_fetch_assoc(mysql_query("SELECT * FROM ".self::$sql_table." WHERE id='".$value."'"));
				WBG::save_to_log(4, $data['ins_title'], 4, (int)$_POST['list_value']);
			}			
		}
		
	
	/**
	 * Udalenije dokumentov
	 *
	 * @param array $documents
	 * 		$documents[] = 1
	 * 		$documents[] = 122
	 */
	function delete($documents = array()) {
		foreach ($_POST['chk_el'] as $value) {
			// Sohranjajem udalenija v log faile 
			$document = mysql_fetch_assoc(mysql_query("SELECT ins_title FROM ".self::$sql_table." WHERE id='".$value."'"));
			WBG::save_to_log(3, $document['ins_title'], 4);
			mysql_query("DELETE FROM ".self::$sql_table." WHERE id='".$value."'");
		}
	}
	
	/**
	 * Peremeshajet element vverh ili vniz
	 *
	 * @param unknown_type $direction
	 * @param unknown_type $item_to_move
	 * @param unknown_type $actions_count
	 */
	function move_item($direction, $item_to_move, $actions_count = 1) {
		
	    if ($direction){
	        $order = "DESC";
	        $znak  = "<";
	    } else {
	        $order = "ASC";
	        $znak  = ">";
	    }
		
		for ($x = 0; $x < $actions_count; $x++){

			$current_obj 	= mysql_fetch_assoc(mysql_query("SELECT id, sort_id, category_id FROM ".self::$sql_table." WHERE id=".$item_to_move));
		    $SQL_str 		= "SELECT id, sort_id FROM ".self::$sql_table." WHERE sort_id" . $znak . $current_obj['sort_id'] . " AND category_id=".$current_obj['category_id']." ORDER BY sort_id ".$order." LIMIT 1";
		    $other_obj 		= mysql_fetch_assoc(mysql_query($SQL_str));
		    
		    if (!$other_obj) return ;
		    
		    mysql_query("UPDATE ".self::$sql_table." SET sort_id=".$other_obj['sort_id']." 		WHERE id=".$current_obj['id']."");
		    mysql_query("UPDATE ".self::$sql_table." SET sort_id=".$current_obj['sort_id']." 	WHERE id=".$other_obj['id']."");		
		}
	}
	
	
}

?>
