<?php

$SQL_str = "SELECT * FROM _mod_textlist WHERE category_id='".$CATEGORY['id']."' AND active=1";
$sql_res = mysql_query($SQL_str);
while ($arr = mysql_fetch_assoc($sql_res)) {

	$content = unserialize($arr['content']);

	if ($arr['doc_url']){
		$link = $arr['doc_url'];
	} else {
		$link = '?doc='.$arr['id'];
	}
	$link = $LINK.$link;
	$ADD['link'][] = $link;
	$ADD['priority'][] = @$SEO['sitemap_changefreq'];
	$ADD['changelog'][] = @$SEO['sitemap_priority'];

}
?>