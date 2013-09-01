<?php 

class ModuleManager
{
    const standaloneModuleId = 3;
    const outputModuleId     = 2;
    const inputModuleId      = 1;
    
    private static $instance;
    public $availableModules = null;
    public $skinModules      = null;
     
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
    
    public function renderModule( $moduleName = null )
    {
        global $_CFG;
        
        $pathToModule = $_CFG['skin_paths']['module'] . $moduleName;
        if ( file_exists($pathToModule) )
        {
            include $pathToModule;
            if ( isset($return_from_module) )
            {
                echo eval('?>' . $return_from_module . '<?');
            }
        } else {
            //log error - module not found
        }
    }
       
    public static function getModuleById( $moduleId = null )
    {
    }
    
    public static function moduleExistsInConfig( $moduleTitle = null )
    {
        global $_CFG;
        
        $skinConfigIni = $_CFG['skinManager']->getSkinConfig();
        
        if ( !isset( $skinConfigIni['AvailableModules']['modules'] ) )
            return false;
            
        if ( is_string( $moduleTitle ) )
        {
            if ( array_search( $moduleTitle, $skinConfigIni['AvailableModules']['modules'] ) !== false )
                return true;
        }

        return false;
    }
    
}
?>