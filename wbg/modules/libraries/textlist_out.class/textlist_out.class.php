<?php

include_once(dirname(__FILE__).'/../../components/show_comments.php');
include_once(dirname(__FILE__).'/../../components/pagelist.php');
include_once(dirname(__FILE__).'/../../components/url_manager.php');

/*======================================================================
 * MAIN TEXT LIST OUT CLASS
 ======================================================================*/

class TextListOut
{

	static public $TABLE;
	static public $CATEGORY;
	static public $LANG;
	static public $showNoTitle;
	static private $DB;
	static private $owners;
	public $listItems   = array();
	public $openedDoc   = null;
	public $itemsOnPage = 5;
	public $pagelistHTML= 5;

	/*****************************************************************/

		/**
		 * CONSTRUCTOR -initialization
		 *
		 * @param table name(string)							 - $table
		 * @param ID of category (integer) 						 - $category
		 * @param name of doc ID(if need to count shows)(string) - $id_name
		 * @param array(submit name=>email to sent)  - $post_submit_buttons
		 */

		function __construct( $table, $category = null, $id_name = 'smthing', $post_submit_buttons = array())
		{
			global $_CFG;
			global $web;

			TextListOut::$TABLE 	= $table;
			TextListOut::$LANG 		= $web->lang_prefix;
			TextListOut::$CATEGORY	= $category;
			TextListOut::$DB		= $_CFG['sql']['pdo'];
			TextListOut::checkEvents($id_name, $post_submit_buttons);
			$this->showNoTitle = false;
		}

	/*****************************************************************/
	// [[[ CHECKING FOR GET and POST EVENTS

		/*
		 *  Function checks for any submited buttons.
		 */
		function checkEvents($id_name, $post_submit_buttons)
		{
			global $web;
			global $_CFG;

			if (isset($_GET[$id_name])) {// COUNTING VIEWS OF DOCUMENT
				mysql_query("UPDATE ".self::$TABLE." SET show_count = IF (ISNULL(show_count), 0, show_count) + 1 WHERE id=".$_GET[$id_name]);
			}

			if ($post_submit_buttons) {	 //SENDING FORMS THAT ARE IN TEXTLIST
				foreach ($post_submit_buttons as $submit_name => $email) {
					if (isset($_POST[$submit_name])) {

						$header = "From:info@".$_SERVER['SERVER_NAME']."\n";
						$header .= "Content-Type: text/plain; charset=utf-8";
						$msg 	.= "Current category: ".$web->category_data[$web->active_category]['title']." (ID:".$web->active_category.")";

						foreach ($_POST as $key => $value) {
							$msg .= $key.": ".$value."\n";
						}

						mail($email, "=?UTF-8?B?".base64_encode("Jaunums")."?=", $msg, $header);
					}
				}
			}
		}

	// ]]] CHECKING FOR GET and POST EVENTS
	/*****************************************************************/
	// [[[ ADDING STYLES

		/**
		 *
		 * Function returns inline styling
		 */
		function add_styles()
		{
			return '<style>
						#data_title		{ margin-bottom:10px; font-size:16px !important;color:#004b96;font-weight:bold;}
						#data-list		{ color:#005190; padding-right:25px}
						#data-list img	{ margin-right:15px}
						#data-list .title	{ font-size:14px;font-weight:bold; margin-bottom:13px}
						#data-list .title a	{ font-size:14px;font-weight:bold; color:#005190;}
						#opendoc		{ padding-right:20px; font-size:12px;font-family:Tahoma;color:#274b8d}
					</style>';
		}

	// ]]] ADDING STYLES
	/*****************************************************************/

		function getPageListHtml()
		{
		    return $this->pagelistHTML;
		}

		function getPageTitle()
		{
		    if ( $this->showNoTitle == true )
				$header = '';
			else
				$header = WBG_HELPER::insertCatTitle();
			return $header;
		}

		function _getOwner( $id = 1)
		{
			if ( !isset($this->owners[$id]) )
			{
				$this->owners[$id] = mysql_fetch_assoc(mysql_query("SELECT * FROM wbg_users WHERE id=".$id));
			}
			return $this->owners[$id];
		}

		function getOpenedObject( $id = null )
		{
		    if ( $id )
		    {
    		    $query  = "SELECT * FROM ".self::$TABLE." WHERE id = ".$id;
    			if ( $object = mysql_fetch_assoc( mysql_query( $query ) ) )
    			    return $object;
		    }
		}

	/*****************************************************************/
	// [[[ SHOWING LIST OF ELEMENTS

        function setList( $newList = array() )
		{
		    $this->listItems = $newList;
		}

		function getList( $condition = null)
		{
			if ( !$condition)
			{
				if ( !@self::$CATEGORY )// SHOW ALL FOR SEARCH
					$condition = '';
				else
					$condition = "AND category_id=".self::$CATEGORY;//SHOW SOME CATEGORY
			}

			$LIMIT   = '';
			$query   = "SELECT count(*) FROM ".self::$TABLE." WHERE active=1 ".$condition;
			$counter = mysql_result(mysql_query($query),0,0);
			$this->pagelistHTML = pagelist( $counter, $LIMIT, $this->itemsOnPage );
			$query   = "SELECT * FROM ".self::$TABLE." WHERE active=1 ".$condition." ".$LIMIT;
			$sqlRes  = mysql_query( $query );

			while ( $element = mysql_fetch_assoc( $sqlRes ) )
			{
			    $this->listItems[] = $element;
			}

			if ( $counter == 1)
			    $this->openedDoc = $this->listItems[0];

			return $this->listItems;
		}

		function getListHTML()
		{
			if ( count( $this->listItems ) == 1)
			{
				return $this->showOneElement( $this->listItems[0] );
			}
			else
			{
				$htmlOut  = '';
				foreach ( $this->listItems as $key => $item)
				{
				    $htmlOut .= '<div>'.$this->_getElementHtml($item, $key).'</div>';
				}
				return $htmlOut;
		    }
		}

	// ]]] SHOWING LIST OF ELEMENTS
	/*****************************************************************/
	// [[[ GENERATING ONE ELEMENT IN LIST

		function _getElementHtml($arr, $x, $openedDoc = false)
		{
			global $_CFG;
			global $web;

			$urlManager = new urlManager();
			$content  = unserialize($arr['content']);
			$content['category_id'] = $arr['category_id'];
			$content['id'] = $arr['id'];
			$link 	  = $urlManager->getBlogPostUrl( $arr );

			if (!$openedDoc) {
				$class    = '';
				$readMore = '<a href="'.$link.'">Read more</a>';
			} else {
				$class    = ' last';
				$readMore = '';
			}
			if (isset($content['lead_img']['src'])){
				$img = '<a href="'.$link.'">'.WBG_HELPER::insertImage($content['lead_img'],' class="f-left"', null, 1).'</a>';
			} else {
				$img = '';
			}

			if ($content['date'] AND $content['time'])
			{
				$date = date("d.m.Y", $content['date']).' '.$content['time'];
			} else {
				$date = date("d.m.Y H:i", $arr['created']);
			}

			$author = $this->_getOwner( $arr['owner'] );

			return  '<div class="blog-item">
						<h2><a href="'.$link.'">'.$content['title'].'</a></h2>
						<p class="date"><span class="author">'.$author['I_name'].' '.$author['I_surname'].'</span> | '.$date.'</p>'.
						($content['embed'] ? '<div class="embed">'.$content['embed'].'</div>' : $img).'
						<div class="text clear-block"><p>'.$content['lead'].'</p></div>
						<span class="tags"><strong>Views</strong>: '.$this->getViewsCount( $arr['id'] ).'</span> |
						<span class="tags"><strong>Comments</strong>: <a href="">'.$this->getCommentsCount( $arr['id'] ).'</a></span> |
						'.$this->generateTagLinks( $content['tags'] ).'
						<div class="clear-block"></div>
					</div>';
		}

	// ]]] GENERATING ONE ELEMENT IN LIST
	/*****************************************************************/
	// [[[ SHOWING ONE ELEMENT

		function showOneElement( $id, $no_atpakal = false )
		{
			global $web;

			$js 	= '$imgArray = new Array();'."\n";
			$arr 	= mysql_fetch_assoc(mysql_query("SELECT * FROM ".self::$TABLE." WHERE id=".$id.' and active=1'));
			$content= unserialize($arr['content']);

			$content['time']  = $content['time'] ? $content['time'] : '';
			$content['lead']  = $content['lead'] ? $content['lead'] : '';

			$img = '';
			if (isset($content['text_img']['src'])){
				$img = WBG_HELPER::insertImage($content['text_img'],' class="f-left"', null, 1);
			} else {
				if (isset($content['lead_img']['src'])) {
					$img = WBG_HELPER::insertImage($content['lead_img'],' class="f-left"', null, 1);
				}
			}

			$back = '';
			if (!$no_atpakal) {
				$back = '<div class="readmore"><a href="'.WBG::crosslink($web->active_category).'"><<< '.WBG::message("back", null, 1).'</a></div>';
			}
			if ( $this->showNoTitle == true ) {
				$header = '';
			} else {
				$header = '<h1>'.$content['title'].'</h1>';
			}

			$this->increasViewsCount( $arr['id'] );
			return  '<div id="blog-page">
						<div class="blog-item opened">'.
							$header.
							($content['embed'] ? '<div class="embed">'.$content['embed'].'</div>' : $img).'
							<div class="text clear-block"><p>'.WBG_HELPER::transferToXHTML($content['text']).'</p></div>'.
							$this->generateTagLinks( $content['tags'] ).
							$back.
							'<div class="clear-block"></div>'.
							$this->showComments( $arr['id'] ).'
					 	</div>
					 </div>';
		}

	// ]]] SHOWING ONE ELEMENT
	/*****************************************************************/
	// [[[ SHOWING ATTACHED GALLERY

		function showGallery($content)
		{
			$htmlOut= '';
			$images = @$content['images'];
			if ($images){
				foreach ($images['small'] as $key => $imageSrc) {

					if ($images['big'][$key]){
						$link = 'class="group" rel="grup2" href="images/'.$images['big'][$key].'"';
					} else {
						$link = '';
					}
					$apraksts = $images['apraksts'][$key]?'<div>'.$images['apraksts'][$key].'</div>':'';
					$htmlOut  .= '<a '.$link.'>'.WBG_HELPER::insertImage('', ' style="margin-bottom:3px;" alt="'.$images['apraksts'][$key].'"', $imageSrc).'</a>'.$apraksts;
				}
			}
			$htmlOut = '<td id="fotoBlock">'.$htmlOut.'</td>';
			return $htmlOut;
		}

	// ]]] SHOWING ATTACHED GALLERY
	/*****************************************************************/
	//[[[ SHOW TAGS

		function generateTagLinks($tags)
		{
			$tagsOut = '';
			$tagsArr = explode(',', $tags);
			if (count($tagsArr) > 1 OR !empty( $tagsArr[0] ) ) {
				foreach ($tagsArr as $tag) {
					$tagsOut[] = '<a href="'.WBG::crosslink(WBG::mirror( 18 )).'?tag='.trim(htmlspecialchars($tag)).'">'.htmlspecialchars($tag).'</a>';
				}
				$tagsOut = '<span class="tags"><strong>Tags</strong>: '.implode(', ', $tagsOut).'</span>';
			}
			return $tagsOut;
		}

	//]]] SHOW TAGS
	/*****************************************************************/
	//[[[ GET ATTACHMENT

		function getAttachmnent($content, $type = 'for_one_doc')
		{
			global $_CFG;
			global $web;
			$attaches 	= '';
			$limit	  	= 3;
			$counter	= 0;

			if (@$content['files']  and !$web->print_mode)
			{
				$icons = array(
					"gif" => "word.gif",
					"jpg" => "word.gif",
					"doc" => "word.gif",
					"xls" => "excel.gif",
					"ppt" => "adobe.gif",
					"csv" => "excel.gif",
					"pdf" => "adobe.gif",
				);

				foreach ($content['files']['file'] as $key=>$value)
				{
					$counter++;
					$extension = strtolower(array_pop(explode(".",$value)));
					if ($type == 'for_one_doc') {
						$attaches .= '<a style="background:url(\'images/building/'.$icons[$extension].'\') left 2px no-repeat;" href="'.$_CFG['url_to_cms'].'tools/download.php?file='.$value.'"> - '.$content['files']['title'][$key].'</a>';
					} else {
						if ($counter <= $limit)
						$attaches .= '<a style="background:url(\'images/building/'.$icons[$extension].'\') left 2px no-repeat;" href="'.$_CFG['url_to_cms'].'tools/download.php?file='.$value.'"> - '.$content['files']['title'][$key].'</a>';
					}
				}
				if ($type == 'for_one_doc')
				{
					$attaches = '<div class="pievienotie">
									<div style="font-family:arial; font-size:11px; font-weight:bold; margin:5px 0px 10px 15px; text-transform:uppercase">'.WBG::message("lejupladet",null,1).':</div>
									<div style="margin-left:15px;">'.$attaches.'</div>
								</div>';
				} else {
					$attaches = '<div class="pievienots">
									<div>'.WBG::message("pievienotie_dokumenti",null,1).':</div>
									'.$attaches.'
								 </div>';
				}
			}
			return $attaches;
		}

	//]]] GET ATTACHMENT
	/*****************************************************************/
	//[[[ VIEWS COUNT

		function getViewsCount( $docId )
		{
			$query = "SELECT views FROM ".self::$TABLE." WHERE id = ".$docId;
			$res   = @mysql_fetch_assoc(mysql_query($query));
			if (!isset($res['views']))
			{
				$res['views'] = 0;
			}
			return $res['views'];
		}

		function increasViewsCount( $docId )
		{
			$query = "UPDATE ".self::$TABLE." SET views = views+1 WHERE id = ".$docId;
			$res  = mysql_query($query);
		}

	//]]] VIEWS COUNT
	/*****************************************************************/
	//[[ COMMENTYNG SYSTEM

		function showComments( $docId )
		{
			comments::init( $docId, self::$TABLE);
			return '<div id="formContainer">'.
						comments::show_form( $docId ).
					'</div>'.
				   comments::showFrontEndValidation().
				   comments::show_comments( $docId, self::$TABLE );
		}

		function getCommentsCount( $docId )
		{
			comments::init( $docId, self::$TABLE);
			return comments::showCommentsCount( $docId, self::$TABLE );
		}

	//]]] COMMENTYNG SYSTEM
	/*****************************************************************/
}

/*======================================================================
 * TEXT LIST OUT DECORATOR
 ======================================================================*/

	class TextListOut_Decorator {

		protected $textlist;
		protected $list;
		protected $doc;
		protected $docId;

		public function __construct(TextListOut $text_list_in, $doc = null) {
			$this->textlist = $text_list_in;
			if ($doc) {
				$this->docId = $doc;
				$this->doc = $this->textlist->showOneElement($doc);
			} else {
				$this->resetOutput();
			}
		}

		//doing this so original object is not altered
		function resetOutput() {
			$this->list = $this->textlist->showList();
		}

		function showList( $condition = '') {
			$this->list = $this->textlist->showList( $condition );
			return $this->list;
		}

		function getList() {
			return $this->list;
		}

		function showOneDoc() {
			return $this->doc;
		}
	}

/*======================================================================
 * TEXT LIST DECORATOR ( LIST WITH TITLE)
 ======================================================================*/

	class TextListOut_withTitle extends TextListOut_Decorator {

		private $textlist_list;

		public function __construct(TextListOut_Decorator $instance_in) {
			$this->textlist_list = $instance_in;
		}

		function addTitle( $title = '') {
			global $web;
			if ( !$title ) {
				$title = '<h1>'.$web->category_data[$web->active_tree[1]]['title'].'</h1>';
			} else {
				$title = '<h1>'.$title.'</h1>';
			}
			$this->textlist_list->list = $title.$this->textlist_list->list;
		}

		function addDocTitle() {
			global $web;
			$cont  = @unserialize(mysql_result(mysql_query("SELECT content FROM _mod_textlist WHERE id=".$this->textlist_list->docId),0,0));
			$title = '<h1>'.$cont['title'].'</h1>';
			$this->textlist_list->doc = $title.$this->textlist_list->doc;
		}

		function addTitleAndBackLink() {
			global $web;

			if ($web->active_tree[1] == WBG::mirror(16)) {
				if (isset($_GET['doc'])) {
					//$onClick = 'href="#" onclick="history.go(-1);"';
					$onClick = 'href="'.WBG::crosslink($web->active_category).'"';
				} else {
					$onClick = 'href="'.WBG::crosslink(WBG::mirror(16)).'"';
				}
			} else {
				//$onClick = 'href="#" onclick="history.go(-1);"';
				$onClick = 'href="'.WBG::crosslink($web->active_category).(isset($_GET['filter'])?'?filter='.$_GET['filter']:'').'"';
			}
			$title = '<h1 class="upcase">'.$web->category_data[$web->active_tree[1]]['title'].' <a class="pink" '.$onClick.'>'.WBG::message("atpakal_uz_sarakstu",null,1).'</a></h1>';
			$this->textlist_list->doc = $title.$this->textlist_list->doc;
			$this->textlist_list->list = $title.$this->textlist_list->list;
		}
	}

/*======================================================================
 * TEXT LIST DECORATOR ( LIST WITH END)
 ======================================================================*/

	class TextListOut_withEnd extends TextListOut_Decorator {

		private $textlist_list;

		public function __construct(TextListOut_Decorator $instance_in) {
			$this->textlist_list = $instance_in;
		}

		function addEnd() {
			$this->textlist_list->list = $this->textlist_list->list."<div>TITLE AT THE END</div>";
		}
	}

?>