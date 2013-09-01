<?php

include_once ($_CFG['path_to_cms'].'core/libraries/my_list.class/extensions/_with_edit.php');
include_once ($_CFG['path_to_cms'].'/core/libraries/my_edit.class/my_edit.class.php');
include_once ($_CFG['path_to_cms'].'core/libraries/free_filter.class/free_filter.class.php');


function main(){
	global $_CFG;
	$CFG['SQL_TABLE'] = "_mod_options";
	$ERROR = '';

	//--------------------------------------------------------------------------------------
	// [[[ Dvigajem element

		move_element($CFG['SQL_TABLE'], @$_GET['dir'], @$_GET['move']);

	// ]]] Dvigajem element
	//--------------------------------------------------------------------------------------
	// [[[ Aktivirujem / Deaktivirujem element

		if (isset($_GET['act'])){
			mysql_query("UPDATE ".$CFG['SQL_TABLE']." SET active = IF (active = 1 , 0 , 1) WHERE id=".$_GET['act']);
		}

	// ]]] Aktivirujem / Deaktivirujem element
	//======================================================================================
	// [[[ Udalenije objektov

		if (isset($_POST['delete'])){
			$SQL_str = "DELETE FROM ".$CFG['SQL_TABLE']."  WHERE ID IN (".implode(',',$_POST['chk_el']).")";
			mysql_query($SQL_str);
		}

	// ]]] Udalenije objektov
	//======================================================================================
	
	/**
	*  	Sozdajem objekt klassa my_edit esli eto rezhim redaktirovanija elementa.
	* 	A takzhe pri save elementa (save mozhet bitj i pri pokaze lista)
	*/
	if (isSet($_POST['saved_data']) or (isSet($_GET['edit']) and !isSet($_GET['from']))){
		$textlist = new my_edit();
		$textlist->sql_table = &$CFG['SQL_TABLE'];
		$textlist->template_file = dirname(__FILE__).'/__template.php';
		$textlist->path_server = $_CFG['path_server'];
		$textlist->autocreate_cells = false;
	}
	
	// =============================================================================================
	// [[[ Sohranjajem dannije esli nado
	
		if (isSet($_POST['saved_data'])){ // Esli eto bil save dannih , to delajem SAVE
			$textlist->add_on_save("category_id",$_CFG['current_category']['id']);
			if ($_GET['edit'] == 0){
				$max_sort_id      = mysql_fetch_assoc(mysql_query("SELECT MAX(sort_id) FROM ".$CFG['SQL_TABLE']." where category_id = ".$_CFG['current_category']['id']." "));
				$max_sort_id      = $max_sort_id['MAX(sort_id)']+1; 
	            $_POST['sort_id'] = $max_sort_id;
			}
			$textlist->save_data($ERROR);
			if (@$ERROR){
				unset($_GET['saved']);
			}
		}

	// ]]] Sohranjajem dannije esli nado
	// =============================================================================================	
	
	if (!isset($_GET['edit']) or isset($_GET['from']) or isset($_GET['saved'])){ 
		
//		$free_filter = new free_filter("product_parametr");
//		$free_filter->add_element("ID","id","number");
//		$groups = getGroups();
//		$free_filter->add_element("Group","group_id","select", $groups);
//		
//		$SQL_string = $free_filter->generate_sql_string();
//		$OUT_filter = $free_filter->generate_filter_form();
		$SQL_string = '';
		$OUT_filter = '';
		
		$my_list = new _with_edit();
		$my_list->sql_table = $CFG['SQL_TABLE'];
		$my_list->sql_where = $SQL_string ? $SQL_string : "category_id = ".$_CFG['current_category']['id'];
		$my_list->sql_order = "sort_id";
		$my_list->nosort = false;
		$my_list->unique_id = "product_parametr";
		
		$my_list->insert_cell("id","ID", null, "width=1%");
		$my_list->insert_cell("title_lat","title lat", null, "width='25%'");
		$my_list->insert_cell("title_eng","title eng", null, "width='25%'");
		$my_list->insert_cell("title_rus","title rus", null, "width='25%'");
		$my_list->insert_cell("active","active", "_textlist_set_active","onclick=''");
		$my_list->insert_cell("sort_id","Sort", 'add_bullets', 'onclick="" nowrap');
		

		if (isset($_GET['edit'])){
			$my_list->style_by_id[$_GET['edit']] = " style='background:#fdecce'";
		}

		$html = '<table style="background:#E7E7E7;margin-top:1px;width:100%; margin-bottom:7px"><tr><td style="padding:6px 0px 10px 0px">'.$OUT_filter.'</td></tr></table>'.$my_list->show_table();
		return $html;
		
	} else {
		
		return $textlist->show_form($_GET['edit'], $ERROR);
		
	}
}

//====================================================
// [[[ Uzerskije funkcii

	/**
	 * Tut funkcii kotorije vizivajutsa iz my_list i definirujutsa v objevlenii jachejki
	 * v funkcii show_in_table
	 */
	
	function getGroups(){
		$sql_res = mysql_query("SELECT * FROM _mod_product_parametr_groups WHERE active=1 ORDER BY title_eng");
		while ($arr = mysql_fetch_assoc($sql_res)) {
			$groups[$arr['id']] = $arr['title_eng'];
		}
		return $groups;
	}
	
	function getGroup($x){
		static $groups;
		if (!$groups) $groups = getGroups();
		if (isset($groups[$x])){
			return $groups[$x];
		} else {
			return 'No group';
		}
	}

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