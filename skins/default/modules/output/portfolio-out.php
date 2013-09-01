<?php

global $_CFG;
global $web;

include_once( $_CFG['path_to_modules'].'/libraries/portfolio_out.class/portfolio_out.class.php' );

$portfolioCat = $web->active_category;
$itemsOnPage  = 12;
$portfolioOut = new PortfolioOut( $portfolioCat, $itemsOnPage );

/*============================================================================*/

if ( !isset( $_GET['obj_id'] )) {
	
	$_SESSION['last_viewed_portfolio_page'] = $_SERVER['REDIRECT_URL'];
	$condition    = $portfolioOut->checkActions();
	$elements 	  = $portfolioOut->fetchElements( $condition );
	$portfolioOut->setElements( $elements );
	
	if ( $elements ) 
	{
		$htmlOut = '<h1>'.WBG_HELPER::insertCatTitle().'</h1>'.
			       '<div id="slider">
			            <ul class="navigation">
			            	'.$portfolioOut->getNavigation().'
			            </ul>
			            <div class="scroll">
			                <div class="scrollContainer">
				                '.$portfolioOut->showContent().'
			                </div>
			            </div>
			        </div>
			        <script type="text/javascript" src="js/jquery.scrollTo-1.4.2-min.js"></script>
					<script type="text/javascript" src="js/jquery.localscroll-1.2.7-min.js"></script>
					<script type="text/javascript" src="js/jquery.serialScroll-1.2.2-min.js"></script>
					<script type="text/javascript" src="js/coda-slider.js"></script>';
	} 
	else 
	{
		$htmlOut = '<h1>'.WBG_HELPER::insertCatTitle().'</h1>
					<div id="slider">
			       		<form methog="get" id="sortBox" action="">
			       			'.$portfolioOut->getSortingForm().'
			       		</form>   
			            <ul class="navigation">
			            	<li>&nbsp;</li>
			            </ul><br/>
			            '.WBG_HELPER::showErrorText('<p>Sorry, but looks like there are no project in this category</p>').'
			        </div>';
	}
	
} else {
	
	$condition = ' AND id='.$_GET['obj_id'];
	if ( $portfolioInstance = $portfolioOut->fetchElements( $condition ) ) 
	{
		$portfolioInstance = $portfolioInstance[0];
//		echo '<div id="sidebar-right">';
//		      WBG::module('banners_out');
//		echo '</div>';
		$htmlOut = $portfolioOut->showPortfolioInstance( $portfolioInstance );
	} 
	else 
	{
		$htmlOut = '<h1>'.WBG_HELPER::insertCatTitle().'</h1>
				    <div>'.WBG_HELPER::showErrorText().'</div>';
	}
	
}

/*============================================================================*/

$return_from_module = $htmlOut;

?>