<?php

global $web;

$textlist = $templateVars['textlist'];
$wbgLayot = $templateVars['wbg_layout'];    
$article  = isset( $templateVars['article'] ) ? $templateVars['article'] : $textlist->getOpenedObject( $_GET['doc'] );    
$content  = unserialize( $article['content'] );
$img      = '';
$back     = '';

//views count
$textlist->increasViewsCount( $article['id'] );

if (isset($content['text_img']['src']))
{
	$img = WBG_HELPER::insertImage( $content['text_img'],' class="f-left"', null, 1 );
}
else
{
	if ( isset( $content['lead_img']['src'] ) )
		$img = WBG_HELPER::insertImage( $content['lead_img'],' class="f-left"', null, 1 );
}

if ($content['date'] AND $content['time'])
	$date = date("d.m.Y", $content['date']).' '.$content['time'];
else
    $date = date("d.m.Y H:i", $article['created']);

$author = $textlist->_getOwner( $article['owner'] );
	
if ( !isset( $templateVars['no_back_button'] ) )
	$back = '<div class="readmore"><a href="'.WBG::crosslink($web->active_category).'"><<< '.WBG::message("back", null, 1).'</a></div>';
?>
<div id="blog-page">
    <div class="blog-item opened">
    	<h1><?php echo $content['title']; ?></h1>
    	<p class="date">
    		<span class="author"><?php echo $author['I_name'].' '.$author['I_surname'] ?></span> | <?php echo $date; ?>
    	</p>
    	<?php echo ( $content['embed'] ? '<div class="embed">'.$content['embed'].'</div>' : $img); ?>
    	<div class="text clear-block">
    		<p><?php echo $content['text']; ?></p>
    	</div>
    	<?php echo $textlist->generateTagLinks( $content['tags'] ); ?>
    	<?php echo $back; ?>
    	<div class="clear-block"></div>
    	<?php echo $textlist->showComments( $article['id'] ); ?>
    </div>
</div>