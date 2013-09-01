<?php
global $_CFG;

$this->textline('Skin options');
$skins = array( 'default' => 'Default',
				'hanna'  => 'Hanna',
				//'dark'    => 'Dark',
				'konsus'  => 'Konsus'
			  );
$this->select("skin","Website skin:", $skins , null, "style='width:150px'");
$this->image("logo","Website logo","/", "Any x Any:1;300x:1:/");
$this->insert_after_object = ' (e.g. "#ffffff" or "white")';
$this->smalltext("background","Background color",6);
$this->insert_after_object = ' (e.g. "top left" or "10px 100px" )';
$this->smalltext("background_position","Background position", 15);
$this->image("background_image","Background image","/", "Any x Any:1;1000x:1:/");
$this->void_line(20);

/***********************************************************************/

$this->textline('Navigation options');
$navDropdowns = array( 'default' => 'Default',
					  // 'wide'	  => 'wide'
				     );
$navAnimation = array( 'default' => 'Default',
					  // 'fade'	 => 'fade',
					  // 'bounce'	 => 'bounce'
				     );
$this->select("nav_type","Top navigation type:", $navDropdowns , null, "style='width:150px'");
$this->select("nav_effect","Top navigation animation:", $navAnimation , null, "style='width:150px'");
$description = ' (e.g. "show / hide" side navigation which shows website tree elements starting from 2nd level )';
$data = $this->checkbox("show_left_nav", null).$description;
$this->make_container($data,"Show left navigation", "style='background:#f2cf8f'");
$this->void_line(20);

/***********************************************************************/

$this->textline('Portfolio gallery options');
$availableGalleryTypes = $_CFG['portfolioManager']->getPortolioGalleries();
//@TODO We need to reset gallery type once switch skin
$portfolioGalleryTypes = $availableGalleryTypes;
$this->select("portfolio_gallery_type","Portfolio gallery type:", $portfolioGalleryTypes , null, "style='width:150px'");
$this->checkbox("show_portfolio_cats", "Show portfolio categories", 1);
$this->checkbox("show_popup","Show popup image", 1);
$this->checkbox("image_upload","Allow image download", 1);
$this->checkbox("watermark","Show watermark", 1);
$this->smalltext("watermark_text","Watermark text", 30);
$this->tr("Thumbnail size[px]", $this->smalltext("image_small_x", null , 5).' x '.$this->smalltext("image_small_y", null, 5));
$this->tr("Main image size[px]", $this->smalltext("image_big_x", null , 5).' x '.$this->smalltext("image_big_y", null, 5));
$this->void_line(20);

/***********************************************************************/

$this->textline('Default page blocks');
$description = ' (e.g. "show / hide" custom blocks on article and text pages )';
$data = $this->checkbox("show_blocks", null).$description;
$this->make_container($data,"Show blocks", "style='background:#f2cf8f'");
$this->select("blocks_layout","Blocks layout:", array( 1 => 'Wide left side', 2 => 'Wide right side') , null, "style='width:150px'");
$blocks     = array();
$skinBlocks = $_CFG['blockManager']->getSkinBlocks();
foreach ( $skinBlocks as $blockId => $block) {
    $blocks[$blockId] = str_replace('_', ' ', $block['title']);
}
$this->start_repeat_block("List of left hand side blocks", "Blocks");
    echo "Option eng:" . $this->select("blocks_left", null, $blocks);
$this->end_repeat_block(); 
$this->start_repeat_block("List of right hand side blocks", "Blocks");
    echo "Option eng:" . $this->select("blocks_right", null, $blocks);
$this->end_repeat_block();
//@TODO add width for columns

?>
