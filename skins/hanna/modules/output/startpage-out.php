<?php

	include_once(dirname(__FILE__).'/../libraries/portfolio.class/portfolio.class.php');

	$output = '';
	$imageCategories  = array();
	$portfolioManager = new PortfolioManager( $_CFG['portfolio_folder_id'] );
	$portfolioCategories = $portfolioManager->getPartfolioCategories();

	$data = @unserialize(file_get_contents(dirname(__FILE__).'/../input/startpage_fading_images/__saved_data_'.$web->active_category));
	$rand_keys = array_keys($portfolioCategories);
	shuffle( $rand_keys );

    foreach ( $rand_keys as $catId) {
        $catSelected = 'images_'.$catId;
        $sql = 'SELECT id from wbg_tree_categories
					  WHERE active = 1 AND
					  		enabled = 1 AND
					  		id = '.$catId;
	    $categoryIsActive = @mysql_result( mysql_query($sql), 0, 0);
	    if ( !$output AND $categoryIsActive AND @is_array( $data[$catSelected]['small'] ) )
	    {
	       foreach ( $data[$catSelected]['small'] as $key => $image)
	       {
	       	   if ( file_exists( $_CFG['path_server'].'images/startpage/small/'.basename($image) ) ) {
	       	   	  $imgSrc = 'images/startpage/small/'.basename($image);
	       	   } else {
	       	   	  $imgSrc = 'images/'.$image;
	       	   }
	           $output .= '<li><img alt="'.$data[$catSelected]['apraksts'][$key].'" title="'.$data[$catSelected]['apraksts'][$key].'" src="'.$imgSrc.'" /></li>';
	       }
	       $output = '<ul id="fade" class="innerfade">'.$output.'</ul>';
	    }

    }

	//OUTPUT
	$return_from_module = '<div id="innerFadeContainer">'.$output.'</div>';
?>
<script type="text/javascript" src="js/plugins/innerFade.js"></script>