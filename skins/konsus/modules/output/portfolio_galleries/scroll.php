<?php
/*=======================================================================*/
// [[[ Logic

$galleryData     = showGalleries();
$projectTextData = getProjectDescription();

$return_from_module = getProjectDescription().
						' <div id="loader"></div>
						<!-- SCROLLING PART START -->
						'.$galleryData['gallery'].'
						<!-- SCROLLING PART END -->'.
					    '<div id="categoryTitle"><h1 title="'.WBG_HELPER::insertCatTitle().'">'.WBG_HELPER::insertCatTitle().'</h1></div>';

// ]]] Logic
/*=======================================================================*/
// [[[ galleries
				
	function showGalleries()
	{
		global $_CFG;
		global $web;
		
		$portfolioManager = new PortfolioManager;
		$cat     = $web->active_category;
		$buttons = '';
		$gallery = '';
		$x    	 = 0;
		$onPage  = 7;
		
		$query   = "SELECT * FROM _mod_portfolio WHERE active=1 AND category_id=".$cat." ORDER BY sort_id ASC";
		$sql_res = mysql_query( $query );
		while ( $portfolioArr = mysql_fetch_assoc($sql_res) )
		{
			if ( $portfolioArr['image_small'] )
			{
				$x++;
				$image   = @unserialize( $portfolioArr['image_small'] );
				$title 	 = $portfolioArr['title_'.$web->lang_prefix];
				$popupImgSrc = $portfolioManager->getMainImageUrl( basename($image['src']) );
				$ImgSrc      = $portfolioManager->getThumbnailUrl( basename($image['src']) );

				$onClick = "openImg( 'images/".$popupImgSrc."', 'popup-".$portfolioArr['id']."' )";
				$gallery .= '<li class="scroll-interval"><a href="#" onclick="'.$onClick.'">'.WBG_HELPER::insertImage( null, 'title="'.$title.'" alt="'.$image['alt'].'"', $ImgSrc ).'</a></li>'."\n";
			}
		}
		
		if ( $gallery )
		{
			for ($i = 1; $i <= $x; $i++) $jsObject[] = '"dialog'.$i.'"';
			if ( $x > $onPage ) 
			{
				$buttons = '<div class="sc_menu_button forward"><img id="forward" src="images/skins/konsus/building/forward.jpg" alt="Forward" title="Forward"/></div>
						    <div class="sc_menu_button"><img id="back" src="images/skins/konsus/building/back.jpg" alt="Back" title="Back"/></div>';
			} else {
				$buttons = '<div class="sc_menu_button forward">&nbsp;</div>
						    <div class="sc_menu_button">&nbsp;</div>';
			}
			
			return array(
						'gallery' => $buttons.
            						'<div id="sc_menu" class="scroll-pane">'.
            						'<ul class="blocks">'.$gallery.'</ul>'.
            						'</div>');
			
		} else {
			return array( 
						'gallery' => '<div style="font-size:14px; letter-spacing:3px; font-weight:bold; color:white">Sorry, gallery is empty!</div>',
			        );
		}
	}
		                    
	function getProjectDescription()
	{
	    global $web;
	    
	    $properties = @unserialize( $web->category_data[$web->active_category]['properties']);
	    if ( @$properties['description_title'] AND @$properties['description_text'] )
	    {
	        return '<div id="projectDescriptionContainer">
    	        		<div class="top-bg"></div>
    	        		<div class="projectDescription"><div class="scroll-pane">
    	        			<h2>'. $properties['description_title'].'</h2><div class="text">'.$properties['description_text'].'</div>
    	        		</div></div>
    	        		<div class="bottom-bg"></div>
	        		</div>
	        		<script type="text/javascript">
	        			$("#projectDescriptionContainer .scroll-pane").jScrollPane();
	        		</script>';
	    }
		
	}
	
// ]]] galleries
/*=======================================================================*/	
?>