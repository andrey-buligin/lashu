<?php

//loading contacts skin module and render it.
global $_CFG;
include_once($_CFG['path_to_cms'].'modules/libraries/modulemanager.class/modulemanager.php');

$moduleName   = 'reviews-out.php';
$moduleManager= ModuleManager::initialize();
$moduleManager->renderModule( $moduleName );

?>