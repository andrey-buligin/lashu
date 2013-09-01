<?php
    global $_CFG;
	include_once($_CFG['path_to_modules'].'/libraries/baners.class/baners.class.php');
	
	$defBannersCategory = 15;
	$bannersCategory = $defBannersCategory;
	
	if (isset($web->active_tree[2])) {
		switch ($web->active_tree[2]) {
			//case 42: $bannersCategory = 17; break; //dev banners
			//case 43: $bannersCategory = 57; break; //music banners
			//case 44: $bannersCategory = 58; break; //entertainment banners
			default: break;
		}
	}
	$banners = new BANERS('_mod_banners', WBG::mirror( $bannersCategory ));
	$bannersOutput = $banners->getBaners( true, 4);
	if ( $bannersOutput )
	{
		$blockTitle = mysql_result(mysql_query("SELECT title FROM wbg_tree_categories WHERE id=".$bannersCategory),0 , 0);
		echo '<div id="left-banners" class="block"><h3>'.$blockTitle.'</h3>'.$bannersOutput.'</div>';
	}
?>