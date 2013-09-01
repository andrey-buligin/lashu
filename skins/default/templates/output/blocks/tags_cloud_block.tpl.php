<div id="tagcloud" class="block">
	<h3>Tag cloud</h3>
	<div id="tag-container">
	<?php
		include_once(dirname(__FILE__).'/../components/tags.php');
		$tags = new Tags();
		echo $tags->getTagsCloud( '_mod_textlist' );
	?>	
	</div>
</div>