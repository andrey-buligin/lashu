<?php
    global $_CFG;
	include_once( $_CFG['path_to_modules'].'components/url_manager.php');
	
//======================================================================================
// [[[ Konfiguracija

	$CFG['start_level'] 	= 0; // Eto s kakogo urovnja mi nachinajem otrabativatj derevo. 0 - samij pervij
	$CFG['levels_total'] 	= 1; // Eto naskoljko mi uglubimsa v derevo. minimalno 1 urovenj
	
// ]]] Konfiguracija
//======================================================================================
// [[[ Logika

	$root_category = WBG::mirror(3);
	$HTML_out = NAV_Generate_HTML($root_category , $CFG['start_level'], $CFG['levels_total'], false);
	$return_from_module = '<ul class="menu">'.$HTML_out.'</ul>'."\n";

// ]]] Logika
//======================================================================================
// [[[ Funkcii

	function NAV_Generate_HTML($root_category, $start_level, $levels_total = 5, $withSubnavigation = false){
		global $web;
		
		$HTML_out  = '';
		$x		   = 0;
		
		$total 	 = mysql_result(mysql_query("SELECT count(*) FROM wbg_tree_categories WHERE parent_id=".$root_category." AND active=1 AND enabled=1"),0,0);
		$SQL_str = "SELECT * FROM wbg_tree_categories WHERE parent_id=".$root_category." AND active=1 AND enabled=1 ORDER BY sort_id";
		$sql_res = mysql_query($SQL_str);
		
		while ($arr = mysql_fetch_assoc($sql_res)) 
		{
			$x++;
			$NAV_ITEMS[] = $arr;
			if (@$web->active_tree[$start_level+1] == $arr['id'] ) {
				$class = ' class="active"';
			} else {
				$class = ( (WBG::mirror(35) == $arr['id'] AND isset($_GET['wbg_cat']) AND isset( $_GET['obj_id'] )) ? ' class="active"':'');
			}
			
			//if we are currently viewing portoflio module under Portfolio folder
			if ( !($web->category_data[$web->active_category]['output_module'] == 20 AND $root_category == WBG::mirror(8)) ) {
				$link = WBG_HELPER::SmartUrlEncode(WBG::crosslink($arr['id']));
			} else {
				$link = WBG_HELPER::SmartUrlEncode( URL_MANAGER_HELPER::makeUrl( $arr['id']) );
			}
			
			$subNav = '';
			if ( $withSubnavigation )
			{
			    $subNav = '<ul class="menu subNav">'. NAV_Generate_HTML( $arr['id'], $start_level+1 ). '</ul>';
			}
			
			$HTML_out .= '<li'.$class.'><a '.getDebug($arr['id']).' href="'.$link.'">'.$arr['title'].'</a>'.$subNav.'</li>'."\n";
		}
		
		return $HTML_out;
	}

	function getDebug($id){
		global $web;
		
		if ($web->debug_mode){
			$DEBUG = ' debug_function="DEBUG_Open_Cat_Props('.$id.')"';
		} else {
			$DEBUG = '';
		}
		return $DEBUG;
	}
	
// ]]] Funkcii
//======================================================================================

?>