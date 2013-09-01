<?php

/**
 * Class SearchWizard makes searching funkctions
 * shows 2 different seach forms ( as a block and form in module)
 *
 */
class SearchWizard{
	
	protected static $wizardSubmit;
	protected static $moduleSubmit;
	protected static $method;
	
	/**
	 * Construktor of object
	 *
	 * @param string $method Method of form data submition
	 * @param string $wizardSubmit Name of submit button for block  
	 * @param string $moduleSubmit Name of submit button for module 
	 */
	function __construct($method = 'get', $wizardSubmit = 'wizard_form', $moduleSubmit = 'module_form'){
		
		$this->method 		= $method;
		$this->wizardSubmit = $wizardSubmit;
		$this->moduleSubmit = $moduleSubmit;
	}
	
	/**
	 * Checking our reguests, if button was subbmited we return result
	 *
	 * @return string
	 */
	function checkEvents(){

		if ($this->method == 'get') {
			$method = @$_GET;
		} else {
			$method = @$_POST;
		}
		$results = '';
		if (isset($method[$this->moduleSubmit])) {
			$results = self::search($method);
		}elseif (isset($method[$this->wizardSubmit])) {
			$results = self::search($method);
		}
		if ($results['products']) {
			echo self::showResults($results);
		} else {
			WBG::message("nekas_nav_atrasts");
		}
	}
	
	/**
	 * Showing search block type form at right side on every page
	 *
	 * @return unknown
	 */
	function showWizardForm(){
		global $web;
		
		if (isset($_GET['search_text'])) {
			$val = $_GET['search_text'];
		} else {
			$val = WBG::message("ievadiet_vardu",null,1);
		}
		return '<form method="'.$this->method.'" name="wizard_form" id="wizard_form" action="'.WBG::crosslink(WBG::mirror(41)).'">
					<div id="searchBox">
						<input id="search" nclick="document.forms[\'wizard_form\'].submit();return false;" title="'.WBG::message("meklet",null,1).'" type="image" src="images/building/search.gif" />
						<input type="text" name="search_text" value="'.$val.'" style="width:120px" />
					</div>
					<input type="hidden" name="'.$this->wizardSubmit.'" value="'.$this->wizardSubmit.'"/>
				</form>';
	}
	
	/**
	 * Generating one row for block type form
	 *
	 * @param string $name Name of select
	 * @param string $title Title for current row
	 * @param array $values Array of options
	 * @return unknown
	 */
	function _showWizardRow($name, $title, $values){
		
		if ($this->method == 'get') {
			$method = @$_GET;
		} else {
			$method = @$_POST;
		}
		
		$options = '';
		foreach ($values as $key => $value) {
			$options .= '<option value="'.$key.'" '.(@$method[$name] == $key ? 'selected':'').'>'.$value.'</option>';
		}
		return  '<tr>
					<td class="text">'.$title.':</td>
					<td class="input">
						<select name="'.$name.'">'.$options.'</select>
					</td>
				</tr>';
	}
	
	/**
	 * Showing search form at search page ( in module).
	 *
	 * @return unknown
	 */
	function showModuleForm(){
		
		return '<form method="'.$this->method.'" name="modul_form" id="modul_form" style="font-size:12px; ">
					<table cellpadding="0" cellspacing="3" style="font-size:12px; ">
						'.self::_showWizardRow('type',  'Type',  array('', 'test','test2')).'
						'.self::_showWizardRow('stone', 'Stone', array('', 'test','test2')).'
						'.self::_showWizardRow('metal', 'Metal', array(0=>'', 1=>'Серебро', 2=>'test2', 3=>'Золото')).'
						'.self::_showWizardRow('price', 'Price', array('', 'test','test2')).'
						'.self::_showWizardRow('promo', 'Promo', array('', 'test','test2')).'
						<input type="hidden" name="'.$this->moduleSubmit.'" value="'.$this->moduleSubmit.'"/>
					</table>
					<div class="links">
						<a href="" onclick="document.forms[\'modul_form\'].submit();return false;" class="button">'.WBG::message("meklet",null,1).'</a>
					</div>
				</form>';
	}
	
	/**
	 * Returning search results
	 *
	 * @param array $found Data found during search
	 * @return string
	 */
	function showResults($results){
		
		$products    = $results['products'];
		$productsOut = '';
		$productsMgr = new products;	
		$productsMgr->init('_mod_products');
	
		if ($products) {
			$x = 0;
			foreach ($products as $product) {
				$class = (++$x%3==0 ? ' last':'');
				$productsOut .= $productsMgr->_get_prod_info($product, $class);
			}
		}
		return '<div style="padding:0px 0 0 10px; margin-bottom:10px; font-size:12px;">
				'.WBG::message("atrasti",null,1).': <b>'.$results['totalFound'].'</b> '. WBG::message("produkti",null,1).'
				</div>'.
				$productsOut.
				'<br class="spacer" />'.
				$results['pagelist'];
	}
	
	/**
	 * Search function by itself. We search for specific products in catalog
	 * after some criterias.
	 *
	 * @param array $data Data sended to us(post or get)
	 * @return array Products found
	 */
	function search($data){
		global $web;
		
		
		$condition = '';
		$products  = array();
		$prefix	   = $web->lang_prefix;
		
		if (!$data['search_text']) {
			return array('products'=>$products, 'pagelist'=>'ievadiet vardu', 'totalFound'=>0);
		}
		/*==================================================================================*/
		// [[[ conditon generating
		
			$condition .= " AND (artikuls LIKE '%".$data['search_text']."%' ";
			$condition .= " OR title_".$prefix." LIKE '%".$data['search_text']."%'";
			$condition .= " OR text_".$prefix." LIKE '%".$data['search_text']."%'";
			$condition .= " )";
			
		// ]]] conditon generating
		/*==================================================================================*/

		$totalFound = @mysql_result(mysql_query("SELECT count(*) FROM _mod_products WHERE active=1 ".$condition),0,0);
		$pagelist 	= pagelist($totalFound, $LIMIT, 3);
		
		$sql_str = "SELECT * FROM _mod_products WHERE active=1 ".$condition." ORDER BY title_".$prefix.", price ".$LIMIT;
		$sql_res = mysql_query($sql_str);
		while ($arr = mysql_fetch_assoc($sql_res)) {
			$products[$arr['id']] = $arr;
		}
		
		return array('products'=>$products, 'pagelist'=>$pagelist, 'totalFound'=>$totalFound);
	}
}
?>