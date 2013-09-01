<?php

class WbgLayout
{
    const tplExtension = '.tpl.php';

    private static $instance;
    private $layout       = '';
    public  $skin         = '';
    public  $currentPage  = '';
    public  $skinBlocks   = '';
    public  $requiredJsFilesList = array();
    public  $requiredJsMinifiedFilesList = array();

    private function __construct()
    {
    }

    public function __clone()
    {
    }

    public static function initialize()
    {
        if ( !isset(self::$instance) )
        {
            $className = __CLASS__;
            self::$instance = new $className;
        }
        return self::$instance;
    }

    public function setLayout( $pathToLayout = null )
    {
        return $this->layout = $pathToLayout;
    }

    public function getLayout( $pathToLayout = null )
    {
        return $this->layout;
    }

    public function renderLayout()
    {
        global $web;
        global $_CFG;

        $this->skin = $_CFG['skinManager'];
        $this->currentPage = new WBG_Page( $web->active_category );
        if ( $this->layout AND file_exists( $this->layout ) ) {
            $_CFG['currentLayout'] = $this;
            include_once( $this->layout );
        }
    }

    public function loadHeaderCssFile( $file = null )
    {
        if ( $file )
            echo '<link rel="stylesheet" type="text/css" href="'.$this->getSkinCssUrl( $file ).'" />';
    }

    public function loadHeaderJsFile( $file = null, $path = '')
    {
        if ( $file )
            echo '<script type="text/javascript" src="'.($path ? $path.'/'.$file : $this->getSkinJsUrl( $file )).'"></script>';
    }

    public function requireJsFiles($files = null, $minFiles = null)
    {
        $this->_addJsFilesToArray($files, $this->requiredJsFilesList);
        $this->_addJsFilesToArray($minFiles, $this->requiredJsMinifiedFilesList);
    }

    private function _addJsFilesToArray($files, &$requiredJsFilesList)
    {
        if ( is_array($files) ) {
            $requiredJsFilesList = array_merge($requiredJsFilesList, $files);
        } elseif ( is_string($files) ) {
            $requiredJsFilesList[] = $files;
        }
    }

    public function loadRequiredJsFiles()
    {
        $this->_loadRequiredJs($this->requiredJsFilesList);
    }

    public function loadRequiredJsFilesMin()
    {
        if ( !$this->_loadRequiredJs($this->requiredJsMinifiedFilesList) ) {
            $this->loadRequiredJsFiles();
        }
    }

    private function _loadRequiredJs($files)
    {
        if ( $files )
        {
            foreach ( $files as $file )
            {
                $this->loadHeaderJsFile( $file, 'js/' );
            }
            return true;
        }

        return false;
    }

    public function loadGalleryRequiredCssFiles()
    {
        global $_CFG;
        global $web;

        if ( @$web->category_data[$web->active_category]['output_module'] == $_CFG['portfolio_output_module_id'] )
            $this->loadGalleryRequiredFiles( 'css' );
    }

    public function loadGalleryRequiredJsFiles()
    {
        global $_CFG;
        global $web;

        if ( @$web->category_data[$web->active_category]['output_module'] == $_CFG['portfolio_output_module_id'] )
            $this->loadGalleryRequiredFiles( 'js' );
    }

    public function loadGalleryRequiredJsFilesMin()
    {
        global $_CFG;
        global $web;

        if ( @$web->category_data[$web->active_category]['output_module'] == $_CFG['portfolio_output_module_id'] ) {
            $portfolioManager = new PortfolioManager();

            $currentGallery = $portfolioManager->getCurrentPorfolioGallery();
            $minJsFile = $portfolioManager->config[$currentGallery]['JavaScriptMin'];
            $this->loadHeaderJsFile( $minJsFile, 'js/galleries/' );
        }
    }

    protected function loadGalleryRequiredFiles( $type = 'css' )
    {
        if ( $requiredFiles = $this->getGalleryRequiredFilesList($type) )
	    {
	        if ( is_array($requiredFiles) )
	        {
    	        foreach ( $requiredFiles as $file )
    	        {
    	            if ( $type == 'css' )
    	                $this->loadHeaderCssFile( $file );
    	            else
    	                $this->loadHeaderJsFile( $file, 'js/galleries/' );
    	        }
	        }
	    }
    }

    public function getGalleryRequiredFilesList( $type = 'css' )
    {
        global $_CFG;
        include_once($_CFG['path_to_cms'].'modules/libraries/portfoliomanager.class/portfoliomanager.php');

        $portfolioManager = new PortfolioManager();
        $currentGallery = $portfolioManager->getCurrentPorfolioGallery();

        if ( $type == 'css' )
        {
            if ( isset($portfolioManager->config[$currentGallery]['CssList']) )
                return $portfolioManager->config[$currentGallery]['CssList'];
        }
        else
        {
            if ( isset($portfolioManager->config[$currentGallery]['JavaScriptList']) )
                return $portfolioManager->config[$currentGallery]['JavaScriptList'];
        }
        return false;
    }

    public function getImageUrl( $image = null)
    {
        if ( $image AND $this->skin instanceof SkinManager )
            return 'images/skins/'.$this->skin->getSkinName().'/'.$image;
    }

    public function getSkinCssUrl( $cssFile = null )
    {
        if ( $cssFile AND $this->skin instanceof SkinManager )
            return 'css/skins/'.$this->skin->getSkinName().'/'.$cssFile;
    }

    public function getSkinJsUrl( $jsFile = null)
    {
        if ( $jsFile AND $this->skin instanceof SkinManager )
            return 'js/skins/'.$this->skin->getSkinName().'/'.$jsFile;
    }

    public function getLogoImage()
    {
        if ( $this->skin->logo )
            return WBG_HELPER::insertImage( $this->skin->logo, '', null, 1 ) ;
        else
            return '<img src="'.$this->getImageUrl( 'building/logo.jpg' ).'" alt="" title="" /></a>';
    }

    public function getBackgroundStyle()
    {
        $backgroundImage = @unserialize($this->skin->background_image);
        if ( trim($this->skin->background) OR $backgroundImage['src'] )
        {
            $background = '';
            if ( $backgroundImage['src'] )
            {
                $position   = $this->skin->background_position;
                $background = "url('images/".$backgroundImage['src']."') ".$position;
            }

            if ( trim($this->skin->background) )
                $background .= " ".$this->skin->background;

            return ' style="background: '.$background.'"';
        }
    }

    public function displayHead()
    {
        $this->includeTemplate( 'parts/head' );
    }

    public function displayHeader()
    {
        $this->includeTemplate( 'parts/header' );
    }

    public function displayFooter()
    {
        $this->includeTemplate( 'parts/footer' );
    }

    public function displayBlock( $blockId = null )
    {
        global $_CFG;
        $block = null;

        if ( is_numeric( $blockId ) )
        {
            //loadBlockById
            $block = $_CFG['blockManager']->getBlockById( $blockId );
        } else {
            //loadBlockByName
        }

        if ( $block )
            $this->includeTemplate( 'blocks/'.$block['title'] );
    }

    public function blockExists( $blockId = null )
    {
       global $_CFG;
       if ( !$this->skinBlocks )
           $this->skinBlocks = $_CFG['blockManager']->getSkinBlocks();
       return array_key_exists( $blockId, $this->skinBlocks );
    }

    public function displayModule()
    {
        $this->includeTemplate( 'parts/footer' );
    }


    public function includeCssCode( $css = null )
    {
        echo '<style>'.$css.'</style>';
    }

    public function includeJsCode( $jsCode = null )
    {
        echo '<script type="text/javascript">
            	<!--//--><![CDATA[//><!--
            	'.$jsCode.'
            	//--><!]]>
              </script>';
    }

    public function includeTemplate( $template = null, &$templateVars = null )
    {
        global $_CFG;
        global $web;

        $templateToLoad = $_CFG['skin_paths']['template'] . $template . self::tplExtension;

        if ( file_exists( $templateToLoad ) )
           include $templateToLoad;
    }

}

?>