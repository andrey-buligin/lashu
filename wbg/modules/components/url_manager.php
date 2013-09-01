<?php

/**
 *
 * Url manager is used to create SEO friendly urls for Blog posts, Portfolio objects and
 * wbg categories which are not supposed to have URL because they are considered as stystem tree categories.
 *
 * @author Bula
 *
 */
class UrlManager
{
    /**
     *
     * Returns SEO friendly url for wbg system category
     * @param int $categoryId
     */
	public function getWbgCategoryUrl( $categoryId = null )
	{
	    return $this->_getCategoriesUrl( $categoryId );
	}

	/**
	 *
	 * Returns SEO friendly url for portfolio object
	 * @param array $portfolioObject
	 */
	public function getPortfolioItemUrl( $portfolioObject = array() )
	{
	   global $web;

	   $titleField = 'title_'.$web->lang_prefix;
	   $urlToPortfolioObject = $this->_getCategoriesUrl( $portfolioObject['category_id'] );
	   if ( !empty( $portfolioObject[$titleField] ) )
			$urlToPortfolioObject .= self::_prepareUrlText( $portfolioObject[$titleField] ).'-P'.$portfolioObject['id'].'.html';

	   return $urlToPortfolioObject;
	}

	/**
	 *
	 * Returns SEO friendly url for blog post (article)
	 * @param unknown_type $blogPost
	 */
	public function getBlogPostUrl( $blogPost = array() )
	{
	   $urlToBlogPost = $this->_getCategoriesUrl( $blogPost['category_id'] );
	   if ( !empty( $blogPost['title'] ) )
			$urlToBlogPost .= self::_prepareUrlText( $blogPost['title'] ).'-B'.$blogPost['id'].'.html';

	   return $urlToBlogPost;
	}

	function _getCategoriesPath( $categoryId = null )
	{
	    if ( is_numeric( $categoryId ) )
	    {
    	    while ( $categoryId != 0 )
    	    {
    			$sqlStr = "SELECT id, title, type, parent_id FROM wbg_tree_categories WHERE id=".$categoryId;
    			$cat    = mysql_fetch_assoc( mysql_query($sqlStr) );
    			$categoryId = $cat['parent_id'];
    			if ( $categoryId != 0 OR $cat['type'] == 1 )
    				$URL[$cat['id']] = $cat['title'];
    		}

    		return $URL;
	    }

	    return false;
	}

	private function _getCategoriesUrl( $categoryId = null, $categoriesPath = null, $setNoCategoryId = null )
	{
	    global $web;
	    global $_CFG;

	    if ( $categoriesPath === null )
	        $categoriesPath = $this->_getCategoriesPath( $categoryId );

	    if ( is_array( $categoriesPath ) and !empty( $categoriesPath ) )
	    {
	        $categoriesUrl = '';
    	    foreach ( $categoriesPath as $catId => $category )
    	    {
    			$categoriesUrl = self::_prepareUrlText($category).((!$categoriesUrl && !$setNoCategoryId) ? '-C'.$catId : '').'/'.$categoriesUrl;
    	    }
    		return 'http://'.$_CFG['path_url_full'].$web->lang_prefix.'/'.$categoriesUrl;
	    }

	    return false;
	}

	static function _prepareUrlText($string)
	{
		$latSimbols = array("�?", "�?", "ē", "ģ", "ī", "ķ", "ļ", "ņ", "š", "ū", "ž");
		$latSimbolsReplace = array("a", "c", "e", "g", "i", "k", "l", "n", "s", "u", "z");
		$string = str_replace($latSimbols, $latSimbolsReplace, $string);
		$NOT_acceptable_characters_regex = '/[^-a-zA-Z0-9_ ]/';
		$string = preg_replace($NOT_acceptable_characters_regex, '', $string);
		$string = strtolower(trim($string));
		$string = preg_replace('/[-_ ]+/', '-', $string);

		return $string;
	}
}
?>