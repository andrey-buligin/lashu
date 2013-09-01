<?php

    global $_CFG;
    global $web;
    
    $contentFile = $_CFG['path_to_modules'].'/input/onetext/__saved_data_'.$web->active_category;

    if ( file_exists( $contentFile ) )
    {
        $data = @unserialize( file_get_contents( $contentFile ) );
    	if ( $data['text'])
    	{
    		$return_from_module = WBG_HELPER::transferToXHTML('
    			<h1 class="page-title">'.WBG_HELPER::insertCatTitle().'</h1>
    			<div class="page-text clear-block">
    				'.($data['title'] ? '<h2>'.$data['title'].'</h2>': '').'
    				'.($data['text_img'] ? WBG_HELPER::insertImage($data['text_img'], 'class="f-left"', null, 1) : '').
    				$data['text'].'
    			</div>');
    	}
    }
?>
