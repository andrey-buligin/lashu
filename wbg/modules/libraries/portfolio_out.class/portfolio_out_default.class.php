<?php

include_once( dirname(__FILE__).'/../../components/url_manager.php' );

class PortfolioOut 
{
		
		static public $TABLE;
		public $category;
		public $lang;
		public $pages;
		public $elements;
		public $itemsOnPage;
		
		/*****************************************************************/
					
			/**
			 * CONSTRUCTOR -initialization
			 *
			 * @param ID of category (integer) 						 - $category
			 * @param name of doc ID(if need to count shows)(string) - $id_name
			 * @param array(submit name=>email to sent)  - $post_submit_buttons
			 */
			
			function __construct( $category = null, $itemsOnPage = 8 ) {
				global $_CFG;
				global $web;
								
				self::$TABLE 		= '_mod_portfolio';
				$this->lang  	  	= $web->lang_prefix;
				$this->category		= $category;
				$this->itemsOnPage  = $itemsOnPage;
				$this->pages 		= array();
			}
			
		/*****************************************************************/
		// [[[ SHOWING LIST OF ELEMENTS
		
			function getNavigation() {
				
				$pagination = '';
				if ( $this->pages ) {
					foreach ($this->pages as $pageId => $pageTitle) {
						$pagination .= '<li><a href="#page'.$pageId.'">'.$pageTitle.'</a></li>';
					}
				}
				return $pagination;
			}
			
			function checkActions() {
				
				$condition = '';
				
				if ( isset($_GET['wbg_cat']) ) {
					$statment = "SELECT id, title, dir FROM wbg_tree_categories WHERE active=1 and enabled=1 and id=".$_GET['wbg_cat'];
					if ( $category = @mysql_fetch_assoc(mysql_query($statment)) ) {
						$condition = " AND category_id = ".$category['id'];
					}
				}
				
				return $condition;
			}
			
			function fetchElements( $condition = '' ){
				
				$elements = array();
				
				$sql_res = mysql_query("SELECT * FROM ".self::$TABLE." WHERE active=1 ".$condition." ORDER BY is_latest DESC, category_id ASC, sort_id ASC");
				while ($arr = @mysql_fetch_assoc($sql_res)) {
					$elements[]= $arr;
				}
				
				return $elements;
			}
			
			function setElements( $elements ){
				$this->elements = $elements;
				$this->setPages( count($elements) );
			}
			
			function setPages( $itemsCount ){
				$pages = ceil($itemsCount / $this->itemsOnPage);
				for ($index = 0; $index < $pages; $index++) {
					$this->pages[$index] = 'Page '.($index+1);
				}
			}
			
			function showContent() {
				global $web;
				
				$return = '';
				$page   = 0;
				
				if ( $this->elements ){
					$return = '<div class="panel" id="page'.$page++.'">';
					foreach ($this->elements as $index => $element) {
						//TODO change to real pages functionality
						if ( $index % $this->itemsOnPage == 0 AND $index > 0 ) $return .= '</div><div class="panel" id="page'.$page++.'">';
						$return .= $this->_getElementHtml( $element, $index );
					}
					if ( $index != $this->itemsOnPage) $return .= '</div>';
				}

				return $return;
			}
			
			function _getElementHtml($arr, $counter){
				global $web;
				
				if ( isset($arr['image_small']['src']) ){
					$img = WBG_HELPER::insertImage($arr['image_small']);
				} else {
					$img = '<img src="images/building/garden_2_hires.jpg" alt="No image" />';
				}
				
				return  '<div class="boxgrid captionfull">
							'.$img.'
							<div class="cover boxcaption">
								<h3>'.$arr['title_eng'].'&nbsp;&nbsp;<a href="'.URL_MANAGER_HELPER::makeUrl( null, $arr ).'">more</a></h3>
								<p><a href="http://'.str_replace('http://','',$arr['url']).'" target="_blank">'.$arr['url'].'</a></p>
							</div>
						</div>';
			}
			
		// ]]] SHOWING LIST OF ELEMENTS
		/*****************************************************************/
		// [[[ SHOWING ONE ELEMENT
		
			function showPortfolioInstance( $arr ) {
				global $web;
				
				if ( isset($arr['image_small']['src']) ){
					$img = WBG_HELPER::insertImage($arr['image_big'], ' ');
				} else {
					$img = '';
				}
				if ( isset($_SESSION['last_viewed_portfolio_page']) ) {
					$backLink = $_SESSION['last_viewed_portfolio_page'];
				} else {
					$backLink = URL_MANAGER_HELPER::makeUrl( $_GET['wbg_cat'] );
				}
				return '<h1>'.$arr['title_eng'].'</h1>
					    <div id="portfolio_object">
					    	<p class="url">Website URL: <a href="'.$arr['url'].'" target="_blank">'.$arr['url'].'</a></p>
					    	'.$img.'
					    	<p class="description">'.$arr['description_eng'].'</p>
					    	<span class="readmore"><a href="'.$backLink.'">&lt;&lt;&lt; Back to list</a></span>
					    </div>';
			}
			
		// ]]] SHOWING ONE ELEMENT
		/*****************************************************************/
		// [[[ SHOWING ATTACHED GALLERY
		
			function getSortingForm() {
				
				$options = '<option value="'.WBG::crosslink(WBG::mirror(35)).'">All</option>';
				
				$sql_res = mysql_query("SELECT id, title, dir FROM wbg_tree_categories WHERE active=1 and enabled=1 and parent_id=".$this->category." ORDER BY sort_id ");
				while ($arr = @mysql_fetch_assoc($sql_res)) {
					$options .= '<option value="'.URL_MANAGER_HELPER::makeUrl( $arr['id'] ).'" '.( $arr['id'] == @$_GET['wbg_cat']?'selected="selected"':'' ).'>'.$arr['title'].'</option>';
				}
				
				return '<label for="show">Filter by: </label>
						<select name="show" onchange="document.location.href=this.value" id="show">'.$options.'</select>';
			}
			
		// ]]] SHOWING ONE ELEMENT
		/*****************************************************************/
		
			
}

?>