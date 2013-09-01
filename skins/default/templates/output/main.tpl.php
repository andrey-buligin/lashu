  <?php $this->displayHead(); ?>
  <body id="body">
    <div id="page"<?php if (@$web->active_tree[1] == WBG::mirror(41) OR (@$web->active_tree[1] == WBG::mirror(46))) echo ' class="fully-scrollable"'?>>
    
      <div id="header">
      	<?php $this->displayHeader(); ?>
      </div> <!-- /header -->

      <div id="container" class="clear-block">

        <div id="navigation">
        	<div id="nav-container" class="clear-block">
	        	<?php WBG::module('top-navigation')?>
	        	<div id="share"><?php WBG::template("addThis"); ?></div>
        	</div> 
        </div> 
		
        <div id="sidebar-left">
        	<?php if ( $this->skin->showLeftNav() ) : ?>
        	    <?php WBG::module('left-navigation'); ?>
        	<?php endif; ?>
        	<?php if ( $this->skin->showBlocks() OR $this->currentPage->showBlocks() ) : ?>
        		<?php 
        		      $leftBlocks = $this->skin->getLeftBlocks();
        		      if ( $this->currentPage->showBlocks() )//if we have block overrides set up per page
        		      {
        		          $currentPageLeftBlocks = $this->currentPage->getLeftBlocks();
        		          $leftBlocks = $currentPageLeftBlocks;
        		      }
        		      if ( $leftBlocks )
        		      {
            		      foreach ( $leftBlocks as $blockId ) {
            		          if ( $this->blockExists( $blockId ) )
            		          {
            		              $this->displayBlock( $blockId );
            		          }
            		      }
        		      }
                ?>
        	<?php endif;?>
        	<?php //WBG_HELPER::getCatPropImage('id="leftBaner"')?>
        </div>
        
        <div id="main">
			<div id ="topfade"><div>&nbsp;</div></div>
        	<div id="content">
              	<?php WBG::content()?>
       		</div> <!-- /content -->
        </div> <!-- /main -->

      </div> <!-- /container -->

    </div> <!-- /page -->

    <div id="footer">
      	<?php $this->displayFooter(); ?>
    </div> <!-- /footer -->

  </body>
</html>