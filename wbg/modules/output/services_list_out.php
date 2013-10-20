    <div class="row" id="services">
        <?php
        global $_CFG;
	    global $web;

	    $activeCategory = $web->active_category;
	    $activeCategoryData = $web->category_data[$activeCategory];

	    $contentFile = $_CFG['path_to_modules'].'/input/onetext/__saved_data_'.$activeCategory;
	    if ( file_exists( $contentFile ) )
	    {
	    	$data = unserialize( file_get_contents( $contentFile ) );
	    	?>
	    	<div class="span12">
	            <div class="title-page">
	                <h2 class="title"><?php echo $data['title'] ?></h2>
	                <h3 class="title-description"><?php echo $data['text'] ?></h3>
	            </div>
	        </div>
	    <?php } ?>
       
        <!-- Start Profile -->
        <div class="span4 profile">
            <div class="image-wrap">
                <div class="hover-wrap">
                    <span class="overlay-img"></span>
                    <span class="overlay-text-thumb">Click me</span>
                </div>
                <img src="images/girl.jpg" alt="Eyelashes">
            </div>
            <h3 class="profile-name">Eyelashes</h3>
            <p class="profile-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ac augue at erat <a href="#">hendrerit dictum</a>. 
            Praesent porta, purus eget sagittis imperdiet, nulla mi ullamcorper metus, id hendrerit metus diam vitae est. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
                
            <div class="social">
                <ul class="social-icons">
                    <li><a href="#"><i class="font-icon-social-twitter"></i></a></li>
                    <li><a href="#"><i class="font-icon-social-dribbble"></i></a></li>
                    <li><a href="#"><i class="font-icon-social-facebook"></i></a></li>
                </ul>
            </div>
        </div>
        <!-- End Profile -->
        
        <!-- Start Profile -->
        <div class="span4 profile">
            <div class="image-wrap">
                <div class="hover-wrap">
                    <span class="overlay-img"></span>
                    <span class="overlay-text-thumb">Click me</span>
                </div>
                <img src="images/girl.jpg" alt="Courses">
            </div>
            <h3 class="profile-name">Courses</h3>
            <p class="profile-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ac augue at erat <a href="#">hendrerit dictum</a>. 
            Praesent porta, purus eget sagittis imperdiet, nulla mi ullamcorper metus, id hendrerit metus diam vitae est. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
                
            <div class="social">
                <ul class="social-icons">
                    <li><a href="#"><i class="font-icon-social-twitter"></i></a></li>
                    <li><a href="#"><i class="font-icon-social-email"></i></a></li>
                </ul>
            </div>
        </div>
        <!-- End Profile -->
        
        <!-- Start Profile -->
        <div class="span4 profile">
            <div class="image-wrap">
                <div class="hover-wrap">
                    <span class="overlay-img"></span>
                    <span class="overlay-text-thumb">Click me</span>
                </div>
                <img src="images/girl.jpg" alt="Gallery">
            </div>
            <h3 class="profile-name">Gallery</h3>
            <p class="profile-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ac augue at erat <a href="#">hendrerit dictum</a>. 
            Praesent porta, purus eget sagittis imperdiet, nulla mi ullamcorper metus, id hendrerit metus diam vitae est. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
                
            <div class="social">
                <ul class="social-icons">
                    <li><a href="#"><i class="font-icon-social-twitter"></i></a></li>
                    <li><a href="#"><i class="font-icon-social-linkedin"></i></a></li>
                    <li><a href="#"><i class="font-icon-social-google-plus"></i></a></li>
                    <li><a href="#"><i class="font-icon-social-vimeo"></i></a></li>
                </ul>
            </div>
        </div>
        <!-- End Profile -->

    </div>
