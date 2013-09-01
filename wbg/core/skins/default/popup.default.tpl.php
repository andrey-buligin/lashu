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
<body onload="start_window()" style="background:#ffffff">
	<div style="padding:4px">
		<script>wbg_show_header("<?php echo $HTML_TITLE?>")</script>
		<div class="grey-block" style="background:#efefef; padding:10px 4px">
			<?php echo $HTML_CONTENT?>
		</div>
	</div>
	<div style="padding:5px">
		ESC+ESC to close window
	</div>

<script>
	$esc_pressed = 0;
	function start_window(){
		document.onkeydown = set_key_flag;
		if (window.init){
			init();
		}
	}
	function set_key_flag(e){
		if (!e) e = window.event;
	    if(e.keyCode==27 && $esc_pressed) {
	   		window.close();
	    }
	    $esc_pressed = true;
	    window.setTimeout("clear_esc()", 200);
	}
	function clear_esc(){
		$esc_pressed = 0
	}
</script>
</body>
</html>