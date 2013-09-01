<?php
	include_once(dirname(__FILE__).'/../libraries/baners.class/baners.class.php');
	
	$defLinksCategory = '';
	$linksCategory = $defLinksCategory;
	
	if (isset($web->active_tree[2])) {
		switch ($web->active_tree[2]) {
			case 42: $linksCategory = ''; break; //dev banners
			case 43: $linksCategory = 61; break; //music banners
			case 44: $linksCategory = 61; break; //entertainment banners
			default: break;
	    }
	}
	
	$data = @unserialize(file_get_contents(dirname(__FILE__).'/../input/onetext/__saved_data_'.$linksCategory));
	if ($data['text'] AND $linksCategory) {
		$return_from_module = WBG_HELPER::transferToXHTML('
			<div id="left-rel-links" class="block"><h3>'.$data['title'].'</h3>
				'.($data['text_img'] ? WBG_HELPER::insertImage($data['text_img'], 'class="f-left"', null, 1) : '').
				$data['text'].'
			</div>');
	}
?>
