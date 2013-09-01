<?php
/**
 * Fail dlja poiska informacii po saitu
 */


$sql_string = "	SELECT
					tx.id,
					tx.category_id,
					tx.content,
					st.dir as dir,
					(MATCH (tx.content) AGAINST ('".$SearchText."')) as relev
				FROM
					_mod_textlist as tx
					LEFT JOIN 
					wbg_tree_categories as st ON tx.category_id=st.id
				WHERE
					MATCH (tx.content) AGAINST ('".$SearchText."')
					AND
						tx.lang = '".$web->language."'
					AND 
						st.enabled=1
					AND tx.active=1
				GROUP BY 
					relev DESC";

$sql_res=mysql_query($sql_string);
echo mysql_error();

while ($arr = mysql_fetch_assoc($sql_res)){
	$data = unserialize($arr['content']);
	$text = substr(strip_tags($data['text'].$data['lead']),0,400).'...';
	add_to_search_result($data['title'],$text,$_CFG['path_url'].$arr['dir'].'/?doc='.$arr['id'], $arr['category_id']);
}


?>