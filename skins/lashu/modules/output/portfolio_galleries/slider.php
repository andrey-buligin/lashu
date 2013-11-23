<?php
/*=======================================================================*/
// [[[ Logic
// 
$portfolioManager = new PortfolioManager( $_CFG['portfolio_folder_id'] );
$portfolioCategories = $portfolioManager->getPartfolioCategories();

$gallery = showGalleries($portfolioManager, $portfolioCategories);

// ]]] Logic
/*=======================================================================*/
// [[[ galleries
				
	function showGalleries($portfolioManager, $portfolioCategories)
	{
		global $_CFG;
		global $web;
		
		$cats     = $web->active_category;
		$gallery  = '';
		$defTitle = '';
		$defDesc  = '';

	    //getting portfolio categories
	    $catIds = array_map(create_function('$o', 'return $o[id];'), $portfolioCategories);

		// getting project description
		$properties = @unserialize( $web->category_data[$cat]['properties']);
	    if ( @$properties['description_title'] AND @$properties['description_text'] ) {
	        $defTitle = $properties['description_title'];
	        $defDesc = $properties['description_text'];
	    }
	    
		$query   = "SELECT * FROM _mod_portfolio WHERE active=1 AND category_id IN (".implode(",", $catIds).") ORDER BY category_id ASC, sort_id ASC";
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

				$gallery .= '
				<li class="item-thumbs span3 cat_'.$portfolioArr['category_id'].' isotope-item">
                    <a class="hover-wrap fancybox" data-fancybox-group="gallery" title="'.htmlspecialchars($desc).'" href="/images/'.$imageSrc.'">
                        <span class="overlay-img"></span>
                        <span class="overlay-img-thumb font-icon-search"></span>
                    </a>
                    <img src="/images/'.$thumbSrc.'" alt="'.$title.'">
                </li>'."\n";
			}
		}
		
		if ( $gallery ) {
			return $gallery;
		} else {
			return '<div style="font-size:14px; letter-spacing:3px; font-weight:bold; ">Sorry, gallery is empty!</div>';
		}
	}
		                    
// ]]] galleries
/*=======================================================================*/	
?>
<?php 
echo '<div id="categoryTitle"><h1 title="'.WBG_HELPER::insertCatTitle().'">'.WBG_HELPER::insertCatTitle().'</h1></div>';
?>
<div class="row">
	<div class="span12">
    	<!-- Filter -->
        <nav id="options" class="work-nav">
            <ul id="filters" class="option-set" data-option-key="filter">
            	<li class="type-work">Categories</li>
                <li><a href="#filter" data-option-value="*" class="selected">All</a></li>
                <?php foreach ( $portfolioCategories as $index => $cat ): ?>
				<li>
					<a href="#filter" data-option-value=".cat_<?php echo $cat['id'];?>"><?php echo $cat['title'];?></a>
				</li>
			    <?php endforeach;?>
            </ul>
        </nav>
        <!-- End Filter -->
    </div>
    
    <div class="span12">
    	<div class="row">
        	<section id="projects" style="position: relative; overflow: hidden; height: 657px;" class="isotope">
            	<ul id="thumbs">
            		<?php echo $gallery;?>
                </ul>
            </section>
    	</div>
    </div>
</div>