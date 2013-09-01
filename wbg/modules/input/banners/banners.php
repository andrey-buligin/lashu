<?php

include_once ($_CFG['path_to_cms'].'/core/libraries/my_list.class/extensions/_with_edit.php');
include_once ($_CFG['path_to_cms'].'/core/libraries/my_edit.class/my_edit.class.php');

function main(){

	global $_CFG;
	$ERROR = null;
	$CFG['SQL_TABLE'] = "_mod_banners";

	//--------------------------------------------------------------------------------------
	// [[[ Dvigajem element

		move_element($CFG['SQL_TABLE'], @$_GET['dir'], @$_GET['move']);

	// ]]] Dvigajem element
	//--------------------------------------------------------------------------------------
	// [[[ Aktivirujem / Deaktivirujem element

		if (isset($_GET['act'])){
			mysql_query("UPDATE ".$CFG['SQL_TABLE']." SET active = IF (active = 1 , 0 , 1) WHERE id=".$_GET['act']);
			$OBJ = mysql_fetch_assoc(mysql_query("SELECT title FROM ".$CFG['SQL_TABLE']." WHERE id=".$_GET['act']));
			WBG::save_to_log(7, $OBJ['title'], 4, $_CFG['current_category']['id'], $_CFG['current_category']['input_module']);
		}

	// ]]] Aktivirujem / Deaktivirujem element
	//--------------------------------------------------------------------------------------
	// [[[ Udaljajem videlennije elementi

		if (isset($_POST['delete'])){
			if (isset($_POST['chk_el'])){
				$SQL_str = "SELECT title FROM ".$CFG['SQL_TABLE']." WHERE id IN (".implode(",",$_POST['chk_el']).")";
				$sql_res = mysql_query($SQL_str);
				while ($arr = mysql_fetch_assoc($sql_res)) {
					WBG::save_to_log(3, $arr['title'], 4, $_CFG['current_category']['id'], $_CFG['current_category']['input_module']);
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
	if (isSet($_POST['saved_data']) or (isSet($_GET['edit']) and !isSet($_GET['from']))){
		$textlist 					= new my_edit();
		$textlist->sql_table 		= &$CFG['SQL_TABLE'];
		$textlist->template_file 	= dirname(__FILE__).'/__template.php';
		$textlist->autocreate_cells = false;
    }

	//--------------------------------------------------------------------------------------
	// [[[ Sohranjajem dannije

		if (isSet($_POST['saved_data'])){ // Esli eto bil save dannih , to delajem SAVE
			$_POST['category_id'] = $_CFG['current_category']['id'];
            $max_sort_id          = mysql_fetch_assoc(mysql_query("SELECT MAX(sort_id) FROM ".$CFG['SQL_TABLE']." where category_id = ".$_CFG['current_category']['id']." "));
			$max_sort_id          = $max_sort_id['MAX(sort_id)']+1; 
            $_POST['sort_id']     = $max_sort_id;
            if ($_GET['edit']){
				WBG::save_to_log(2, $_POST['title'], 4, $_CFG['current_category']['id'], $_CFG['current_category']['input_module']);
			} else {
				WBG::save_to_log(1, $_POST['title'], 4, $_CFG['current_category']['id'], $_CFG['current_category']['input_module']);
			}

			$textlist->save_data($ERROR);
			if (@$ERROR){
				unset($_GET['saved']);
			}
		}

	// ]]] Sohranjajem dannije
	//--------------------------------------------------------------------------------------

	if (!isset($_GET['edit']) or isset($_GET['from']) or isset($_GET['saved'])){

		// =============================================================================================
		// [[[ Pokazivajem LIST Elementov

			$my_list 				= new _with_edit();
			$my_list->sql_table 	= &$CFG['SQL_TABLE'];
			$my_list->sql_where 	= " category_id=".$_CFG['current_category']['id'];
			$my_list->nosort 		= true;					    // Esili true - to sortirovki po nazhatiju headera v tablice voobshe net.
																// toka zaranee zadannaja v $this->sql_order
			$my_list->sql_order 	= "sort_id";				// Eto sortirovka po umolchaniju

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
			$my_list->insert_cell("title","Title", null, "nowrap width='30%'");
			$my_list->insert_cell("foto","Image", "get_foto", "nowrap width='30%'");
			$my_list->insert_cell("link","Link", null, "nowrap width='30%'");
			$my_list->insert_cell("active","active", "_textlist_set_active","onclick=''");
			$my_list->insert_cell("sort_id","Sort", 'add_bullets', 'onclick="" nowrap');
            $my_list->insert_cell("counter","displayed", null, 'onclick="" nowrap');

			$data = $my_list->show_table();
            $max_sort_id          = mysql_fetch_assoc(mysql_query("SELECT MAX(sort_id) FROM ".$CFG['SQL_TABLE']." where category_id = ".$_CFG['current_category']['id']." "));
            return $data;

		// ]]] Pokazivajem LIST Elementov
		// =============================================================================================

	} else {

		// =============================================================================================
		// [[[ Pokazivajem Otkritij element

			return $textlist->show_form($_GET['edit'], $ERROR);

		// ]]] Pokazivajem Otkritij element
		// =============================================================================================
	}
}


//====================================================
// [[[ Uzerskije funkcii

	/**
	 * Tut funkcii kotorije vizivajutsa iz my_list i definirujutsa v objevlenii jachejki
	 * v funkcii show_in_table
	 */

	function _textlist_set_active($x, $data){
		$link = @str_replace('&act='.$_GET['act'],'',$_SERVER['REQUEST_URI']);
		return '<input type="checkbox" '.($x?'checked':'').' class="checkbox" onclick="self.location.href=\''.$link.'&act='.$data['id'].'\'">';

	}

	function get_foto($x, $data){
		global $_CFG;
		$dannije = unserialize($data['foto']);
		if(trim($dannije['src'])){
			return '<span title="'.$dannije['src'].'"><img src="'.$_CFG['url_to_skin'].'images/yes.gif" border="0"></span>';
		} else {
			return '<span title="'.$dannije['src'].'"><img src="'.$_CFG['url_to_skin'].'images/no.gif" border="0"></span>';
		}
	}

	function add_bullets($sort_id, $full_data){
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

	function move_element($table, $direction, $element_id){
	    if (!$element_id) return;

	    if ($direction){
	        $order = "DESC";
	        $znak = "<";
	    } else {
	        $order = "ASC";
	        $znak = ">";
	    }
	    $current_obj = mysql_fetch_assoc(mysql_query("SELECT id,sort_id FROM ".$table." WHERE id=".$element_id));
        $SQL_str = "SELECT id,sort_id FROM ".$table." WHERE sort_id" . $znak . $current_obj['sort_id'] . " ORDER BY sort_id ".$order." LIMIT 1";
	    $other_obj = mysql_fetch_assoc(mysql_query($SQL_str));
	    if (!$other_obj) return ;
	    mysql_query("UPDATE ".$table." SET sort_id=".$other_obj['sort_id']." WHERE id=".$current_obj['id']."");
	    mysql_query("UPDATE ".$table." SET sort_id=".$current_obj['sort_id']." WHERE id=".$other_obj['id']."");
	}

// ]]] Uzerskije funkcii
//====================================================
?>