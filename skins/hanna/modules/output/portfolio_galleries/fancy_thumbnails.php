<?php
/*=======================================================================*/
// [[[ Logic

$galleryData = showGalleries();

$return_from_module = '<div id="img_loader" class="loader"></div>
						<div class="wrapper">
						<div id="ps_container" class="ps_container">'.
					      $galleryData['gallery'].
            		    '</div>'.
            		   '<div id="categoryTitle"><h1 title="'.WBG_HELPER::insertCatTitle().'">'.WBG_HELPER::insertCatTitle().'</h1></div>
            		   </div>';

// ]]] Logic
/*=======================================================================*/
// [[[ galleries
				
	function showGalleries()
	{
		global $_CFG;
		global $web;
		
		$portfolioManager = new PortfolioManager();
		$cat     = $web->active_category;
		$gallery = '';
		$x    	 = 0;
		$firstImage = '';
		
		$query   = "SELECT * FROM _mod_portfolio WHERE active=1 AND category_id=".$cat." ORDER BY sort_id ASC";
		$sql_res = mysql_query( $query );
		while ( $portfolioArr = mysql_fetch_assoc($sql_res) )
		{
			if ( $portfolioArr['image_small'] )
			{
				$x++;
				$image    = @unserialize( $portfolioArr['image_small'] );
				$title 	  = $portfolioArr['title_'.$web->lang_prefix];
				$imageSrc = $portfolioManager->getMainImageUrl( basename($image['src']) );
				$thumbSrc = $portfolioManager->getThumbnailUrl( basename($image['src']) );

				if ( $x == 1 )
				{
				    $firstImage = WBG_HELPER::insertImage( null, 'title="'.$title.'" alt="'.$image['alt'].'"', $imageSrc );
				    $firstImageSize = $portfolioManager->getActualMainImageSize( basename($image['src']) );
				}
				    
				$gallery .= '<li '.( $x == 1 ? 'class="selected"':'').'><a href="/images/'.$imageSrc.'" rel="/images/'.$thumbSrc.'" title="'.$title.'">'.$title.'</a></li>'."\n";
			}
		}
		
		if ( $gallery )
		{
		    
			return array(
						'gallery' =>'<div class="ps_image_wrapper" '.($firstImageSize?'style="width:'.$firstImageSize[0].'px; height:'.$firstImageSize[1].'px;"':'').'>
                    					'.$firstImage.'
                    				</div>
                    				<div class="ps_next"></div>
                    				<div class="ps_prev"></div>
                    				<!-- Dot list with thumbnail preview -->
                    				<ul class="ps_nav">
                    					'.$gallery.'
                    					<li class="ps_preview">
                    						<div class="ps_preview_wrapper">
                    							<!-- Thumbnail comes here -->
                    						</div>
                    						<!-- Little triangle -->
                    						<span></span>
                    					</li>
                    				</ul>');
			
		} else {
			return array( 
						'gallery' => '<div style="font-size:14px; letter-spacing:3px; font-weight:bold; ">Sorry, gallery is empty!</div>',
			        );
		}
	}
		                    
// ]]] galleries
/*=======================================================================*/	
?>