	<!-- <a href="http://<?php echo $_CFG['path_url_full'].$web->lang_prefix;?>"> -->
<!-- This section is for Splash Screen -->
<div class="ole">
<section id="jSplash">
	<div id="circle"></div>
</section>
</div>
<!-- End of Splash Screen -->

<?php $this->displayModule('large-images-out');?>

<!-- Header -->
<header>
    <div class="sticky-nav">
	    <a id="mobile-nav" class="menu-nav" href="#menu-nav"></a>
	    <div id="logo">
	        <a id="goUp" href="#home-slider" title="Lashu | eyelash extensions studio"><?php echo $this->getLogoImage(); ?></a>
	    </div>
	    <nav id="menu">
	    	<?php WBG::module("top-navigation"); ?>
	       <!--  <ul id="menu-nav">
	            <li class="current"><a href="#home-slider">Home</a></li>
	            <li><a href="#work">Our Work</a></li>
	            <li><a href="#about">About Us</a></li>
	            <li><a href="#services">Services</a></li>
	            <li><a href="blog.html" class="external">Blog</a></li>
	            <li><a href="#contact">Contact</a></li>
	            <li><a href="shortcodes.html" class="external">Shortcodes</a></li>
	        </ul> -->
	    </nav>
    </div>
</header>
<!-- End Header -->