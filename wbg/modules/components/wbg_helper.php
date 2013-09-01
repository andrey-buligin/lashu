<?php

class WBG_HELPER {

	/*****************************************************************************************/
	/**
	 * Funkcia dostajet vse kategorii v wbg i returnit array el[parent_id] = spisok el s takimze parentom
	 *
	 * @return unknown
	 */
	function getAllWbgCategories(){
		$sql_res = mysql_query("SELECT * FROM wbg_tree_categories");
		while ($arr = mysql_fetch_assoc($sql_res)) {
			@$wbgCats['parent_id'][] = $arr;
			//$wbgCats[$arr['id']]['parent_id'] = $arr['parent_id'];
		}
		return $wbgCats;
	}

	/**
	 * Funkcija vozvrawajet spisok detej konkretnoi wbg kategorii
	 *
	 * @param integer $id id kategorii
	 * @param boolean $getActive dostaem tolko aktivnie elementi
	 * @param boolean $getAllChilds dostaem vsex detej rekusrivno
	 * @param boolean $getOnlyCount vernutj tolko koli4estvo detej
	 * @return unknown
	 */
	function getCatChilds($id, $getActive = true, $getAllChilds = false, $getOnlyCount = false){
		global $web;

		if ($getActive) {
			$condition = ' AND active=1 AND enabled=1';
		} else {
			$condition = '';
		}

		if ($getOnlyCount) {
			$sqlStr = "SELECT count(*) FROM wbg_tree_categories WHERE parent_id=".$id." ".$condition;
			return @mysql_result(mysql_query($sqlStr),0,0);
		}

		$childs  = array();
		$sqlStr  = "SELECT * FROM wbg_tree_categories WHERE parent_id=".$id." ".$condition." ORDER BY sort_id";
		$sql_res = mysql_query($sqlStr);
		while ($arr = mysql_fetch_assoc($sql_res)) {
			$childs[$arr['id']] = $arr;
			if ($getAllChilds) {
				$childs[$arr['id']]['childs'] = self::getCatChilds($arr['id'], $getActive, true);
			}
		}
		return $childs;
	}

	/**
	 * Funkcija dostajet danie o konkretnom elemente v wbg kategorii
	 *
	 * @param unknown_type $id
	 * @return unknown
	 */
	function getCatData($id){
		return @mysql_fetch_assoc(mysql_query("SELECT * FROM wbg_tree_categories WHERE id=".$id));
	}

	function catPropertyExists(&$params, $field){
		if (!is_array($params)) $params = @unserialize($params);
		if (!empty($params[$field])){
			return true;
		}
		return false;
	}

	function getProperty(&$params, $field){
		if (!is_array($params)) $params = @unserialize($params);
		if (!empty($params[$field])){
			return $params[$field];
		}
		return false;
	}

	function getCatPropImage($imageParams = ''){
		global $web;

		$cat   = $web->active_category;
		$props = @unserialize($web->category_data[$cat]['properties']);
		if (!empty($props['foto'])){
			return self::insertImage($props['foto'], $imageParams).'<br class="spacer" />';
		}
	}

	/*****************************************************************************************/
	/**
	 * Function is used to transfer capslock tags to smallcaps..adds ending tag "/" to image i brake html elements, inserts "" in tag params
	 *
	 * @param string $string input HTML
	 */
	function transferToXHTML($string){

		//echo '<!--'.$string.'-->';
		$upcasedTags 	= array("/<(\/?)A(.*?)>/", "/<(\/?)P>/", "/<(\/?)SPAN>/", "/<BR(\/?)>/", "/<(\/?)DIV>/", "/<(\/?)B>/",
								"/<(\/?)U>/", "/<(\/*)I>/", "/<(\/*)FONT>/", "/<(\/*)CENTER>/", "/<(\/*)STRONG>/",
								"/<(\/?)TD>/", "/<(\/?)TH>/", "/<(\/?)TR>/", "/<(\/?)TBODY>/", "/<(\/?)TABLE>/", "/<(\/?)LI>/", "/<(\/?)UL>/", "/<(\/?)OL>/");
								//td,tr,table,TBODY
		$downcasedTags 	= array("<$1a$2>", "<$1p>", "<$1span>", "<br/>", "<$1div>", "<$1b>", "<$1u>", "<$1i>", "<$1font>", "<$1center>", "<$1strong>",
								"<$1td>", "<$1th>", "<$1tr>", "<$1tbody>", "<$1table>", "<$1li>", "<$1ul>", "<$1ol>");
		$string = preg_replace($upcasedTags, $downcasedTags, $string);
		$string = str_replace("<br>", "<br/>", $string);

		//replacim param->value vnutri tagov tip <a href=zopa> na ix zhe tok s zakritimi skobkami <a href="zopa">
		$string = preg_replace("/<(.*?) ([a-zA-Z0-9_]+)=([a-zA-Z0-9_]+)(.*?)\>/", "<$1 $2=\"$3\"$4>", $string);
		$string = preg_replace("/<(.*?) ([a-zA-Z0-9_]+)=([a-zA-Z0-9_]+)(.*?)\>/", "<$1 $2=\"$3\"$4>", $string);

		//class=wysiwyg_link

		//images regulation
		$string = preg_replace("/<img ([^<]+)\">/", "<img $1\"/>", $string);
		$string = preg_replace(array('/vspace="[0-9]*"/', '/hspace="[0-9]*"/', '/align=""/'), "", $string);
		$string = preg_replace_callback('/<img (.*?)\/>/', 'imgAttributes', $string);

		$string = preg_replace('/target="_self"/', "", $string);
		$string = preg_replace('/target="_blank"/', 'rel="external"', $string);
		return  $string;
	}

	/*****************************************************************************************/
	/**
	 * Funkcija vstavki imaga pod XHTML format
	 *
	 * @param array $image masiv imaga(vozmozen serialaiznutij)
	 * @param string $style dopolnitelnie parametri imaga
	 * @param string $src - src imaga
	 * @param integer $resize - nr resaiznutoi kartinki 4to nada vstavitj
	 * @return unknown
	 */
	function insertImage($image, $style = '', $src = null, $resize = '')
	{
		if ( $src )
			return '<img '.$style.' src="images/'.$src.'" />';

		if ( !is_array($image) )
			$image = unserialize($image);

		if ($resize AND @$image['resized'][$resize]){
			return '<img '.$style.' src="images/'.$image['resized'][$resize].'" alt="'.$image['alt'].'" title="'.$image['alt'].'"/>';
		}
		if ($image['src']) {
			return '<img '.$style.' src="images/'.$image['src'].'" alt="'.$image['alt'].'" title="'.$image['alt'].'"/>';
		}
	}

	/**
	 * Funkcija insertit JS cod pod XHTML standart
	 *
	 * @param string $js javascript kod
	 * @return unknown
	 */
	function insertScript($js){
		if ($js) {
			return '<script type="text/javascript">
						//<![CDATA[
							'.$js.'
						//]]>
					</script>';
		}
	}

	/**
	 * Funkcija vstavlajet link s vnutrenim html`om na popup
	 *
	 * @param string $popupSrc url popupa
	 * @param string $innerHtml vnutrenij ancor html
	 * @param string $style opcii i style dlja samovo ankora
	 * @param integer $popupWidth width popupa
	 * @param integer $popupHeight height popupa
	 * @return unknown
	 */
	function insertPopup($popupSrc, $innerHtml, $style = '', $popupWidth = '600', $popupHeight = '600'){
		global $_CFG;

		$onClick = "open('".$popupSrc."', '', ' resizable=yes, scrollbars=yes, width=".$popupWidth.", height=".$popupHeight."');return false;";
		return '<a href="#" '.$style.' onclick="'.$onClick.'">'.$innerHtml.'</a>';
	}

	/**
	 * Funkcija dostajet title categorii iz WEB var`a
	 *
	 * @param integer $id id kategorii,jesli neukazana vivodim aktivnuju
	 * @return unknown
	 */
	function insertCatTitle($id = ''){
		global $web;
		if (!$id) $id = $web->active_category;
		return $web->category_data[$id]['title'];
	}

	/**
	 * Funkcija lozhit nekij html v nekij tag s atributami
	 *
	 * @param string $tag sam tag
	 * @param string $str html kotorij lozhim v tag
	 * @param string $attribs atributi i opcii taga
	 * @return unknown
	 */
	function placeInTags($tag = null, $str = null, $attribs = null) {
		if (!$str OR !$tag) return ;
		return '<'.$tag.' '.$attribs.'>'.$str.'</'.$tag.'>';
	}

	/*****************************************************************************************/
	/**
	 * Funkcija url-encodit vse zna4enija parametrov peredavaemix v url`e
	 *
	 * @param string $url
	 * @return string
	 */
	function SmartUrlEncode($url){

	    if (strpos($url, '=') === false){
	        return $url;
	    } else {
			$startpos 	= strpos($url, "?");
			$tmpUrl 	= substr($url, 0 , $startpos+1) ;
			$qryStr		= substr($url, $startpos+1 ) ;
			$qryValues	= explode("&", $qryStr);
			foreach($qryValues as $value){
				$buffer = explode("=", $value);
				$qryOut[]= $buffer[0].'='.urlencode($buffer[1]);
			}
			return $tmpUrl.implode("&amp;", $qryOut);
	    }
	}

	 /**
	 * Funkcija vozvrawaet normalnij otparwenij WBG_link jesli evo nada vernutj bez RETURN_FROM_MODULE
	 * ( jest problemi pri generacii linka na document- vstavlaetsa ins_link kod)
	 *
	 * @param string $link - link iz WBG::crosslink polja
	 * @return string link
	 */
	function getLink($link) {

		$link = str_replace("ins_crosslink", "WBG::crosslink", $link);
		if (strpos($link,'WBG::crosslink')) {
			$orig = array("<?php", "?>", "echo");
			$repl = '';
			$link_str = str_replace($orig, $repl, $link);
			$link = eval("return ".$link_str.";");
	//		$parts = explode("'", $link_str);
	//		if (@$parts[1]){
	//			$doc = '?doc='.$parts[1];
	//		}else {
	//			$doc = '';
	//		}
		}
		return self::SmartUrlEncode($link);
	}

	/*****************************************************************************************/
	/**
	 * Funkcija generacii tropi
	 *
	 * @param string $curObject title tekuwevo objekta(dokumenta)
	 * @return unknown
	 */
	function breadCrumbs($curObject = null){
		global $web;

		$out = '';
		foreach ($web->active_tree as $key => $value) {
			$out[] = '<a href="'.SmartUrlEncode(WBG::crosslink($value)).'">'.$web->category_data[$value]['title'].'</a>';
		}
		if ($curObject){
			$out[] = $curObject;
		}
		if ($out) {
			return '<div id="breadcrumbs">'.implode(" → ", $out).'</div>';
		}
	}

	/*****************************************************************************************/
	/**
	 * Funkcija generit page title i lozhit evo v globalnij var $page_title
	 *
	 */
	function generatePageTitle(){
		global $web;
		global $page_title;

		$docTitle = self::getDocumentTitle();
		if ($docTitle)
		{
			$page_title = $docTitle;
			return;
		}

		if ( isset( $_GET['tag'] ) )
		{
		    $page_title = ' Search results for tag "'.htmlspecialchars( $_GET['tag'] ).'"';
			return;
		}

		$propertiesCatTitle = @WBG::category("current", "inner", "title", null, null, true, false);
		if (trim($propertiesCatTitle))
		{
			$page_title = $propertiesCatTitle;
		}
		else
		{
			foreach ($web->active_tree as $key => $value) {
				if ($key == 0) continue;
				$out[] = $web->category_data[$value]['title'];
			}
			$page_title = WBG::message('page_title', 0, 1).' - '.implode(" . ", $out);
		}
	}

	/**
	 * Function return document/article title if we r currently viewing it
	 */
	function getDocumentTitle()
	{
		global $web;

		$docTitle = '';
		if (isset($_GET['prod'])){
			//produkt
			$docTitle = @mysql_result(mysql_query("SELECT title_".$web->lang_prefix." FROM _mod_products WHERE id=".$_GET['prod']),0,0);
		} elseif (isset($_GET['obj_id'])){
			//projekt
			$docTitle = @mysql_result(mysql_query("SELECT title_".$web->lang_prefix." FROM _mod_portfolio WHERE id=".$_GET['obj_id']),0,0);
			if ($docTitle) $docTitle = WBG::message('page_title', 0, 1).' - Portfolio - '.$docTitle;
		} elseif (isset($_GET['doc'])){
			//otkritij dokument
			$props = @unserialize(mysql_result(mysql_query("SELECT content FROM _mod_textlist WHERE id=".$_GET['doc']),0,0));
			if ($props['title']){
				$docTitle = WBG::message('page_title', 0, 1).' - '.$props['title'];
			}
		}
		return $docTitle;
	}
	/*****************************************************************************************/

	/**
	 * Funkcja generirujet meta description and keywrods tagi.
	 * @param unknown_type $type
	 */
	function generatePageMetaTag( $type = 'description' )
	{
		if ( $type != 'keywords') {
		  $appendText = WBG::message('page_description', 0, 1);
		} else {
		  $appendText = WBG::message('page_keywords', 0, 1);
		}
		$metaText	= '';
		$docTitle = self::getDocumentTitle();

		if ($docTitle)
		{
			$metaText = $docTitle;
		}
		else
		{
			$propertiesMeta = WBG::category("current", "inner", $type, null, null, true, false);
			if ( trim($propertiesMeta) )
			{
				$metaText = $propertiesMeta;
				$appendText = '';
			}
		}
		return $appendText.$metaText;
	}

	/*****************************************************************************************/

	function getTarget($target){
		if ($target == '_blank') {
			return 'rel="external"';
		}
	}

	/**
	 * Function shows error message. Used in case if something on page went wrong.
	 */
	function showErrorText( $msg = '' ) {

		if (!$msg)
			$msg = '<p>Sorry but requested content has not been found. <br/>
					Possible reasons for that:
					</p>
					<ul>
						<li>Content has been removed</li>
						<li>Content has been moved to another location</li>
						<li>URL you typed in is wrong. Please check it again</li>
					</ul>';
		return '<div class="error_page">'.$msg.'</div>';
	}
}

	function imgAttributes($matches){

		$return = $matches[1];
		if (!preg_match('/alt="/', $matches[1])) {
			$return .= ' alt=""';
		}
		if (preg_match('/align="([a-z]+)"/', $matches[1], $align)) {
			if ($align[1] == 'right') {
				$style = 'float:right; ';
			} elseif ($align[1] == 'left'){
				$style = 'float:left; ';
			} else {
				$style = '';
			}
			$return = str_replace(array('style="', $align[0]), array('style="'.$style, ''), $return);
		}
		return '<img '.$return.' />';
	}
?>