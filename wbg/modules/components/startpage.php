<?php

/**
 * Funkcija generit img s mousoverom dlja startovoi stranici s linkom na konkretnij razdel produktov
 *
 * @param array $id
 */
function getCatImage($id){

	$js   = '';
	$html = '';
	if (is_array($id)) {
		
		$total = count($id);
		$x     = 1;
		foreach ($id as $key => $catId) {
			$props = @mysql_result(mysql_query("SELECT properties FROM wbg_tree_categories WHERE id=".$catId),0,0);
			$props = @unserialize($props);
			if (!empty($props['s_tpage_img'])){
				$html .=  '<a href="'.SmartUrlEncode(WBG::crosslink($catId)).'">'.insertImage($props['s_tpage_img'], ' '.($x++==$total?'class="last"':'').' id="stPageImg'.$catId.'"').'</a>';
				if (!empty($props['s_tpage_img_act'])){
					$js .= " $('#stPageImg".$catId."').imghover({src: 'images/".$props['s_tpage_img_act']['src']."'}); \n";
				}
			}
		}
	} else {
		$props = @mysql_result(mysql_query("SELECT properties FROM wbg_tree_categories WHERE id=".$id),0,0);
		$props = @unserialize($props);
		$html = '<a href="'.SmartUrlEncode(WBG::crosslink($id)).'">'.insertImage($props['s_tpage_img'], 'id="stPageImg'.$id.'"').'</a>';
		$js   = " $('#stPageImg".$arr['id']."').imghover({src: 'images/".$props['s_tpage_img_act']['src']."'}); \n";
	}
	
	if ($js){
		$js = '<script type="text/javascript">
					//<![CDATA[
					'.$js.'
					//]]>
				</script>';
	}
	return $html.$js;
}

/*******************************************************************/

function getLastTextFromCat($catId, $firstImgReversed = false){
	
	$x		 = 1;
	$htmlOut = '';
	$catData = mysql_fetch_assoc(mysql_query("SELECT title,id FROM wbg_tree_categories WHERE id=".$catId));
	
	$total  = mysql_result(mysql_query("SELECT count(*) FROM _mod_aktualitates WHERE show_on_startpage=1 AND category_id=".$catId),0,0);
	$matSql = mysql_query("SELECT * FROM _mod_aktualitates WHERE show_on_startpage=1 AND category_id=".$catId);
	while ($arr = mysql_fetch_assoc($matSql)){
		
		$image 		 = '';
		$imgReversed = '';
		$content = unserialize($arr['content']);
		$link    = WBG_HELPER::SmartUrlEncode(WBG::crosslink($arr['category_id']).'?doc='.$arr['id']);
		if ($content['lead_img']) $image = '<a href="'.$link.'">'.WBG_HELPER::insertImage($content['lead_img']).'</a>';
		if ($firstImgReversed AND !$imgReversed AND $image){
			$imgReversed = '<a href="'.$link.'">'.WBG_HELPER::insertImage($content['lead_img'], 'style="margin-bottom:8px"').'</a>';
			$image = '';
		}
		$htmlOut .= '<div class="stPageNewsBlock'.($x++==$total?' last':'').'">
						<h3>'.$content['title'].'</h3>
						<span>'.$content['lead'].'<a href="'.$link.'">>>></a></span>
						'.$image.'
					</div>';
	}
	if ($htmlOut) 
		return $imgReversed.
				'<a href="'.WBG::crosslink($catData['id']).'" class="stPageBlockTitle">'.WBG::message("nepalaid_garam",null,1).'<span>'.$catData['title'].'</span></a>'.
				$htmlOut;
}
?>