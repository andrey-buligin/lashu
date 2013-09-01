<?php
	$textlist   = $templateVars['textlist'];
	$urlManager = $templateVars['urlManager'];
	$article    = $templateVars['article'];
	$key        = $templateVars['article_key'];
	$openedDoc  = false;

	$content                = unserialize( $article['content'] );
	$content['category_id'] = $article['category_id'];
	$article['title']       = $content['title'];
	$content['id']          = $article['id'];
	$link                   = $urlManager->getBlogPostUrl($article);

	if ( !$openedDoc )
		$class = '';
	else
		$class = ' last';

	if (isset($content['lead_img']['src']))
		$img = '<a href="'.$link.'">'.WBG_HELPER::insertImage( $content['lead_img'],' class="f-left"', null, 1).'</a>';
	else
	    $img = '';

	if ($content['date'] AND $content['time']) {
	    $pubDate = date("Y-m-d", $content['date']);
	    $date    = date("d.m.Y", $content['date']).' '.$content['time'];
	} else {
	    $pubDate = date("Y-m-d", $article['created']);
	    $date    = date("d.m.Y H:i", $article['created']);
	}

	$author = $textlist->_getOwner( $article['owner'] );
?>
<article class="blog-item clear<?php echo $class?>">
	<header>
		<h2><a href="<?php echo $link ?>"><?php echo $content['title'] ?></a></h2>
	</header>
	<p class="date">
		<span class="author"><?php echo $author['I_name'].' '.$author['I_surname'] ?></span> | <time datetime="<?php echo $pubDate;?>" pubdate="pubdate"><?php echo $date; ?></time>
	</p>
	<?php echo ($content['embed'] ? '<div class="embed">'.$content['embed'].'</div>' : $img); ?>
	<div class="text clear-block">
		<p><?php echo $content['lead'] ?></p>
	</div>
	<footer>
		<span class="tags"><strong>Views</strong>: <?php echo $textlist->getViewsCount( $article['id'] ) ?></span> |
		<span class="tags"><strong>Comments</strong>: <a href=""><?php echo $textlist->getCommentsCount( $article['id'] ) ?></a></span> |
		<?php echo $textlist->generateTagLinks( $content['tags'] ) ?>
	</footer>
</article>