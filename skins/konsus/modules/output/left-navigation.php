<?php

//======================================================================================
// [[[ Konfiguracija

    global $_CFG;
    global $web;
	$CFG['start_level'] 	= 1; // Eto s kakogo urovnja mi nachinajem otrabativatj derevo. 0 - samij pervij
	$CFG['levels_total'] 	= 1; // Eto naskoljko mi uglubimsa v derevo. minimalno 1 urovenj
	
	include_once $_CFG['path_to_modules'].'/components/url_manager.php';
	
// ]]] Konfiguracija
//======================================================================================
// [[[ Logika
	
	//pokazivaem navigaciju
	$root_category = $_CFG['portfolio_folder_id'];
	$HTML_out = NAV_Generate_Album_HTML($root_category, $CFG['start_level'], $CFG['levels_total'], true);	
	if ($HTML_out) {
		$return_from_module = '<div id="albumNavContainter"><ul class="menu" id="albumNav">'.$HTML_out.'</ul></div>'."\n";
	}

// ]]] Logika
//======================================================================================

	function NAV_Generate_Album_HTML($root_category, $start_level, $levels_total, $ajaxIframe = false){
		global $_CFG;
		global $web;
		
		$HTML_out  = '';
		$x		   = 0;
		
		$UrlManager = new UrlManager();
		$exclueCats = array( $_CFG['portfolio_folder_id'] );
		
		$total 	 = mysql_result(mysql_query("SELECT count(*) FROM wbg_tree_categories WHERE parent_id=".$root_category." AND id not IN(".implode(", ", $exclueCats).") AND active=1 AND enabled=1"),0,0);
		$SQL_str = "SELECT * FROM wbg_tree_categories WHERE parent_id=".$root_category." AND id not IN(".implode(", ", $exclueCats).") AND active=1 AND enabled=1 ORDER BY sort_id";
		$sql_res = mysql_query($SQL_str);
		$hrefAdd = ($ajaxIframe?'?iframe=1':''); 
		$noBGcats= array(1, WBG::mirror(10));

		while ( $arr = mysql_fetch_assoc($sql_res) )
		{
			$x++;
			$NAV_ITEMS[] = $arr;
			$class 	  = (@$web->active_tree[1] == $arr['id'] ? ' class="act"':'');
			$link 	  = $UrlManager->getWbgCategoryUrl( $arr['id'] );
			$HTML_out .= '<li'.$class.'><a '.getDebug($arr['id']).' href="'.$link.'">'.strtoupper( $arr['title'] ).'</a></li>'."\n";
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
?>