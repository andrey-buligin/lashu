<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html class="no-js lt-ie9 lt-ie8" lang="en"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html class="no-js lt-ie9" lang="en"><![endif]-->
<!--[if (IE 9)]><html class="no-js ie9" lang="en"><![endif]-->
<!--[if gt IE 8]><!--> <html lang="en-US"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <!-- Mobile Specifics -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="HandheldFriendly" content="true"/>
	<meta name="MobileOptimized" content="320"/>   

	<!-- Mobile Internet Explorer ClearType Technology -->
	<!--[if IEMobile]>  <meta http-equiv="cleartype" content="on">  <![endif]-->

	<title><?php WBG::variable("page_title",1);?></title>
	<meta name="description" content="<?php echo WBG_HELPER::generatePageMetaTag('desciption');?>" />
	<meta name="keywords" content="<?php echo WBG_HELPER::generatePageMetaTag('keywords');?>" />
	<meta property="og:image" content="http://beautybyhanna.co.uk/images/skins/hanna/building/beautybyhanna.jpg">

	<link rel="shortcut icon" href="<?php echo $this->getImageUrl('building/favicon.ico');?>" />
	
	<!-- <link href='http://fonts.googleapis.com/css?family=Rochester' rel='stylesheet' type='text/css' /> -->

	
	<?php global $_CFG; if ($_CFG['Environment'] == 'live') :?>
		<link rel="stylesheet" href="css/lashu.css">
		<?php $this->loadGalleryRequiredCssFiles(); ?>
	<?php else: ?>
		<!-- Bootstrap -->
		<link href="<?php echo $this->getSkinCssUrl('bootstrap.min.css');?>" rel="stylesheet">

		<link rel="stylesheet" type="text/css" href="<?php echo $this->getSkinCssUrl('main.css');?>" />

		<!-- Supersized -->
		<link href="<?php echo $this->getSkinCssUrl('supersized.css');?>" rel="stylesheet">
		<link href="<?php echo $this->getSkinCssUrl('supersized.shutter.css');?>" rel="stylesheet">

		<!-- FancyBox -->
		<link href="<?php echo $this->getSkinCssUrl('fancybox/jquery.fancybox.css');?>" rel="stylesheet">

		<!-- Font Icons -->
		<link href="<?php echo $this->getSkinCssUrl('fonts.css');?>" rel="stylesheet">

		<!-- Shortcodes -->
		<!-- <link href="<?php echo $this->getSkinCssUrl('shortcodes.css');?>" rel="stylesheet"> -->

		<!-- Responsive -->
		<link href="<?php echo $this->getSkinCssUrl('bootstrap-responsive.min.css');?>" rel="stylesheet">
		<link href="<?php echo $this->getSkinCssUrl('responsive.css');?>" rel="stylesheet">

		<!-- Custom CSS -->
		<link href="<?php echo $this->getSkinCssUrl('custom.css');?>" rel="stylesheet">

		<?php $this->loadGalleryRequiredCssFiles(); ?>
	<?php endif; ?>

	<!-- Google Font -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>


	<script type="text/javascript" src="js/modernizr.js"></script>
</head>
<?php WBG_HELPER::generatePageTitle();?>