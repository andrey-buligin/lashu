<?php
    global $_CFG;
    global $web;
    
    $contentFile = $_CFG['path_to_modules'].'/input/onetext/__saved_data_'.$web->active_category;
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
    			<div id="onetextContent">
    				<div id="aboutMe">
    					<div id="categoryTitle"><h1>'.$data['title'].'</h1></div>
    					'.$img.'
    					<p class="p">'.$data['text'].'<br class="clear"/><br class="clear"/></p>
    				</div>
    			</div>');
    	}
    }
?>
