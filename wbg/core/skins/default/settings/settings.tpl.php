<?php include_once(dirname(__FILE__).'/../_common/_html_header.tpl.php');?>
<?php include_once(dirname(__FILE__).'/../_common/top.tpl.php');?>

<div style="padding-top:<?php echo $top+80?>px;">
	<div style="padding:0px 15px">
		<script>wbg_show_header("System settings")</script>
		<div class="grey-block" style="background:#efefef; padding:5px 4px">
			<div style="padding:5px; color:#ffa200; padding-bottom:10px; background:#ffffff; margin-bottom:5px">
				To change something you need manually edit config file !
				<div style="padding:7px 0px;font-weight:bold; color:#29747c">/<?php echo $_CFG['cms_name']?>/config/config.php</div>
				<a href="http://www.web-gooroo.com/?wbg_cat=124&doc=188" style="color:#ffa200" target="_blank">read more about it here</a>
			</div>
			<?php echo $HTML_CONTENT?>
		</div>
	</div>
</div>
<br/>
</body>
</html>