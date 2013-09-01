<?php
/**
 * Funkcija resizit image 4tob on naxodila vnutri opredelenoi kvadratnoi ramke
 *
 * @param string $imageSrc putj faila ot direktorii images
 * @param integer $neededSize nuznaja razmer ramki
 */
function resizeToSquere($imageSrc, $neededSize)
{
	global $_CFG;
	
	$imgSrc 	= $_CFG['path_server'].'images/'.$imageSrc;
	$imgParam 	= getimagesize($big_img_src);
	list($width, $height, $type, $attr) = $imgParam;

	$newSizes = getNewSizes($neededSize, $width, $height);
	exec($_CFG['path_to_converter']." ".$imgSrc." -thumbnail ".$newSizes." -quality 95 ".$imgSrc);
}

function _getNewSizes($neededSize, $width, $height)
{
	
	$new_height = '';	
	$new_width 	= '';
	
	if ($height >= $width) {//is vertical image or squere
		if ($height > $neededSize) {
			$new_height = $neededSize;
		} else {
			$new_height = $height;
		}
	} else {//is horisontal image
		if ($width > $neededSize) {
			$new_width = $neededSize;
		} else {
			$new_width = $width;
		}
	}
	return $new_width."x".$new_height;
}

/**
 * 
 * Function resizes image to specified size and there are two options to do it: 
 *  a)resize it to make it fit inside provided dimensions 
 *  b)make it exact size which has been provided(fixed size).
 * @param array $image
 * @param integer $widthNeeded
 * @param integer $heightNeeded
 * @param boolean $fixedSize
 * @param string $newImageSrc
 * @param boolean $createResizedImageAnyways
 */
function resizeImageTwoTimes(&$image, $widthNeeded, $heightNeeded, $fixedSize = false, $newImageSrc = null, $createResizedImageAnyways = false)
{
	global $_CFG;
	
	$changesDone = false;
	
	if ( is_array($image) ){
		$imgSrc = $_CFG['path_server'].'images/'.$image['src'];
	} else {
		$imgSrc = $_CFG['path_server'].'images/'.$image;
	}
	
	if ( $newImageSrc ) {
		$targetImgSrc = $newImageSrc;
	} else {
		$targetImgSrc = $imgSrc;
	}

	$imageParam = getimagesize($imgSrc);
	
	list($width, $height, $type, $attr) = $imageParam;

	$escapedImgSrc = addcslashes($imgSrc," ()");
	$escapedTargetImgSrc = addcslashes($targetImgSrc, " ()");
	
	if ( ($width > $widthNeeded OR $height > $heightNeeded) OR ( $fixedSize AND ($width != $widthNeeded OR $height != $heightNeeded)) ) {
		if ($fixedSize) {
			$changesDone = true;
			$left = 0;
			$top = 0;
			//fixed size width/height without ratio contraining
			//exec($_CFG['path_to_converter']." ".$imgSrc." -thumbnail ".$widthNeeded."x".$heightNeeded."! -quality 95 ".$targetImgSrc);
			
			// resizing to get smallest side to fit inside our required bit
			if ( ($widthNeeded >= $heightNeeded AND $width <= $height) OR ($widthNeeded < $heightNeeded AND $width <= $height ) ) {
			    $command = $_CFG['path_to_converter']." ".$escapedImgSrc." -thumbnail ".$widthNeeded."x -quality 95 ".$escapedTargetImgSrc;
			} else {
			    $command = $_CFG['path_to_converter']." ".$escapedImgSrc." -thumbnail x".$heightNeeded." -quality 95 ".$escapedTargetImgSrc;
			}
			exec( $command );
			
			$imageParam = getimagesize($targetImgSrc);
			list($width, $height, $type, $attr) = $imageParam;
			
			if ($width > $widthNeeded) {
			    $left = ceil(($width - $widthNeeded) / 2);
			}
			if ($height > $heightNeeded) {
			    $top = ceil(($height - $heightNeeded) / 2);
			}
			
			// cropping preresized image
			$command = $_CFG['path_to_converter']." ".$escapedTargetImgSrc." -crop ".$widthNeeded."x".$heightNeeded."+".$left."+".$top." -quality 95 ".$escapedTargetImgSrc;
			exec( $command );
			
			$width = $widthNeeded;
			$height = $heightNeeded;
		} else {
			$changesDone = true;
			if ($height > $heightNeeded) {
			    $command = $_CFG['path_to_converter']." ".$escapedImgSrc." -thumbnail x".$heightNeeded." -quality 95 ".$escapedTargetImgSrc;
				exec( $command );
				$imageParam = getimagesize($targetImgSrc);
				list($width, $height, $type, $attr) = $imageParam;
				$resizedHeight = true;
			}
			if ($width > $widthNeeded) {
			    $command = $_CFG['path_to_converter']." ".(isset($resizedHeight)? $escapedTargetImgSrc : $escapedImgSrc)." -thumbnail ".$widthNeeded."x -quality 95 ".$escapedTargetImgSrc;
				exec( $command );
				$imageParam = getimagesize($targetImgSrc);
				list($width, $height, $type, $attr) = $imageParam;
			}
		}
	} elseif ($createResizedImageAnyways ) {
	    if ( $newImageSrc ) {
	        copy( $imgSrc, $newImageSrc );
	    }
	}
	
	if ( is_array($image) AND $changesDone ) {
		$image['width']  = $width;
		$image['height'] = $height;
	}
}

/**
 * 
 * Resize portfolio images to specified demensions and add a watermark
 * @param array $img img array
 * @param array $sizes array of image dimension with width and height provided
 * @param boolean $fixedSize make image exactly same size as its provided or simply make it fit inside provided dimensions container
 * @param boolean $addWatermark
 */
function resizePortfolioImages( &$img, $sizes, $fixedSize = false, $addWatermark = false)
{
	global $_CFG;
	
	if ( trim( $img['src'] ) )
	{
		$src     = $img['src'];
		$imgPath = $_CFG['path_server'].'images/'.$src;
		$imgName = basename( $src );
		
		foreach ( $sizes as $size => $dimension )
		{
		    $publicImagePath = $_CFG['path_to_public_images'].'/resized/'.$size;
		    
		    if ( !is_dir( $publicImagePath ) )
		        mkdir( $publicImagePath, 0775, true);

		    if ( !file_exists( $publicImagePath.'/'.$imgName ) ) 
		    {
		        resizeImageTwoTimes( $img, $dimension[0], $dimension[1], $fixedSize[$size], $publicImagePath.'/'.$imgName, true );
		       
		        if ( $addWatermark )
		            addWatermarkToImage( $publicImagePath.'/'.$imgName );
		        //echo 'resizing '.$publicImagePath.'/'.$imgName.'<br/>';
		    }
		}
	}
}
//@TODO
// 1. Need to add check for same image name so resizing would create another image.
// We can check it during small_image upload.- rename it and rename future public images.
// 2. Check how to handle vertical images. in different galleries
	
function resizeImageOnce($imageSrc, $widthNeeded, $heightNeeded, $resizeItself = false)
{
	global $_CFG;
	
	if ( !$resizeItself )
	{
    	$big_img_src  = $_CFG['path_server'].'images/'.$imageSrc;
    	$big_img_src2 = $_CFG['path_server'].'images/resized/big/'.basename($imageSrc);
	} else {
	    $big_img_src = $big_img_src2 = $imageSrc;
	}
	
	$big_image_param = getimagesize($big_img_src);
	list($width, $height, $type, $attr) = $big_image_param;

	if ($width > $widthNeeded) {
		exec($_CFG['path_to_converter']." ".$big_img_src." -thumbnail ".$widthNeeded."x -quality 95 ".$big_img_src);
	}
	if ($height > $heightNeeded) {
		exec($_CFG['path_to_converter']." ".$big_img_src." -thumbnail x".$heightNeeded." -quality 95 ".$big_img_src);
	}	
}

/**
 * 
 * Functionad provides watermark on selected image
 * @param string $imgSrc
 * @param string $imgSrcTarget
 */
function addWatermarkToImage( $imgSrc, $imgSrcTarget = null )
{
    global $_CFG;
    if ( $imgSrc )
    {
        if ( !$imgSrcTarget ) $imgSrcTarget = $imgSrc;
        $command = $_CFG['path_to_composite']." -gravity center ".$_CFG['path_to_modules']."components/watermark.png ".$imgSrc." \\".$imgSrcTarget;
        exec( $command );
    }
}
?>