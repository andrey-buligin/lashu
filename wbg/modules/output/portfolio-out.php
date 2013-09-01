<?php

//loading contacts skin module and render it.
global $_CFG;
include_once($_CFG['path_to_cms'].'modules/libraries/modulemanager.class/modulemanager.php');
include_once($_CFG['path_to_cms'].'modules/libraries/portfoliomanager.class/portfoliomanager.php');

$defaultPortfolioModule = 'default';
$portfolioManager = new PortfolioManager;
$currentPortoflioGallery = $portfolioManager->getCurrentPorfolioGallery();

if ( $currentPortoflioGallery )
    $galleryModule = $currentPortoflioGallery.'.php';
else 
    $galleryModule = $defaultPortfolioModule.'.php';
    
$moduleName   = 'portfolio_galleries/'.$galleryModule;
$moduleManager= ModuleManager::initialize();
$moduleManager->renderModule( $moduleName );

?>