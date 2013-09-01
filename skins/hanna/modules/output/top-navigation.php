<?php
    global $_CFG;
	include_once( $_CFG['path_to_modules'].'components/url_manager.php');

//======================================================================================
// [[[ Konfiguracija

	$CFG['start_level'] 	= 1; // Eto s kakogo urovnja mi nachinajem otrabativatj derevo. 0 - samij pervij
	$CFG['levels_total'] 	= 3; // Eto naskoljko mi uglubimsa v derevo. minimalno 1 urovenj

// ]]] Konfiguracija
//======================================================================================
// [[[ Logika

	$root_category = WBG::mirror(3);

	$HTML_out = NAV_Generate_HTML($root_category , $CFG['start_level'], $CFG['levels_total'], true);
	$return_from_module = '<ul class="menu level-1">'.$HTML_out.'</ul>'."\n";

// ]]] Logika
//======================================================================================
// [[[ Funkcii

	function NAV_Generate_HTML($root_category, $start_level, $levels_total = 5, $withSubnavigation = false){
		global $_CFG;
		global $web;

		$HTML_out  = '';
		$UrlManager = new UrlManager();

		$total 	 = mysql_result(mysql_query("SELECT count(*) FROM wbg_tree_categories WHERE parent_id=".$root_category." AND active=1 AND enabled=1"),0,0);
		$SQL_str = "SELECT * FROM wbg_tree_categories WHERE parent_id=".$root_category." AND active=1 AND enabled=1 ORDER BY sort_id";
		$sql_res = mysql_query($SQL_str);

		while ($arr = mysql_fetch_assoc($sql_res))
		{
			$class = array();
			$subNav = '';

			if (@$web->active_tree[$start_level] == $arr['id'] ) {
				$class[] = 'active';
			}

			// checking if input is portfolioModule then url to category should be SEO friendly
			if ( ($arr['input_module'] != $_CFG['portfolio_input_module_id']) ) {
				$link = WBG_HELPER::SmartUrlEncode( WBG::crosslink($arr['id']) );
			} else {
				$link = $UrlManager->getWbgCategoryUrl( $arr['id'] );
			}

			if ( $withSubnavigation ) {

			    // checking if current category "map to portfolio gallery".
    			if ( ($arr['output_template'] == 0) AND ($arr['input_module'] == 0) AND ($arr['output_module'] == $_CFG['portfolio_output_module_id']) ) {
    			     $subNavRootId = $_CFG['portfolio_folder_id'];
    			     $link = $UrlManager->getWbgCategoryUrl( $subNavRootId );
    			} else {
    			     $subNavRootId = $arr['id'];
    			}

			    if ( $subNav = NAV_Generate_HTML( $subNavRootId, ($start_level+1), $levels_total, true ) ) {
    			    $class[] = 'has-subnav';
    			    $subNav = '<ul class="menu level-'.($start_level+1).'">'.$subNav.'</ul>';
			    }
			}

			$HTML_out .= '<li class="'.implode(" ", $class).'"><a '.getDebug($arr['id']).' href="'.$link.'">'.$arr['title'].'</a>'.$subNav.'</li>'."\n";
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