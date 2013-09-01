<?php
$size = getImageSize("../".$_GET["img"]);
?><html>
<head></head>
<script>
window.resizeTo(<?php echo $size[0]?>,<?php echo $size[1]?>)
</script>
<body style="padding:0px; margin:0px">
<a href="#" onclick="window.close()" title="close"><img src="<?php echo $_GET["img"]?>" border="0"/></a>
</body>
</html>