<?php 

class ContentBlockManager
{
    const standaloneModuleId = 3;
    
    private static $instance;
    public $availableBlocks = null;
    public $skinBlocks      = null;
     
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
    
    public function getAvailableBlocks()
    {
        if ( self::$instance->availableBlocks === null )
            self::loadBlocksFromDb();
        return self::$instance->availableBlocks;
    }
    
    public static function getSkinBlocks()
    {
        $skinBlocks = array();
        if ( self::$instance->skinBlocks === null )
        {
            $availableBlocks = self::getAvailableBlocks();
            if ( is_array( $availableBlocks ) )
            {
                foreach ( $availableBlocks as $block ) {
                    if ( self::blockExistsInConfig( $block['title'] ) )
                        $skinBlocks[$block['id']] = $block;
                }
            }
            if ( $skinBlocks )
                self::$instance->skinBlocks = $skinBlocks;
        }
        return self::$instance->skinBlocks;
    }
    
    public static function getBlockById( $blockId = null )
    {
        if ( self::$instance->availableBlocks === null )
            self::getAvailableBlocks();
        if ( isset(self::$instance->availableBlocks[ $blockId ]) )
            return self::$instance->availableBlocks[ $blockId ];
    }
    
    public static function loadBlocksFromDb()
    {
        $blocks = array();
        $query = 'SELECT * FROM wbg_modules WHERE type='.self::standaloneModuleId;
        $sqlRes = mysql_query( $query );
        while ( $block = mysql_fetch_assoc( $sqlRes ) )
        {
            $blocks[$block['id']] = $block;
        }
        self::$instance->availableBlocks = $blocks;
    }
    
    public static function blockExistsInConfig( $blockTitle = null )
    {
        global $_CFG;
        
        $skinConfigIni = $_CFG['skinManager']->getSkinConfig();
        
        //if config file doesnt contain blocks definition we assume that block cannot be shown
        if ( !isset( $skinConfigIni['AvailableBlocks']['blocks'] ) )
            return false;
            
        if ( is_string( $blockTitle ) )
        {
            if ( array_search( $blockTitle, $skinConfigIni['AvailableBlocks']['blocks'] ) !== false )
                return true;
        }

        return false;
    }
    
}
?>