<?php include_once(dirname(__FILE__).'/../_common/_html_header.tpl.php')?>
<script>
function init(){
	// Esli eto avtorizacija v freime , to nado perekinutj ee na parent okno.
	if (window.parent.window.document.location.href != window.document.location.href){
		window.parent.window.document.location.href = window.parent.window.document.location.href;
	}
}
</script>
<style>
	#loginform 		{text-align:left}
	#crosslinks TD 	{vertical-align:top;}
	h1 				{color:#0d4e62; font-size:18px; margin:0 0 5px 0; }
</style>
<body onload="init();">
<script>
	$width = window.document.body.clientWidth;
	$str = '<table cellspacing="0" cellpadding="0" align="center" width="'+($width>920?'920px':'98%')+'">';
	document.write($str);
</script>
	<tr>
		<td><img src="images/startpage/bg-left.png" border="0"/></td>
		<td width="100%" style="background:url('images/startpage/bg.png') top repeat-x" align="center"><img src="images/startpage/bg-center.png" border="0"/></td>
		<td><img src="images/startpage/bg-right.png" border="0"/></td>
	</tr>
	<tr>
		<td colspan="3" align="center" style="white-space:nowrap">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td><img src="images/startpage/spacer-left.gif" border="0"/></td>
					<td width="100%"><img src="images/startpage/spacer.gif" width="100%" height="1"/></td>
					<td><img src="images/startpage/spacer-right.gif" border="0"/></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="3" style="padding-top:20px">
			<table width="95%" align="center" id="crosslinks">
				<tr>
					<td><img src="images/startpage/icn-3.gif"/></td>
					<td width="33%">
						<h1>FAQ & User manual</h1>
						Do you have any questions, or need help? Our FAQ and documentation is reachable at<br/><a href="http://www.web-gooroo.com/" style="color:#f7a208">www.web-gooroo.com</a>
					</td>
					<td><img src="images/startpage/icn-2.gif"/></td>
					<td width="33%">
						<h1>Want the same?</h1>
						Do you want your web-project to be based on our Framework? According to these questions you are able to contact us by the following phone number
						 +371 7819422 or e-mail us at <a href="mailto:sales@bb-tech.eu" style="color:#f7a208">sales@bb-tech.eu</a>
					</td>
					<td><img src="images/startpage/icn-1.gif" hspace="5"/></td>
					<td width="33%">
						<h1>Developer network</h1>
						Do you have any modules to share? Do you have questions about code development for Web-Gooroo? You are kindly welcome to visit our forum at <br><a href="http://www.web-gooroo.com/rus/cms.forum/" style="color:#f7a208">www.web-gooroo.com</a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<div style="position:absolute;left:0px;top:80px;text-align:center;width:100%">
	<img src="images/startpage/logo.gif" border="0" style="margin-bottom:55px"/>
	<form method="POST" action="<?php echo $_CFG['url_to_cms']?>">
		<table align="center" id="loginform">
			<?php if ($message) echo '<tr><td colspan="2" align="center" style="color:red">'.$message.'</td></tr>';?>
			<?php if (!@$blocked) {?>
			<tr>
				<td>Username</td>
				<td>
					<input type="text" id="wbg_login" value="<?php echo @htmlspecialchars(stripslashes($_POST['wbg_login']))?>" name="wbg_login" class="default">
					<script>document.getElementById("wbg_login").focus();</script>
				</td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type="password" value="" name="wbg_password" class="default"></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<div class="button"><input type="submit" value=" Enter "></div>
				</td>
			</tr>
			<?php }?>
		</table>
	</form>
</div>
</body>
</html>