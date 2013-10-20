<?php
    global $_CFG;
    global $web;

    $activeCategory = $web->active_category;
    $activeCategoryData = $web->category_data[$activeCategory];

    $contentFile = $_CFG['path_to_modules'].'/input/onetext/__saved_data_'.$activeCategory;
    if ( file_exists( $contentFile ) )
    {
    	$data = unserialize( file_get_contents( $contentFile ) );
    	if ($data['text'])
    	{
    		$img = '';
    		if (@$data['text_img']) {
    			$img = WBG_HELPER::insertImage($data['text_img'], 'class="ImgFloated"');
    		}

    		$return_from_module = WBG_HELPER::transferToXHTML('
			   <header><h1>'.$data['title'].'</h1></header>
			   '.$img.'
			   <div class="text">'.$data['text'].'</div>');
    	}
    }
?>
