<?php

function pagelist($counter, &$LIMIT, $items_on_page = 10, $delete_get_img = false) {
	global $web;
	
	/*---------------------------------------------------------------------*/
	
		if (isset($_GET['items_on_page'])) {
			$items_on_page = $_GET['items_on_page'];
			$_SESSION['page_items_'.$web->active_category] = $_GET['items_on_page'];
		} 
		
		if (isset($_GET['page'])){
			$current = $_GET['page'];
		} else {
			$current = 0;
		}
	
	/*---------------------------------------------------------------------*/
	
	if ($counter <= $items_on_page){
		return '';
	}

	$LIMIT = " LIMIT ".($items_on_page*$current).", ".$items_on_page;

	$HTML = '';
	$pages = ceil($counter / $items_on_page);
	$znak = (!preg_match("/\?/",$_SERVER['REQUEST_URI']) ? '?' : (preg_match("/\?page/", $_SERVER['REQUEST_URI']) ? '?': '&'));

	$link = str_replace($znak.'page='.@$_GET['page'],'',$_SERVER['REQUEST_URI']);
	if ($delete_get_img) {
		$link = str_replace('&img='.@$_GET['img'],'',$link);
	}
	
	for ($x = 0; $x < $pages; $x++) {
		$HTML .= '<a class="'.($current==$x?'active':'page').'" href="'.$link.$znak.'page='.$x.'">'.($x+1).'</a>';
	}

	return '
		<table cellpadding="0" cellspacing="0" id="pagination">
			<tr>
    			<td id="prevPage"><a href="'.$link.$znak.'page='.(max(0, $current-1)).'">&lt;&lt;</a></td>
    			<td id="pagesList">'.$HTML.'</td>
    			<td id="nextPage"><a href="'.$link.$znak.'page='.(min($pages-1, $current+1)).'">&gt;&gt;</a></td>
			</tr>
		</table>';
}
?>