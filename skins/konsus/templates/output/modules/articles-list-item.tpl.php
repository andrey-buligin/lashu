<?php
    $textlist = $templateVars['textlist'];
    $article  = $templateVars['article'];
    $key      = $templateVars['article_key'];
    $openedDoc= false;
    
    $content  = unserialize( $article['content'] );
	$content['category_id'] = $article['category_id'];
	$content['id'] = $article['id'];
	$link 	  = URL_MANAGER_HELPER::makeUrl( null, $content, true );//WBG_HELPER::SmartUrlEncode(WBG::crosslink($article['category_id']).'?doc='.$article['id']);
	
	if ( !$openedDoc )
		$class = '';
	else
		$class = ' last';
	
	if (isset($content['lead_img']['src']))
		$img = '<a href="'.$link.'">'.WBG_HELPER::insertImage( $content['lead_img'],' class="f-left"', null, 1).'</a>';
	else
	    $img = '';
	
	if ($content['date'] AND $content['time'])
		$date = date("d.m.Y", $content['date']).' '.$content['time'];
	else
	    $date = date("d.m.Y H:i", $article['created']);
	
	$author = $textlist->_getOwner( $article['owner'] );
?>
<div class="blog-item<?php echo $class?>">
	<h2><a href="<?php echo $link ?>"><?php echo $content['title'] ?></a></h2>
	<p class="date">
		<span class="author"><?php echo $author['I_name'].' '.$author['I_surname'] ?></span> | <?php echo $date; ?>
	</p>
	<?php echo ($content['embed'] ? '<div class="embed">'.$content['embed'].'</div>' : $img); ?>
	<div class="text clear-block">
		<p><?php echo $content['lead'] ?></p>
	</div>
	<span class="tags"><strong>Views</strong>: <?php echo $textlist->getViewsCount( $article['id'] ) ?></span> |
	<span class="tags"><strong>Comments</strong>: <a href=""><?php echo $textlist->getCommentsCount( $article['id'] ) ?></a></span> |
	<?php echo $textlist->generateTagLinks( $content['tags'] ) ?>
	<div class="clear-block"></div>
</div>