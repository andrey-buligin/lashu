<?php

/*======================================================================
 * BANERS CLASS
 ======================================================================*/

class BANERS {

		static public $TABLE;
		static public $CATEGORY;
		static public $LANG;
		
		/*****************************************************************/
					
			/**
			 * CONSTRUCTOR -initialization
			 *
			 * @param table name(string)		- $table
			 * @param ID of category (integer) 	- $category
			 * @param name of doc ID(if need to count shows)(string) - $id_name
			 */
			
			function __construct($table, $category = null, $id_name = 'smtng') {
				global $web;
								
				BANERS::$TABLE 	 	= $table;
				BANERS::$LANG 	 	= $web->lang_prefix;
				BANERS::$CATEGORY	= $category;
				BANERS::checkEvents($id_name);
			}
			
		/*****************************************************************/
		// [[[ CHECKING FOR GET and POST EVENTS
		
			function checkEvents($id_name){
				global $web;
				global $_CFG;
				
				if (isset($_GET[$id_name])) {// COUNTING VIEWS OF DOCUMENT 
					self::incShowCount($_GET[$id_name]);
				}
			}
		
		// ]]] CHECKING FOR GET and POST EVENTS
		/*****************************************************************/
		// [[[ GETTING BANER LIST
		
            function getBaners($random = false, $limit = null, $withTitle = false){
				global $web;
				$HTML_out = '';
				
				($limit>0        ? $limit = 'LIMIT '.$limit : $limit = '');
				($random==false  ? $order = 'sort_id': $order = 'RAND()' );
				
				$SQL_str = "SELECT * FROM ".self::$TABLE." WHERE category_id = ".self::$CATEGORY." AND active=1 ORDER BY ".$order." ".$limit ;
				$sql_res = mysql_query($SQL_str);
				while ($arr = mysql_fetch_assoc($sql_res)) {
				    $foto = unserialize($arr['foto']);
				    
				    if ( !$withTitle ){
				        $HTML_out .= ($foto['src'] ? '<a href="'.$arr['link'].'" title="'.$arr['title'].'" target="'.$arr['target'].'">'.WBG_HELPER::insertImage($arr['foto']).'</a></br>' :'');
				    } else {
				        if ($arr['link']) {
				            $title = '<a href="'.$arr['link'].'" target="'.$arr['target'].'">'.$arr['title'].'</a>';
				        } else {
				            $title = $arr['title'];
				        }
					    $HTML_out .= '<div>'.
					                    '<p class="name">'.$title.'</p>'.
					    				($foto['src'] ? '<a href="'.$arr['link'].'" title="'.$arr['title'].'" target="'.$arr['target'].'">'.WBG_HELPER::insertImage($arr['foto']).'</a>' : '').
					                 '</div>';
				    }
				}
				
				return $HTML_out;
			}
			
		// ]]] GETTING BANER LIST
		/*****************************************************************/
		
			function incShowCount($id){
				mysql_query("UPDATE ".self::$TABLE." SET counter = counter+1 WHERE id = ".$id."");
			}
			
		/*****************************************************************/
}

?>