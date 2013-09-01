<?php 
$textlist = $templateVars['textlist'];
$wbgLayot = $templateVars['wbg_layout'];    
$articles = $textlist->getList();
?>
<div id="blog-page" class="">
	<h1><?php echo $textlist->getPageTitle(); ?></h1>
	<?php if ( is_array($articles) ):?>
	<?php 
	      foreach ($articles as $articleKey => $article)
	      {
	          $templateVars['article']     = $article;
	          $templateVars['article_key'] = $articleKey;
	          $wbgLayot->includeTemplate( 'modules/articles-list-item', $templateVars );
	      }
	?>
	<?php endif;?>
	<?php echo $textlist->getPageListHtml(); ?>
</div>