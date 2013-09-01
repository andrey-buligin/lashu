<?php

/**************************************************************/
//settings

	global $web;
	$prodCat 	= WBG::mirror(13);
	$prodCatSite= WBG::mirror(11);
	$projCat 	= WBG::mirror(14);
	$projCatSite= WBG::mirror(8);
	$site_tree 	= WBG::mirror(3);
	$catTitle 	= mysql_result(mysql_query("SELECT title FROM wbg_tree_categories WHERE id=".$web->active_category),0,0);

//settings
/**************************************************************/
// [[[ getting tree from db

	$sql_res = mysql_query("SELECT * FROM wbg_tree_categories WHERE active=1 AND enabled=1 order by sort_id");
	while ($arr = mysql_fetch_assoc($sql_res)){
		$categories[$arr['parent_id']][$arr['id']] = $arr;
	}
	
	changeParent($prodCat, $prodCatSite, $categories);
	changeParent($projCat, $projCatSite, $categories);
	
	echo '<div class="sitemap">'.get_sitetree($categories, $site_tree, 0).'</div><br/>';

// ]]] getting tree from db
/**************************************************************/
// [[[ recursive sitemap generation
	
	function get_sitetree(&$massiv, $start, $level){
		global $web;
		
		$list 	= '';
		$class 	= '';
		if (!isset($massiv[$start])) return;
		
		if ($level == 1) {
			$class 	= 'sub';
		} elseif ($level == 2) {
			$class = 'subsub';
		}
		
		foreach($massiv[$start] as $key=>$value){
			$list .= '<a class="'.$class.'" href="'.SmartUrlEncode(WBG::crosslink($value)).'">'.$value['title'].'</a>';
			$list .= get_sitetree($massiv, $key, $level+1);
	    }
	    
		return $list;
	}
	
// ]]] recursive sitemap generation
/**************************************************************/
	
	function changeParent($curParent, $newParent, &$arr){
		
		if (isset($arr[$curParent])){
			$arr[$newParent] = $arr[$curParent];
			unset($arr[$curParent]);
		}
	}
?>