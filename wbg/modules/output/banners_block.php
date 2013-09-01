<?php
	include_once(dirname(__FILE__).'/../libraries/baners.class/baners.class.php');
	
	$defBannersCategory = 59;
	$bannersCategory = $defBannersCategory;
	
	if (@$web->active_tree[1] == WBG::mirror(41)) {
		$bannersCategory = 17;//dev
	}
	if (isset($web->active_tree[2])) {
		switch ($web->active_tree[2]) {
			case 42: $bannersCategory = 17; break; //dev banners
			case 43: $bannersCategory = 57; break; //music banners
			case 44: $bannersCategory = 58; break; //entertainment banners
			default: break;
		}
	}
	$banners = new BANERS('_mod_banners', WBG::mirror( $bannersCategory ));
	$bannersOutput = $banners->getBaners( true, 4);
	if ( $bannersOutput )
	{
		$blockTitle = mysql_result(mysql_query("SELECT title FROM wbg_tree_categories WHERE id=".$bannersCategory),0 , 0);
		$return_from_module = '<div id="left-banners" class="block"><h3>'.$blockTitle.'</h3>'.$bannersOutput.'</div>';
	}
?>
