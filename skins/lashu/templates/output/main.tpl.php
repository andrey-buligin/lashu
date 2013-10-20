<?php $this->displayHead(); ?>
    <body <?php echo $this->getBackgroundStyle()?>>
		<?php $this->displayHeader(); ?>

       <!--  <div id="about_us" class="page-alternate">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="title-page">
                        <h2 class="title">About Us</h2>
                        <h3 class="title-description">Learn About our Team &amp; Culture.</h3>
                        
                        <div class="page-description">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sed ligula odio. Sed id metus felis. Ut pretium nisl non justo condimentum id tincidunt nunc faucibus. 
                            Ut neque eros, pulvinar eu blandit quis, lacinia nec ipsum. Etiam vel orci ipsum. Sed eget velit ipsum. Duis in tortor scelerisque felis mattis imperdiet. Donec at libero tellus. 
                            <a href="#">Suspendisse consectetur</a> consectetur bibendum. Pellentesque posuere, ligula volutpat elementum interdum, diam arcu elementum ipsum, vel ultricies est mauris ut nisi.</p>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        </div> -->
        <?php
            $catData = $web->category_data[$web->active_category];
        ?>
        <div id="<?php echo str_replace(array('eng/', '/'), '', $catData['dir']);?>" class="page-alternate">
            <div class="container">
		      <?php WBG::content(); ?>
            </div>
        </div>
    	<?php $this->displayFooter(); ?>
        <?php $this->includeTemplate('parts/footer_script'); ?>
    </body>
</html>