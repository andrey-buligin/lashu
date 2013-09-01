<?php include_once(dirname(__FILE__).'/../../_common/_html_header.tpl.php');?>
<?php
	$languages = null;
	while (list($key,$value) = each($_CFG['language_name'])){
		$languages .= '<option value="'.$key.'" '.($key==$_CFG['language']?'selected="selected"':'').'>'.$value.'</option>';
	}
?>
<body>
<div><select name="lang"><?php echo $languages?></select></div>
<?php echo $HTML_CONTENT?>
<script>
// Eto chastnij sluchaj chisto dlja DOM2
/**
* @todo nuzhno budet eto ubratj iz normalnogo skina
*/
function make_collapse($obj, $id){
	$img = $obj;
	$obj =  $obj.parentNode.nextSibling.nextSibling;
	if ($obj.style.display == "none"){
		$obj.style.display =  "block";
		$img.src = $img.src.replace("down", "up");
		cookies_UpdateCookie($id, "collapsed_block", "add");
	} else {
		$obj.style.display =  "none";
		$img.src = $img.src.replace("up", "down");
		cookies_UpdateCookie($id, "collapsed_block", "remove");
	}
}
</script>

<?php echo $sitetree->draw_tree();?>
</body>
</html>