<?php

include_once ($_CFG['path_to_cms'].'/core/libraries/my_list.class/extensions/_with_edit.php');
include_once ($_CFG['path_to_cms'].'/core/libraries/my_edit.class/my_edit.class.php');
include_once( $_CFG['path_to_cms'].'/modules/libraries/portfoliomanager.class/portfoliomanager.php');
include_once(dirname(__FILE__).'/../../components/imgResizes.php');

/*****************************************************************************************/

	function _make_copy_move( $table )
	{
		global $_CFG;
	
		if (!@$_POST['list_action']){
			return;
		}
	
		$module_id 		= @mysql_result(mysql_query("SELECT input_module FROM wbg_tree_categories WHERE id=".$_CFG['current_category']['id']),0,0);
		$language_dest 	= @mysql_result(mysql_query("SELECT language FROM wbg_tree_categories WHERE id='".$_POST['list_value']."'"),0,0);
	
		if ($_POST['list_action'] == 'copy') {
			$last_sort_id = mysql_result(mysql_query("SELECT max(sort_id) FROM ".$table." WHERE category_id=".(int)$_POST['list_value']),0,0);
			foreach ($_POST['chk_el'] as $value){
				$data = mysql_fetch_assoc(mysql_query("SELECT * FROM ".$table." WHERE id=".$value));
				unset($data['id']);
				unset($sql_string);
	
				$data['category_id'] = (int)$_POST['list_value'];
				$data['sort_id'] = ++ $last_sort_id;
	
				foreach ($data as $key2=>$value2){
					$sql_string[] = $key2."='".addslashes($value2)."'";
				}
				$sql_string = "INSERT INTO ".$table." SET ".implode(",",$sql_string);
				mysql_query($sql_string);
	
				if (mysql_error()){echo "<br>".mysql_error()."<br>FILE:".__FILE__."<br>LINE:".__LINE__."<br>QUERY: ".$sql_string."<br>";}
			}
	
		}
		if ($_POST['list_action'] == 'move')
		{
			$last_sort_id = mysql_result(mysql_query("SELECT max(sort_id) FROM ".$table." WHERE category_id=".(int)$_POST['list_value']),0,0);
			foreach ($_POST['chk_el'] as $value){
				$sql_string = "UPDATE ".$table." SET category_id=".(int)$_POST['list_value'].",sort_id=".(++$last_sort_id)." WHERE id=".$value;
				mysql_query($sql_string);
				$data = mysql_fetch_assoc(mysql_query("SELECT * FROM ".$table." WHERE id=".$value));
				if (mysql_error()){echo "<br>".mysql_error()."<br>FILE:".__FILE__."<br>LINE:".__LINE__."<br>QUERY: ".$sql_string."<br>";}
			}
		}
	}

/*****************************************************************************************/
	
function main()
{

	global $_CFG;
	
	$_CFG['portfolioManager'] = new PortfolioManager;
	$ERROR = null;
	$CFG['SQL_TABLE'] = "_mod_portfolio";

	_make_copy_move( $CFG['SQL_TABLE'] );
	
	//--------------------------------------------------------------------------------------
	// [[[ Dvigajem element

		move_element($CFG['SQL_TABLE'], @$_GET['dir'], @$_GET['move']);

	// ]]] Dvigajem element
	//--------------------------------------------------------------------------------------
	// [[[ Aktivirujem / Deaktivirujem element

		if (isset($_GET['act']))
		{
			mysql_query("UPDATE ".$CFG['SQL_TABLE']." SET active = IF (active = 1 , 0 , 1) WHERE id=".$_GET['act']);
			$OBJ = mysql_fetch_assoc(mysql_query("SELECT title_eng FROM ".$CFG['SQL_TABLE']." WHERE id=".$_GET['act']));
			WBG::save_to_log(7, $OBJ['title_eng'], 4, $_CFG['current_category']['id'], $_CFG['current_category']['input_module']);
		}		
		
		if (isset($_GET['latest']))
		{
			mysql_query("UPDATE ".$CFG['SQL_TABLE']." SET is_latest = IF (is_latest = 1 , 0 , 1) WHERE id=".$_GET['latest']);
			$OBJ = mysql_fetch_assoc(mysql_query("SELECT title_eng FROM ".$CFG['SQL_TABLE']." WHERE id=".$_GET['latest']));
			WBG::save_to_log(7, $OBJ['title_eng'], 4, $_CFG['current_category']['id'], $_CFG['current_category']['input_module']);
		}

	// ]]] Aktivirujem / Deaktivirujem element
	//--------------------------------------------------------------------------------------
	// [[[ Udaljajem videlennije elementi

		if (isset($_POST['delete']))
		{
			if (isset($_POST['chk_el'])){
				$SQL_str = "SELECT title FROM ".$CFG['SQL_TABLE']." WHERE id IN (".implode(",",$_POST['chk_el']).")";
				$sql_res = mysql_query($SQL_str);
				while ($arr = @mysql_fetch_assoc($sql_res)) {
					WBG::save_to_log(3, $arr['title_eng'], 4, $_CFG['current_category']['id'], $_CFG['current_category']['input_module']);
				}
				$string = "DELETE FROM ".$CFG['SQL_TABLE']." WHERE id IN (".implode(",",$_POST['chk_el']).")";
				mysql_query($string);
			}
		}

	// ]]] Udaljajem videlennije elementi
	//--------------------------------------------------------------------------------------

	/**
	*  	Sozdajem objekt klassa my_edit esli eto rezhim redaktirovanija elementa.
	* 	A takzhe pri save elementa (save mozhet bitj i pri pokaze lista)
	*/
	if (isSet($_POST['saved_data']) or (isSet($_GET['edit']) and !isSet($_GET['from'])))
	{
		$textlist 					= new my_edit();
		$textlist->sql_table 		= &$CFG['SQL_TABLE'];
		$textlist->template_file 	= dirname(__FILE__).'/__template.php';
		$textlist->autocreate_cells = false;
    }

	//--------------------------------------------------------------------------------------
	// [[[ Sohranjajem dannije

		if (isSet($_POST['saved_data'])) // Esli eto bil save dannih , to delajem SAVE
		{ 
			$_POST['category_id'] = $_CFG['current_category']['id'];
          
            if ($_GET['edit'])
            {
				WBG::save_to_log(2, $_POST['title_eng'], 4, $_CFG['current_category']['id'], $_CFG['current_category']['input_module']);
			}
			else
			{
				$max_sort_id          = mysql_fetch_assoc(mysql_query("SELECT MAX(sort_id) FROM ".$CFG['SQL_TABLE']." where category_id = ".$_CFG['current_category']['id']." "));
				$max_sort_id          = $max_sort_id['MAX(sort_id)']+1; 
	            $_POST['sort_id']     = $max_sort_id;
            	$_POST['active']	  = 1;
            	$_POST['created']	  = time();
				WBG::save_to_log(1, $_POST['title_eng'], 4, $_CFG['current_category']['id'], $_CFG['current_category']['input_module']);
			}
			
		    // Creating resized public images
			if ( !empty( $_POST['image_small']['src'] ) )
			{
			    $currentGallery = $_CFG['portfolioManager']->getCurrentPorfolioGallery();
			    
			    $sizes = $_CFG['portfolioManager']->getSizesArray();
			    $fixedSizes = $_CFG['portfolioManager']->getFixedSizesFlagArray();
			    
				resizePortfolioImages( $_POST['image_small'], $sizes, $fixedSizes );
			}
			
			$textlist->save_data($ERROR);
			if (@$ERROR){
				unset($_GET['saved']);
			}
		}

	// ]]] Sohranjajem dannije
	//--------------------------------------------------------------------------------------

	// Pokazivajem LIST Elementov
	if (!isset($_GET['edit']) or isset($_GET['from']) or isset($_GET['saved']))
	{
		$my_list 				= new _with_edit();
		$my_list->sql_table 	= &$CFG['SQL_TABLE'];
		$my_list->sql_where 	= " category_id=".$_CFG['current_category']['id'];
		$my_list->nosort 		= true;					    // Esili true - to sortirovki po nazhatiju headera v tablice voobshe net.
															// toka zaranee zadannaja v $this->sql_order
		$my_list->sql_order 	= "sort_id";				// Eto sortirovka po umolchaniju
		$my_list->show_pagelist = 10;

		if (isset($_GET['act'])){
			$my_list->style_where["id"]["condition"] = "==".$_GET['act']."";
			$my_list->style_where["id"]["insert"] = " style='background:#ffeac3'";
		} else if (isset($_GET['edit'])){
			$my_list->style_where["id"]["condition"] = "==".$_GET['edit']."";
			$my_list->style_where["id"]["insert"] = " style='background:#ffeac3'";
		} else if (isset($_GET['move'])){
			$my_list->style_where["id"]["condition"] = "==".$_GET['move']."";
			$my_list->style_where["id"]["insert"] = " style='background:#ffeac3'";
		}

		$my_list->insert_cell("id","ID", null);
		$my_list->insert_cell("image_small","Image", "get_foto", "nowrap width='10%'");
		$my_list->insert_cell("title_eng","Title", null, "nowrap width='30%'");
		$my_list->insert_cell("description_eng","Description", "trimText", "nowrap width='55%'");
		$my_list->insert_cell("active","Active", "_textlist_set_active","onclick=''");
		$my_list->insert_cell("sort_id","Sort", 'add_bullets', 'onclick="" nowrap');

		$data = '<script>
				function copy_element($mode){
					$checked = 0;
					$elements = document.getElementsByTagName("input");
					for ($x=0;$x<$elements.length;$x++){
						if ($elements[$x].type=="checkbox" && $elements[$x].name=="chk_el[]"){
							if ($elements[$x].checked == true){
								$checked = 1;
								break;
							}
						}
					}
					if (!$checked){
						alert("Atzimējiet vienu vai vairākus dokumentus");
						return;
					}
	
					if (window.Popup){
						window.Popup.close();
					}
					if ($mode == \'1\') {
						$pop_window = "copy_data";
					} else {
						$pop_window = "move_data";
					}
					window.Popup = window.open("'.$_CFG['url_to_cms'].'modules/libraries/textlist.class/popup."+$pop_window+".php?id="+'.$_CFG['current_category']['id'].',"","scrollbars=yes,width=800px,height=500px,left=100px,top=100px");
				}
				
				function resize_images() {
					window.Popup = window.open("'.$_CFG['url_to_cms'].'modules/input/portfolio_input/popup.resize_images.php?id="+'.$_CFG['current_category']['id'].',"","scrollbars=yes,width=500px,height=300px,left=100px,top=100px");
				}
				
				function multiupload_images() {
					window.Popup = window.open("'.$_CFG['url_to_cms'].'modules/input/portfolio_input/popup.multiupload_images.php?id="+'.$_CFG['current_category']['id'].',"","scrollbars=1,width=680px,height=380px,left=100px,top=100px");
				}
				
			</script>'.
			$my_list->show_table().
		    '<script>
				$divs = document.forms["mainform"].getElementsByTagName("DIV");
				$divs[0].innerHTML = $divs[0].innerHTML+\'<div class="button"><input type="hidden" value="" name="list_action" id="list_action"><input type="hidden" value="" name="list_value" id="list_value">\' +
			    \'<div class="button"><input type="button" value=" Copy objects " name="copy" onclick="copy_element(1)"></div><div class="button"><input type="button" value=" Move objects " name="move"  onclick="copy_element(2)"></div>\' +
				\'<div class="button"><input type="button" value=" Multi-upload images " name="multiupload"  onclick="multiupload_images()"></div>\'+
				\'<div class="button"><input type="button" value=" Resize images " name="resize"  onclick="resize_images()"></div></div>\';
			</script>';
		
        $max_sort_id = mysql_fetch_assoc(mysql_query("SELECT MAX(sort_id) FROM ".$CFG['SQL_TABLE']." where category_id = ".$_CFG['current_category']['id']." "));
        return $data;

	}
	else
	{
		// Pokazivajem Otkritij element
		return $textlist->show_form($_GET['edit'], $ERROR);
	}
}


//====================================================
// [[[ Uzerskije funkcii

	/**
	 * 
	 * Trims text
	 * @param string $text
	 */
	function trimText( $text )
	{
		return mb_substr( $text, 0, 50,'utf-8');
	}
	
	function _textlist_set_active($x, $data)
	{
		$link = @str_replace('&act='.$_GET['act'],'',$_SERVER['REQUEST_URI']);
		return '<input type="checkbox" '.($x?'checked':'').' class="checkbox" onclick="self.location.href=\''.$link.'&act='.$data['id'].'\'">';
	}	
	
	/**
	 * 
	 * Displays thumb photo of uploaded image
	 * @param array $smallImage
	 */
	function get_foto( $smallImage )
	{
		global $_CFG;
		$imgArray = unserialize( $smallImage );
		
		if ( trim($imgArray['src']) )
			return '<span title="'.$imgArray['src'].'"><img src="../../../../images/'.$_CFG['portfolioManager']->getThumbnailUrl( basename($imgArray['src']) ).'" style="width:auto; height:80px" border="0"></span>';
		else
			return '<span title="'.$imgArray['src'].'"><img src="'.$_CFG['url_to_skin'].'images/no.gif" border="0"></span>';
	}

	/**
	 * 
	 * Adds moving bullets
	 * @param integer $sort_id
	 * @param array $full_data
	 */
	function add_bullets($sort_id, $full_data)
	{
	    static $js;
	    global $_CFG;

	    $return =  '<img src="my_list/images/icn-movedown.gif" border="0" onclick="return m_e('.$full_data['id'].',0)"/>';
	    $return .= '<img src="my_list/images/icn-moveup.gif" border="0" onclick="return m_e('.$full_data['id'].',1)"/>';

	    if (!$js){
	           $js =
	        '<script>'.
	            'function m_e($id, $direction){'.
	                'document.location.href="'.$_SERVER['PHP_SELF'].'?id='.$_CFG['current_category']['id'].'&move="+$id+"&dir="+$direction;'.
	                'return false'.
	            '};'.
	        '</script>';
	        $return .= $js;
	    }
	    return $return;
	}

	/**
	 * 
	 * Moves element up and down
	 * @param string $table
	 * @param boolean $direction
	 * @param integer $element_id
	 */
	function move_element($table, $direction, $element_id)
	{
	    if (!$element_id) return;

	    if ($direction){
	        $order = "DESC";
	        $znak = "<";
	    } else {
	        $order = "ASC";
	        $znak = ">";
	    }
	    $current_obj = mysql_fetch_assoc(mysql_query("SELECT id,sort_id,category_id FROM ".$table." WHERE id=".$element_id));
        $SQL_str = "SELECT id,sort_id FROM ".$table." WHERE sort_id" . $znak . $current_obj['sort_id'] . " AND category_id=".$current_obj['category_id']." ORDER BY sort_id ".$order." LIMIT 1";
	    $other_obj = mysql_fetch_assoc(mysql_query($SQL_str));
	    if (!$other_obj) return ;
	    mysql_query("UPDATE ".$table." SET sort_id=".$other_obj['sort_id']." WHERE id=".$current_obj['id']."");
	    mysql_query("UPDATE ".$table." SET sort_id=".$current_obj['sort_id']." WHERE id=".$other_obj['id']."");
	}
	
// ]]] Uzerskije funkcii
//====================================================
?>