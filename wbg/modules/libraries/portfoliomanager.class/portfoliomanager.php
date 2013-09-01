<?php

include_once(dirname(__FILE__).'/../../components/wbg_helper.php');

class PortfolioManager
{
	public $categories;
	public $lang;
	public $config;
	static $defaultThumbnailX = 120;
	static $defaultThumbnailY = 120;
	static $defaultMainImageX = 600;
	static $defaultMainImageY = 400;
	static $configIni         = 'portfolio_galleries.ini';

	function __construct( $portfolioFolderId = null )
	{
		global $_CFG;
		global $web;

		$this->config = $this->getPortfolioConfigSettings();

		if ( isSet( $web ) )
			$this->lang  = $web->lang_prefix;
		if ( $portfolioFolderId )
			$this->setPartfolioCategories( $this->fetchFolderCategories( $portfolioFolderId ) );
	}

	function setPartfolioCategories( $categories )
	{
		$this->categories = $categories;
	}

	function getPartfolioCategories()
	{
		return $this->categories;
	}

	function fetchFolderCategories( $folderId = null, $condition = '' )
	{
		$cats = WBG_HELPER::getCatChilds( $folderId, 'getActive', 'getRecursive' );
		return $cats;
	}

	function getPortfolioConfigSettings()
	{
		global $_CFG;

		if ( $_CFG['skinManager']->getSkinName() )
		{
			$iniConfigFilePath = $_CFG['path_server'].'/skins/'.$_CFG['skinManager']->getSkinName().'/config/'.self::$configIni;
			return parse_ini_file( $iniConfigFilePath, true );
		}
	}

    /**
     * Returns array of available galleries modules
     * @return array(gallery_file_path=>title)
     */
    public function getPortolioGalleries()
    {
        $portfolioConfig = $this->getPortfolioConfigSettings();
        if ( is_array($portfolioConfig['PortfolioSettings']['AvailableGalleriesType']) )
        {
            foreach ( $portfolioConfig['PortfolioSettings']['AvailableGalleriesType'] as $galleryType )
            {
                if ( isset($portfolioConfig[$galleryType]))
                    $galleriesTypes[$galleryType] = $portfolioConfig[$galleryType]['Name'];
                else
                    $galleriesTypes[$galleryType] = $galleryType;
            }
            return $galleriesTypes;
        }else
            return array( 'default' );
    }

    /**
     * Returns identifier of currently selected portfolio gallery's type.
     * @return string
     */
    public function getCurrentPorfolioGallery()
    {
        global $_CFG;

        if ( $_CFG['skinManager']->portfolio_gallery_type )
            return $_CFG['skinManager']->portfolio_gallery_type;
    }

    /**
     * Get thumbnail image width and height
     *
     * @param string $portfolioGalleryId - identifier of gallery type
     */
    public function getThumnailImageXY( $portfolioGalleryId = null )
    {
        if ( !$portfolioGalleryId )
            $portfolioGalleryId = $this->getCurrentPorfolioGallery();
        return $this->getImageXY( 'Thumbnail', $portfolioGalleryId );
    }

    /**
     * Get main image width and height
     *
     * @param string $portfolioGalleryId - identifier of gallery type
     */
    public function getMainImageXY( $portfolioGalleryId = null )
    {
        if ( !$portfolioGalleryId )
            $portfolioGalleryId = $this->getCurrentPorfolioGallery();
        return $this->getImageXY( 'MainImage', $portfolioGalleryId );
    }

    protected function getImageXY( $imageSizeName = null, $portfolioGalleryId = null )
    {
        $portfolioConfig = $this->getPortfolioConfigSettings();

        //@TODO at the moment function returns size only from config.ini instead of real saved data.
        if ( $imageSizeName == 'MainImage' )
        {
            $imageWidth  = self::$defaultMainImageX;
            $imageHeight = self::$defaultMainImageY;
        }
        else
        {
            $imageWidth  = self::$defaultThumbnailX;
            $imageHeight = self::$defaultThumbnailY;
        }

        if (array_search( $portfolioGalleryId, $portfolioConfig['PortfolioSettings']['AvailableGalleriesType']) !== false )
        {
            if ( $imageSizeName AND is_array($portfolioConfig[$portfolioGalleryId]) )
            {
                if ( is_numeric($portfolioConfig[$portfolioGalleryId][$imageSizeName.'Width'] ) )
                    $imageWidth  = $portfolioConfig[$portfolioGalleryId][$imageSizeName.'Width'];
                if ( is_numeric($portfolioConfig[$portfolioGalleryId][$imageSizeName.'Height'] ) )
                    $imageHeight = $portfolioConfig[$portfolioGalleryId][$imageSizeName.'Height'];
            }
        }

        return array( $imageWidth, $imageHeight );
    }

    public function getActualMainImageSize( $imageName = null )
    {
        return $this->getActualImageSize( 'MainImage', $imageName );
    }

    public function getActualThumbnailSize()
    {
        return $this->getActualImageSize( 'Thumbnail', $imageName );
    }

    public function getActualImageSize( $imageSizeName, $imageName = null )
    {
        if ( $imageName )
        {
            $imagePath = '';
            switch ($imageSizeName) {
                case 'MainImage':
                    $imagePath = $this->getMainImageFolderPath().'/'.$imageName;
                    break;
                case 'Thumbnail':
                    $imagePath = $this->getThumbnailFolderPath().'/'.$imageName;
                    break;
                default:
                break;
            }
            if ( file_exists($imagePath) )
                return getimagesize( $imagePath );
            else
                return false;
        }
        return false;
    }

    function getThumbnailFolderPath( $portfolioGalleryId = null )
    {
        return $this->getImageFolderPath( 'Thumbnail', $portfolioGalleryId );
    }

    function getMainImageFolderPath( $portfolioGalleryId = null )
    {
        return $this->getImageFolderPath( 'MainImage', $portfolioGalleryId );
    }

    function getImageFolderPath( $imageSizeName = 'Thumbnail', $portfolioGalleryId = null )
    {
        global $_CFG;

        if ( !$portfolioGalleryId )
            $portfolioGalleryId = $this->getCurrentPorfolioGallery();

        switch ( $imageSizeName )
        {
            case 'MainImage':
                 list($imageX, $imageY) = $this->getMainImageXY( $portfolioGalleryId );
                 break;
            default:
                 list($imageX, $imageY) = $this->getThumnailImageXY( $portfolioGalleryId );
                 break;
        }

        $folderPath = $_CFG['path_to_public_images'].'/resized/'.$imageX.'_'.$imageY;
        return $folderPath;
    }

    function getThumbnailFolderUrl( $portfolioGalleryId = null )
    {
        return $this->getImageFolderUrl( 'Thumbnail', $portfolioGalleryId );
    }

    function getMainImageFolderUrl( $portfolioGalleryId = null )
    {
        return $this->getImageFolderUrl( 'MainImage', $portfolioGalleryId );
    }

    function getImageFolderUrl( $imageSizeName = 'Thumbnail', $portfolioGalleryId = null )
    {
        global $_CFG;

        if ( !$portfolioGalleryId )
            $portfolioGalleryId = $this->getCurrentPorfolioGallery();

        switch ( $imageSizeName )
        {
            case 'MainImage':
                 list($imageX, $imageY) = $this->getMainImageXY( $portfolioGalleryId );
                 break;
            default:
                 list($imageX, $imageY) = $this->getThumnailImageXY( $portfolioGalleryId );
                 break;
        }

        $imageFolderUrl = $_CFG['public_images_folder'].'/resized/'.$imageX.'_'.$imageY;
        return $imageFolderUrl;
    }

    function getThumbnailUrl( $imageName = null )
    {
        return $this->getImageUrl( 'Thumbnail', $imageName );
    }

    function getMainImageUrl( $imageName = null )
    {
        return $this->getImageUrl( 'MainImage', $imageName );
    }

    function getImageUrl( $imageSizeName = null, $imageName = null )
    {
        switch ( $imageSizeName )
        {
            case 'MainImage':
                 $imagePath = $this->getMainImageFolderPath();
                 break;
            default:
                 $imagePath = $this->getThumbnailFolderPath();
                 break;
        }
        if ( is_string($imageName) AND file_exists( $imagePath.'/'.$imageName )) {
            switch ( $imageSizeName )
            {
                case 'MainImage':
                     $imageUrl = $this->getMainImageFolderUrl().'/'.rawurlencode($imageName);
                     break;
                default:
                     $imageUrl = $this->getThumbnailFolderUrl().'/'.rawurlencode($imageName);
                     break;
            }
            return $imageUrl;
        }
        else {
            return 'not-found.gif';
        }
    }

    function getSizesArray() {
        list($thumbWidth, $thumbHeight) = $this->getThumnailImageXY();
	    list($mainImgWidth, $mainImgHeight) = $this->getMainImageXY();

	    $sizes = array(
	        $thumbWidth.'_'.$thumbHeight     => array( $thumbWidth, $thumbHeight ),
	    	$mainImgWidth.'_'.$mainImgHeight => array( $mainImgWidth, $mainImgHeight )
	    );

	    return $sizes;
    }

    function getFixedSizesFlagArray() {
        list($thumbWidth, $thumbHeight) = $this->getThumnailImageXY();
	    list($mainImgWidth, $mainImgHeight) = $this->getMainImageXY();

        $fixedSizes = array(
	    	$thumbWidth.'_'.$thumbHeight     => false,
	    	$mainImgWidth.'_'.$mainImgHeight => false
	    );

	    $currentGallery = $this->getCurrentPorfolioGallery();

	    //@TODO check that if several galleries have both fixed/not fixes sizes
	    if ( isset($this->config[$currentGallery]['FixedThumbnailSize']) )
	    {
	        if ( $this->config[$currentGallery]['FixedThumbnailSize'] )
	            $fixedSizes[$thumbWidth.'_'.$thumbHeight] = true;
	    }
	    if ( isset($this->config[$currentGallery]['FixedMainImageSize']) )
	    {
	        if ( $_CFG['portfolioManager']->config[$currentGallery]['FixedMainImageSize'] )
	            $fixedSizes[$mainImgWidth.'_'.$mainImgHeight] = true;
	    }

	    return $fixedSizes;
    }
}

?>