<?php if (!defined("NODOCTYPE")){echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional">';}?>
<html <?php echo @$OVERFLOW?>> 
	<head>
	<title>Web-GooRoo <?php echo $_CFG['version']?></title>
	<META HTTP-EQUIV="Expires" CONTENT="Fri, Jan 01 1900 00:00:00 GMT" />
	<META HTTP-EQUIV="Pragma" CONTENT="no-cache" />
	<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache" />
	<META http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<META name="author" content="Edgars Rasinsh aka Mayhem (c) SIA IDATA" />
	<META HTTP-EQUIV="Reply-to" CONTENT="mayhem@idata.lv" />
	<META NAME="description" CONTENT="Content managment system." />
	<BASE href="http://<?php echo $_SERVER['HTTP_HOST'] . $_CFG['url_to_skin']?>" />
	<LINK REL="StyleSheet" HREF="web-gooroo.css" type="text/css" />
	<script type="text/javascript" src="web-gooroo.js"></script>
	<script>$url_to_cms = "<?php echo $_CFG['url_to_cms']?>"</script>
</head>
