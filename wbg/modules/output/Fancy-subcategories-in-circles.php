<?php
	global $_CFG;
	include_once( $_CFG['path_to_modules'].'components/url_manager.php');
?>
<article id="onetextContent">
	<header>
		<h1><?php echo WBG_HELPER::insertCatTitle() ?></h1>
	</header>
	<?php
		global $web;

		$currentCatId  = $web->active_category;
		$subcategories = WBG_HELPER::getCatChilds($currentCatId);
		$UrlManager    = new UrlManager();
	?>
	<?php if ($subcategories): ?>
		<ul class="ch-grid">
			<?php
				foreach ($subcategories as $key => $cat) :
					$properties = $cat['properties'];
					$title      = $cat['title'];
					$text       = WBG_HELPER::getProperty($properties, 'category_text');
					$image      = WBG_HELPER::getProperty($properties, 'category_image');

					if ( $image['resized'][1] ) {
						$frontImageSrc = $image['resized'][1];
					} else {
						$frontImageSrc = $image['src'];
					}

					if ( ($cat['input_module'] != $_CFG['portfolio_input_module_id']) ) {
						$link = WBG_HELPER::SmartUrlEncode( WBG::crosslink($cat['id']) );
					} else {
						$link = $UrlManager->getWbgCategoryUrl( $cat['id'] );
					}
			?>
			<li class="ch-item">
				<div class="ch-info"><a href="<?php echo $link;?>">&nbsp;</a></div>
				<div class="ch-info-front" style="background-image: url('images/<?php echo $frontImageSrc;?>')"><a href="<?php echo $link;?>"></a></div>
				<div class="ch-info-back">
					<a href="<?php echo $link;?>">
						<h3><?php echo $title; ?></h3>
						<p><?php echo $text; ?></p>
					</a>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</article>
