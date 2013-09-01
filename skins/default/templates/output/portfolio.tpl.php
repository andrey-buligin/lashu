  <?php $this->displayHead(); ?>
  <body id="body">
    <div id="page">
    
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

        <div id="main" class="wide">
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
