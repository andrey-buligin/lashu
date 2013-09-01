<?php
//======================================================================================

	$top = "50"; // Eto otstup ot kotorogo nachinajetsa pokaz contenta
	include_once(dirname(__FILE__).'/wbg_get_top_nav.php');
	wbg_get_top_nav($_GET['section'], $MAINMENU , $SUBMENU, $active_id);

//======================================================================================
?>
<body onload='show_menu(document.getElementById("n<?php echo $active_id?>")); wbg_act_nav(); if(window.init){init()};' onresize="if(window.resize){window.resize()}">
<div id="sizer"></div>

	<img src="images/logo.gif" style="position:absolute; left:27px; top:1px"/>



	<div style="position:absolute; width:100%; top:<?php echo $top?>px;">
		<div style="background:url('images/header-bg2.gif'); margin-right:10px; margin-left:10px; border:1px solid #bfbfbf">
			<div style="border:1px solid #ffffff; height:35px;">&nbsp;</div>
		</div>
	</div>
	<div style="position:absolute; top:10px; right:20px">
		<div style="float:right">
			<a href="<?php echo $_CFG['url_to_cms']?>?exit" style="color:#000000; text-decoration:none"><img src="images/logout.gif" border="0" style="vertical-align:middle"/> <?php echo __TOP_2__?></a>
		</div>
		<div style="float:right; margin-right:20px">
			<img src="images/user.gif" border="0" style="vertical-align:middle"/><?php echo __TOP_1__?> <b><?php echo $_CFG['user']['login']?></b><br/>
			<div style="padding:0px 0px 0px 15px"><a href="#" style="color:#999999" onclick="open_popup('<?php echo $_CFG['url_to_cms'];?>core/users/popups/popup.edit_user.php?edit=<?php echo $_CFG['user']['id']?>&cat=<?php echo $_CFG['user']['category_id']?>', 500, 450); return false"><?php echo __TOP_3__?></a></div>
		</div>
	</div>

	<img src="images/top-menu-left.gif" style="position:absolute; top:<?php echo $top?>px; left:10px"/>
	<img src="images/top-menu-right.gif"  style="position:absolute; top:<?php echo $top?>px; right:10px"/>
	<div style="position:absolute; top:<?php echo $top+39?>px; width:100%; z-index:1;">
		<div style="background:#f1f1f1; border-top:1px solid #ffffff; border-bottom:1px solid #cecece; margin:0px 16px; height:28px">&nbsp;</div>
	</div>
	<img src="images/top-submenu-left.gif" style="position:absolute; top:<?php echo $top+39?>px; left:15px"/>
	<img src="images/top-submenu-right.gif"  style="position:absolute; top:<?php echo $top+39?>px; right:15px"/>

	<div style="top:<?php echo $top?>px;" id="nav-top">
		<?php echo $MAINMENU;?>
	</div>
	<div id="submenus" style="top:<?php echo $top+42?>px; visibility: hidden">
		<?php echo $SUBMENU;?>
	</div>