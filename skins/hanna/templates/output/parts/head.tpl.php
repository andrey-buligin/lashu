<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!-- <meta name="viewport" content="width=device-width"> -->
    <meta name="viewport" content="width=1024">

	<title><?php WBG::variable("page_title",1);?></title>
	<meta name="description" content="<?php echo WBG_HELPER::generatePageMetaTag('desciption');?>" />
	<meta name="keywords" content="<?php echo WBG_HELPER::generatePageMetaTag('keywords');?>" />
	<meta property="og:image" content="http://beautybyhanna.co.uk/images/skins/hanna/building/beautybyhanna.jpg">

	<link rel="shortcut icon" href="<?php echo $this->getImageUrl('building/favicon.ico');?>" />
	<link href='http://fonts.googleapis.com/css?family=Rochester' rel='stylesheet' type='text/css' />

	<?php global $_CFG; if ($_CFG['Environment'] == 'live') :?>
		<link rel="stylesheet" href="css/hanna.css">
		<?php $this->loadGalleryRequiredCssFiles(); ?>
	<?php else: ?>
		<link rel="stylesheet" href="css/normalize.css">
	    <link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $this->getSkinCssUrl('main.css');?>" />
		<?php $this->loadGalleryRequiredCssFiles(); ?>
	<?php endif; ?>

	<script type="text/javascript" src="js/modernizr.js"></script>
</head>
<?php WBG_HELPER::generatePageTitle();?>