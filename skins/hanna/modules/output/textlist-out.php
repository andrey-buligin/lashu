<?php

global $web;
global $_CFG;

include_once( $_CFG['path_to_modules'].'/libraries/textlist_out.class/textlist_out.class.php' );

$wbgLayout  = WbgLayout::initialize();
$urlManager = new UrlManager();
$textlist   = new TextListOut( '_mod_textlist', $web->active_category );
$templateVars = array( 'textlist'    => $textlist,
					   'wbg_layout'  => $wbgLayout,
					   'urlManager'  => $urlManager
                      );

if ( isset($_GET['doc']) )
	$moduleView = 'modules/articles-opened-view';
else
	$moduleView = 'modules/articles-list-view';

ob_start();
$wbgLayout->includeTemplate( $moduleView, $templateVars );
$moduleHTML = ob_get_contents();
ob_end_clean();

$return_from_module = WBG_HELPER::transferToXHTML( $moduleHTML );

?>