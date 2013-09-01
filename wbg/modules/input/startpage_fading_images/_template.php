<?php

global $_CFG;
include_once(dirname(__FILE__).'/../../../modules/libraries/portfoliomanager.class/portfoliomanager.php');
include_once(dirname(__FILE__).'/../../../modules/libraries/portfolio_out.class/portfolio_out.class.php');

$portfolioManager = new PortfolioManager( $_CFG['portfolio_folder_id'] );
$portfolioCategories = $portfolioManager->getPartfolioCategories();

/************************************************************************/

$this->textline('Image transition options');
$animationOptions = array( 'fade',
						   'slide',
						   'curtains',
						   'drop'
						 );
$this->select("animation", "Animation effect", $animationOptions, null, "style='width:120px'");
$this->tr("Image size[px]", $this->smalltext("image_size_x", null , 5).' x '.$this->smalltext("image_size_y", null, 5));

if ( $portfolioCategories )
{
	foreach ($portfolioCategories as $category)
	{
		$categories[$category['id']] = $category['title'];
	}

	$description = ' Show images from one randomly selected portfolio category';
	$data = $this->checkbox("show_one_category", null).$description;
	$this->make_container($data,"Use random category", "style=''");
	$this->tr('', 'OR');
	$this->start_repeat_block('Manually specify list of categories showed in "rotating images" block', "Categories");
    	echo $this->select("enabled_categories", null, $categories);
	$this->end_repeat_block();
	$description = ' Mix images between categories. Images are not longer ordered by portfolio categories order';
	$data = $this->checkbox("mix_images", null).$description;
	$this->make_container($data,"Mix images", "style=''");
}

/************************************************************************/

$this->void_line(20);
$this->tr( '', 'Please select/upload images for portfolio categories used in "rotating images" block' );

if ( $portfolioCategories )
{
	$count = 0;
	$array_with_bookmarks = array();
	foreach ($portfolioCategories as $catId => $category)
	{
		$array_with_bookmarks["bookmark".$catId] = $category['title'];
	}

	$this->bookmarks_header($array_with_bookmarks, false);

	foreach ($portfolioCategories as $catId => $category)
	{
		$count++;
		$this->bookmarks_starts("bookmark".$catId, ($count == 1 ? true : false) );
		$this->textline( $category['title']." rotation images");
		//$this->start_repeat_block("List of images", "Images");
		//    echo "Image:" . $this->onefile("image_small_".$catId, null, "startpage/");
		//$this->end_repeat_block();
		//$this->image("image_small","Image small:","portfolio/");
		@$this->image_block("images_".$catId, $category['title']." images", "startpage/" , 3);
		$this->bookmarks_ends();
	}
}
else
{
	$this->tr('', "Ooops! Looks like portfolio folder is empty or doesn't have any sections enabled ");
}
/* 558 372 */

?>
