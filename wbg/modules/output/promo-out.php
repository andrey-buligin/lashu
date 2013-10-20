<!-- Big Blockquote -->
<div class="big-quote page">
    <div class="container">
        <div class="row">
            <div class="span12">
                <p><?php 
					$activeCategory = $web->active_category;
				    $activeCategoryData = $web->category_data[$activeCategory];

				    $contentFile = $_CFG['path_to_modules'].'/input/onetext/__saved_data_'.$activeCategory;
				    if ( file_exists( $contentFile ) )
				    {
				    	$data = unserialize( file_get_contents( $contentFile ) );
				    	if ($data['text'])
				    	{
				    		echo $data['text'];
				    	}
				    } else {
				    	WBG::message("promo");
				    }
           		?></p>
                <span class="font-icon-blockquote"></span>
            </div>
        </div>
    </div>
</div>
<!-- End Big Blockquote -->