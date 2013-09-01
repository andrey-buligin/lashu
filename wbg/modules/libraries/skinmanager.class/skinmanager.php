<?php

class SkinManager
{
	CONST DB = '_mod_website_config';
	
	public $skinName;
	public $skinPaths;
	public $skinConfig;
	
	private $skinData = array();
	
	function __construct()
	{
		$websiteSettingsFromDb = $this->loadSettingsFromDB();
		if ( !$websiteSettingsFromDb ){
			$websiteSettings = $this->loadDefaultSettings();
		} else {
			$websiteSettings = $websiteSettingsFromDb;
		}
		$this->setSkinName( $websiteSettings['skin'] );
		$this->setSkinData( $websiteSettings );
		$this->setSkinPaths();
		
		if ( $skinINIconfig = $this->loadConfigSettings() )
			$this->setSkinConfig( $skinINIconfig );
	}
	
	/**
	 * Magick set method
	 * 
	 * @param string $param
	 * @param unknown_type $value
	 */
	public function __set( $param, $value )
	{
        $this->skinData[$param] = $value;
    }

    /**
     * Magick get method
     * 
     * @param string $param
     */
    public function __get( $param )
    {
        if ( array_key_exists( $param, $this->skinData ) )
        {
            return $this->skinData[$param];
        } else {
            //error logging;
        }
    }

    /**
     * Setting up skin data
     * 
     * @param unknown_type $data
     */
    public function setSkinData( $data = null )
    {
        if ( is_array( $data ) )
        {
            foreach ( $data as $param => $val ) {
                $this->$param = $val;
            }
        }
    }
    
	/**
	 * @param $skinConfig the $skinConfig to set
	 */
	public function setSkinConfig($skinConfig) {
		$this->skinConfig = $skinConfig;
	}

	/**
	 * @return the $skinConfig
	 */
	public function getSkinConfig() {
		return $this->skinConfig;
	}

	/**
	 * @param $skinPaths the $skinPaths to set
	 */
	public function setSkinPaths()
	{
		$skinPaths['template'] = $this->setSkinTemplatePath();
		$skinPaths['module'] = $this->setSkinModulePath();
		$skinPaths['images'] = $this->setSkinImagesPath();
		$skinPaths['js'] 	 = $this->setSkinJSPath();
		$skinPaths['css'] 	 = $this->setSkinCSSPath();
		$this->skinPaths = $skinPaths;
	}
	
	/**
	 * @param $skinName the $skinName to set
	 */
	public function setSkinName($skinName)
	{
		$this->skinName = $skinName;
	}
	
	/**
	 * @return the $skinName
	 */
	public function getSkinName() {
		return $this->skinName;
	}

	/**
	 * @return the $skinPath
	 */
	public function getSkinPaths() {
		return $this->skinPaths;
	}

	public function setSkinTemplatePath()
	{
	    global $_CFG;
		return $_CFG['path_to_cms'].'/../skins/'.$this->getSkinName().'/templates/output/';	
	}
	
	public function setSkinModulePath()
	{
	    global $_CFG;
		return $_CFG['path_to_cms'].'/../skins/'.$this->getSkinName().'/modules/output/';	
	}
	
	public function setSkinImagesPath()
	{
	    global $_CFG;
		return $_CFG['path_to_cms'].'/../images/skins/'.$this->getSkinName().'/';	
	}
	
	public function setSkinJSPath()
	{
	    global $_CFG;
		return $_CFG['path_to_cms'].'/../js/skins/'.$this->getSkinName().'/';	
	}
	
	public function setSkinCSSPath()
	{
	    global $_CFG;
		return $_CFG['path_to_cms'].'/../css/skins/'.$this->getSkinName().'/';	
	}
	
	//********************************************************//
	
	function loadSettingsFromDB()
	{
		$query = "SELECT * FROM ".SkinManager::DB." ORDER BY id ASC LIMIT 1";
		$settings = @mysql_fetch_assoc( mysql_query( $query ) );
		return $settings;
	}
	
	function loadDefaultSettings()
	{
		return array( 'skin' => 'default');
	}
	
	function loadConfigSettings()
	{
		global $_CFG;
		
		if ( $this->getSkinName() )
		{
			$iniConfigFilePath = $_CFG['path_server'].'/skins/'.$this->getSkinName().'/config/config.ini';
			return parse_ini_file( $iniConfigFilePath, true );
		}
	}
	
	//********************************************************//
	
    public function showLeftNav()
    {
        return $this->show_left_nav;
    }
    
    public function getNavigationAnimation()
    {
        return $this->nav_effect;
    }
    
    public function showBlocks()
    {
        return $this->show_blocks;
    }
    
    public function getBlocksLayout()
    {
        return $this->blocks_layout;
    }
    
    public function getLeftBlocks()
    {
        if ($this->blocks_left )
            return unserialize( $this->blocks_left );
    }
    
    public function getRightBlocks()
    {
        if ($this->blocks_right )
            return unserialize( $this->blocks_right );
    }
    
}
?>