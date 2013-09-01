<?php 

global $_CFG;
include_once($_CFG['path_to_cms'].'modules/components/wbg_helper.php');
include_once($_CFG['path_to_cms'].'modules/components/wbg_page.php');
include_once($_CFG['path_to_cms'].'modules/libraries/layout.class/layout.php');

$template     = 'startpage.tpl.php';
$wbgLayout    = WbgLayout::initialize();
$pathToLayout = $_CFG['skin_paths']['template'] . $template;
$wbgLayout->setLayout( $pathToLayout );
$wbgLayout->renderLayout();

?>