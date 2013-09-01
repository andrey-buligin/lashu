<?php 

//SkinManager
include_once($_CFG['path_to_cms'].'modules/libraries/skinmanager.class/skinmanager.php');
$skinManager = new SkinManager();

//BlockManager
include_once($_CFG['path_to_cms'].'modules/libraries/contentblockmanager.class/contentblockmanager.php');
$blockManager = ContentBlockManager::initialize();
$blockManager->loadBlocksFromDb();

$_CFG['skinManager']    = $skinManager;
$_CFG['skin_paths']     = $skinManager->getSkinPaths();
$_CFG['skin_settings']  = $skinManager->getSkinConfig();
$_CFG['blockManager']   = $blockManager;

//ImageMagick
$_CFG['path_to_converter'] = "/usr/bin/convert";
$_CFG['path_to_composite'] = "/usr/bin/composite";

//Portfolio
$_CFG['portfolio_folder_id'] = 24;
$_CFG['portfolio_output_module_id'] = 15;
$_CFG['portfolio_input_module_id'] = 5;
$_CFG['path_to_public_images'] = $_CFG['path_to_cms'].'../images/portfolio';
$_CFG['public_images_folder']  = 'portfolio';

//PDO
$_CFG['sql']['pdo'] = null;

?>