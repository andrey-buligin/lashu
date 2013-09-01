<?php
/*=======================================================================*/
// [[[ Logic

$galleryData = showGalleries();

echo '<div id="categoryTitle"><h1 title="'.WBG_HELPER::insertCatTitle().'">'.WBG_HELPER::insertCatTitle().'</h1></div>'.
	   $galleryData['gallery'];
	   
showBanners();

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
		$defTitle = '';
	    $defDesc = '';
		
		// getting project description
		$properties = @unserialize( $web->category_data[$cat]['properties']);
	    if ( @$properties['description_title'] AND @$properties['description_text'] ) {
	        $defTitle = $properties['description_title'];
	        $defDesc = $properties['description_text'];
	    }
	    
		$query   = "SELECT * FROM _mod_portfolio WHERE active=1 AND category_id=".$cat." ORDER BY sort_id ASC";
		$sql_res = mysql_query( $query );
		while ( $portfolioArr = mysql_fetch_assoc($sql_res) )
		{
			if ( $portfolioArr['image_small'] )
			{
				$image    = @unserialize( $portfolioArr['image_small'] );
				$title 	  = $defTitle ? $defTitle : $portfolioArr['title_'.$web->lang_prefix];
				$desc     = $defDesc ? $defDesc : $portfolioArr['description_'.$web->lang_prefix];
				$imageSrc = $portfolioManager->getMainImageUrl( basename($image['src']) );
				$thumbSrc = $portfolioManager->getThumbnailUrl( basename($image['src']) );

				$gallery .= '<li><a href="#"><img src="/images/'.$thumbSrc.'" data-large="/images/'.$imageSrc.'" title="'.$title.'" data-description="'.htmlspecialchars($desc).'"></a></li>'."\n";
			}
		}
		
		if ( $gallery )
		{
		    
			return array(
						'gallery' =>' 
						<div id="rg-gallery" class="rg-gallery">
    						<div class="rg-thumbs">
                                <div class="es-carousel-wrapper">
                                    <div class="es-carousel">
                                        <ul>'.$gallery.'</ul>
                                    </div>
                                </div>
                            </div>
                        </div>');
			
		} else {
			return array( 
						'gallery' => '<div style="font-size:14px; letter-spacing:3px; font-weight:bold; ">Sorry, gallery is empty!</div>',
			        );
		}
	}
		                    
// ]]] galleries
/*=======================================================================*/	
// [[[ promo banner

	function showBanners() {
	    global $_CFG;
	    
        $layout = $_CFG['currentLayout'];
        
        if ( $layout->skin->showBlocks() OR $this->currentPage->showBlocks() ) : 
              $leftBlocks = $layout->skin->getRightBlocks();
              
              if ( $layout->currentPage->showBlocks() )//if we have block overrides set up per page
              {
                  $currentPageLeftBlocks = $layout->currentPage->getRightBlocks();
                  $leftBlocks = $currentPageLeftBlocks;
              }
              if ( $leftBlocks )
              {
        	      foreach ( $leftBlocks as $blockId ) {
        	          if ( $layout->blockExists( $blockId ) )
        	          {
        	              $layout->displayBlock( $blockId );
        	          }
        	      }
              }
        endif;
	}
	
// ]]] promo banner
/*=======================================================================*/	
?>

<script type="text/javascript">
var gallery_carousel_speed  = 700,
	gallery_carousel_image_width = 70,
	gallery_slideshow_delay = 3000,
	gallery_carousel_easing = 'easeOutBack';
</script>
<noscript>
	<style>
		.es-carousel ul{
			display:block;
		}
	</style>
</noscript>
<script id="img-wrapper-tmpl" type="text/x-jquery-tmpl">	
	<div class="rg-image-wrapper">
		{{if itemsCount > 1}}
			<a href="#" class="rg-image-slideshow">Play slideshow</a>
			<div class="rg-image-pos"><span class="rg-image-pos-current">1</span> / <span class="rg-image-total">${itemsCount}</span></div>
		{{/if}}
		<div class="rg-image-container">
			{{if itemsCount > 1}}
			<div class="rg-image-nav">
				<a href="#" class="rg-image-nav-prev">Previous Image</a>
 				<a href="#" class="rg-image-nav-next">Next Image</a>
			</div>
			{{/if}}
			<div class="rg-image loaded"></div>
		</div>
		<div class="rg-loading"></div>
		<div class="rg-caption-wrapper">
			<h2 class="rg-caption" style="display:none;"></h2>
			<div class="rg-description" style="display:none;"></div>
		</div>
	</div>
</script>