<?php 
$URL_TO_SKIN = $_SERVER['HTTP_HOST'] . $URL_TO_ROOT . "core/skins/default/install_system/";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<head>
	<title>WebGooroo installation</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<LINK REV="made" HREF="mailto:mayhem@bb-tech.eu" />
	<META name="keywords" content="CMS" />
	<META name="description" content="WebGooroo : CMS" />
	<BASE href="http://<?php echo $URL_TO_SKIN?>" />
	<link rel="stylesheet" href="install.css" type="text/css" />	
</head>
<body>
<div style="background:url('images/header-bg.gif') top"><img src="images/header.jpg" border="0"/></div>
<div style="background:url('images/header-bg2.gif') top"><img src="images/header-bg2.gif" border="0"/></div>

<table cellspacing="0" cellpadding="0" border="0" width="100%" height="100%" id="maintable" style="background:#f4f4f4">
	<tr>
		<td width="60%" valign="top">
			<div style="padding:20px 15px 0px 15px">
				<img src="images/icon-step.gif" border="0" style="position:absolute"/>
				<div style="border:1px solid #e5e5e5; margin:5px 10px; background:#ffffff; padding:8px 50px"><b>Current installation step: <?php echo $step?></b></div>		
				<div style="padding:0px 15px 0px 30px">
					<br>
					<table style="margin-bottom:20px">
						<tr>
							<td>Short <b>URL</b> to project is detected as:</td>
							<td><b><?php echo $URL_TO_ROOT?></b></td>
						</tr>
						<tr>
							<td><b>PATH</b> to project is detected as</td>
							<td><b><?php echo $PATH_TO_ROOT?></b></td>
						</tr>
					</table>
				</div>
			</div>
			<form method="post" action="">
			<table width="100%">
				<tr>
					<td style="padding-left:35px">&nbsp;</td>
					<td style="width:100%"><?php echo $HTML?></td>
					<td style="padding-left:15px">&nbsp;</td>
				</tr>
			</table>						
			</form>
		</td>
		<td valign="top"  width="40%" style="padding:0px 5px; padding-top:20px">
			<img src="images/icon-done.gif" border="0" style="position:absolute"/>
			<div style="border-bottom:1px solid #000000; padding-left:55px; margin-top:10px; padding-bottom:4px"><b>Installation steps</b></div>
			<div style="line-height:18px; padding-top:20px; padding-left:10px" id='steps'>
				<div<?php echo !$_GET['step']?' class="active"':''?>><img src="images/1.gif" border="0"/> Common checks of server and it's configuration</div>
				<div<?php echo $_GET['step']==2?' class="active"':''?>><img src="images/2.gif" border="0"/> Directories creation</div>
				<div<?php echo $_GET['step']==3?' class="active"':''?>><img src="images/3.gif" border="0"/> Mysql database creation</div>
				<div<?php echo $_GET['step']==4?' class="active"':''?>><img src="images/4.gif" border="0"/> Languages defining</div>
				<div<?php echo $_GET['step']==5?' class="active"':''?>><img src="images/5.gif" border="0"/> System users configuration</div>
				<div<?php echo $_GET['step']==6?' class="active"':''?>><img src="images/6.gif" border="0"/> Additional configuration</div>
				<div<?php echo $_GET['step']==7?' class="active"':''?>><img src="images/7.gif" border="0"/> Finalizing<br></div>
			</div>
		</td>
	</tr>
</table>		
		
		
</body>
</html>