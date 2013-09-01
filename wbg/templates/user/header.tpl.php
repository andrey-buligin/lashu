<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<link rel="shortcut icon" href="images/favicon.ico" />
    <link rel="icon" type="image/gif" href="images/animated_favicon1.gif" />
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<title><?php WBG::variable("page_title",1);?></title><?php WBG_GLOBAL::add_component("wbg_helper");?>
	<meta name="description" content="<?php echo WBG_HELPER::generatePageMetaTag('desciption');?>" />
	<meta name="keywords" content="<?php echo WBG_HELPER::generatePageMetaTag('keywords');?>" />
	<?php if (isset($_GET['IE7'])){ ?>
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<?php }  ?>
	
	<link rel="stylesheet" type="text/css" href="css/common.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery.jcarousel.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" />
	<link rel="stylesheet" type="text/css" href="css/ie7/skin.css" />
	
	<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="js/jquery.pngFix.pack.js"></script>
	<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="js/jquery.fancybox-1.3.4.pack.js"></script>
	<script type="text/javascript" src="js/jquery.jcarousel.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
	<script type="text/javascript" src="js/jquery.color.js"></script>
	
	<script type="text/javascript">
	<!--//--><![CDATA[//><!--
	//--><!]]>
	</script>
</head>
<?php WBG_HELPER::generatePageTitle();?>