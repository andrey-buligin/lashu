<?php $this->displayHead(); ?>
    <body class="yui-skin-sam" <?php echo $this->getBackgroundStyle()?>>
    	<div id="headerContainer">
    		<?php $this->displayHeader(); ?>
    		<div id="gelleryListPart">
    			<div id="albumSelect">
    				<a href="#" id="selectLink"><img src="<?php echo $this->getImageUrl( 'building/ClickMeO.jpg' );?>" alt="Click to unfold/hide the navigation" title="Click to unfold/hide the navigation"/></a><br/>
    				<?php WBG::module("left-navigation");?>
    			</div>
    		</div>
    	</div>
    	<div id="content">
    		<?php WBG::content(); ?>
    	</div>
    	<div id="footerContainer">
    		<?php $this->displayFooter(); ?>
    	</div>
    </body>
</html>