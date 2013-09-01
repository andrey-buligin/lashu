<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<title><?php WBG::variable("page_title",1);?></title>
	<meta name="description" content="<?php echo WBG_HELPER::generatePageMetaTag('desciption');?>" />
	<meta name="keywords" content="<?php echo WBG_HELPER::generatePageMetaTag('keywords');?>" />
	<?php if (isset($_GET['IE7'])){ ?>
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<?php }  ?>
	
	<link rel="stylesheet" type="text/css" href="<?php echo $this->getSkinCssUrl('main.css');?>" />
	<?php $this->loadGalleryRequiredCssFiles(); ?>
	
	<script type="text/javascript" src="js/modernizr.js"></script>
	<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
	<?php $this->loadGalleryRequiredJsFiles();?>
	<script type="text/javascript" src="js/jquery.pngFix.pack.js" ></script>
	<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="js/innerFade.js"></script>
	<script type="text/javascript" src="<?php echo $this->getSkinJsUrl('common.js')?>"></script>
	
	<script type="text/javascript">
    	Modernizr.load({
          test: Modernizr.touch,
          yep : 'js/jquery.animate-enhanced.min.js'
        });
    </script>
    
	<!--<script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-22803522-1']);
      _gaq.push(['_trackPageview']);
    
      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    
    </script> -->

</head>
<?php WBG_HELPER::generatePageTitle();?>