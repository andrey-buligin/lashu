<?php

	global $_CFG;

	include_once($_CFG['path_to_modules'].'libraries/portfoliomanager.class/portfoliomanager.php');

	$output = '';
	$imageCategories  = array();
	$portfolioManager = new PortfolioManager( $_CFG['portfolio_folder_id'] );
	$portfolioCategories = $portfolioManager->getPartfolioCategories();

	$data = @unserialize(file_get_contents($_CFG['path_to_modules'].'/input/startpage_fading_images/__saved_data_'.$web->active_tree[0]));
	$rand_keys = array_keys($portfolioCategories);
	//shuffle( $rand_keys );

    foreach ($rand_keys as $catId) {
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
	           $output .= 'homeSliderImages.push({thumb: "", url: "", image: "'.$imgSrc.'",
							title: "<div class=\'slide-content\'>'.$data[$catSelected]['apraksts'][$key].'</div>"});'."\n";
	       }
	    }

    }

	//OUTPUT
	//$return_from_module = '';
?>

<!-- Homepage Slider -->
<div id="home-slider">	
    <div class="overlay"></div>

	<div class="container">
    	<div class="row">
        	<div class="span12">
                <div class="slider-text">
                    <div id="slidecaption"></div>
                </div>
            </div>
        </div>
    </div>   
	
	<div class="control-nav">
        <a id="prevslide" class="load-item"><i class="font-icon-arrow-simple-left"></i></a>
        <a id="nextslide" class="load-item"><i class="font-icon-arrow-simple-right"></i></a>
        <ul id="slide-list"></ul>
        
        <a id="nextsection" href="#about_us"><i class="font-icon-arrow-simple-down"></i></a>
    </div>
</div>
<!-- End Homepage Slider -->
<script type="text/javascript">
	var homeSliderImages = [];

	<?php echo $output; ?>
</script>