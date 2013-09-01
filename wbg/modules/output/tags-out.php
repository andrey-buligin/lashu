<?php

	include_once(dirname(__FILE__).'/../libraries/textlist_out.class/textlist_out.class.php');
	include_once(dirname(__FILE__).'/../components/tags.php');
	
	$tags = new Tags();
	if ( !isset( $_GET['tag'] ) ) $_GET['tag'] = '';
	$pageTitle = 'Search results for tag "'.$_GET['tag'].'"';
	$_GET['tag'] = mysql_escape_string( $_GET['tag'] );
	if ( $tags->getTagCount( $_GET['tag'] ) ) {
		$condition = array();
		$itemsList = $tags->getObjectsByTag( $_GET['tag'] );
		foreach ($itemsList as $arr) {
			if ( $arr['sql_table'] == '_mod_textlist') {
				$condition[] = $arr['obj_id'];
			}
		}
		if ($condition) {
			$condition = " AND active=1 AND id IN (".implode(",", $condition).")";
			$textlist 		 = new TextListOut('_mod_textlist');
			$decorator 		 = new TextListOut_Decorator($textlist);
			$decorator_title = new TextListOut_withTitle($decorator);
			$decorator_end   = new TextListOut_withEnd($decorator);
			$textlist->showNoTitle = true;
			$decorator->showList( $condition );
			$decorator_title->addTitle( $pageTitle );
			$return_from_module = WBG_HELPER::transferToXHTML( $decorator->getList() );
		} else {
			echo '<h1 class="page-title">'.$pageTitle.'</h1>
				  <div class="page-text clear-block"><p>Sorry, but there was nothing found for your requested tag: <strong>'.$_GET['tag'].'</strong></p></div>';
		}
	} else {
		echo '<h1 class="page-title">'.$pageTitle.'</h1>
		      <div class="page-text clear-block"><p>Sorry, but there was nothing found for your requested tag: <strong>'.$_GET['tag'].'</strong></div>';
	}
?>