//======================================================================================
// [[[ Config

	$time_before_hide = 500;
	// This variable usualy set inside PHP code of module:
	// $default_opened_submenu_id = 12;

// ]]] Config
//======================================================================================
// [[[ Init variables

	var $opened_menus = new Array();
	window.$current_interval = 0;

// ]]] Init variables
//======================================================================================

function wbg_act_nav(){
	$obj = document.getElementById("nav-top");
	$obj.onmousemove = '';
	$links = $obj.getElementsByTagName("DIV");
	$counter = $links.length;
	for ($x=0; $x < $counter; $x++) {
		if ($links[$x].className == "lvl1"){
			$links[$x].onmouseover = show_menu;
			$links[$x].onmouseout = hide_menu;
		}
	}
	document.getElementById("submenus").style.visibility = "visible"
}

function hide_all_now($mode){
	while($menu = $opened_menus.pop()){
		$menu.style.display="none";
		var $id = $menu.getAttribute("id").replace("sub-", "");
		document.getElementById("n"+$id).style.backgroundColor="";
	}
	if ($default_opened_submenu_id && $mode ==1 ){
		document.getElementById("sub-"+$default_opened_submenu_id).style.display="block";
	} else if ($default_opened_submenu_id && $mode == 0){
		document.getElementById("sub-"+$default_opened_submenu_id).style.display="none";
	}
}

function show_menu($overed_object){

	if ($overed_object){
		if ($overed_object.tagName != "DIV"){
			$overed_object = this;
		}
	} else {
		$overed_object = this;
	}

	hide_all_now(0);
	clear_timeout();
	var $id = parseInt($overed_object.getAttribute("id").replace("n", "").replace("sub-",""));
	var $submenu = document.getElementById("sub-"+$id);

	$opened_menus.push($submenu);
	$submenu.style.display = "block";

	// Razmeshajem blok pod knopkoj
	$positionX 		= findPosX(document.getElementById("n"+$id));
	$screenWidth 	= document.getElementById("sizer").offsetLeft;
	$menuWidth 		= $submenu.clientWidth;
	if (document.getElementById("n"+$id).parentNode.className == "active"){
		$mainmenuWidth 	= document.getElementById("n"+$id).parentNode.clientWidth;
	} else {
		$mainmenuWidth 	= document.getElementById("n"+$id).clientWidth;
	}
	$pos = ($positionX + $mainmenuWidth/2) - $menuWidth/2 ;

	$left = Math.min($pos, $screenWidth - $menuWidth - 25) + "px";

	$submenu.style.marginLeft = $left;

//	document.getElementById("n"+$id).style.backgroundColor="#f1f1f1";


	$submenu.onmouseover = show_menu;
	$submenu.onmouseout = hide_menu;
}

function get_x_position($obj){
	if ($obj.parentNode){
		return parseInt($obj.offsetLeft) + get_x_position($obj.parentNode)
	} else {
		return parseInt($obj.offsetLeft);
	}
}

function hide_menu(){
	window.$current_interval = window.setTimeout("hide_all_now(1)", 500);
}

function clear_timeout(){
	if (window.$current_interval){
		window.clearTimeout(window.$current_interval);
		window.$current_interval = 0;
	}
}



function findPosX(obj) {
	var curtop = 0;
	while (obj.offsetParent) {
		curtop += obj.offsetLeft
		obj = obj.offsetParent;
	}
	return curtop;
}
function findPosY(obj) {
	var curtop = 0;
	while (obj.offsetParent) {
		curtop += obj.offsetTop
		obj = obj.offsetParent;
	}
	return curtop;
}

function update_container($obj, $width_perc, $visota_offset, $shirina_offset){
	$height = document.getElementById("sizer").offsetTop;
	if (document.removeNode){
		$visota_offset -= 17;
	}
	$width	= (document.getElementById("sizer").offsetLeft - 30 - 4 - 10) /100 * $width_perc;
	document.getElementById($obj).style.width = $width+"px";
	document.getElementById($obj).style.height = $height-$visota_offset+"px";
}

function activate_submenu($pattern){
	var $link = window.document.location.href.split("?");
	if (!document.getElementById("submenus")) return; // Eto naprimer v popupe bivajet
	var $A = document.getElementById("submenus").getElementsByTagName("a");
	var $counter = $A.length;
	for ($x=0; $x < $counter; $x++) {
	 	$A[$x].className = "";
	 	var $link2 = $A[$x].href.split("?");
	 	if (!$pattern){
	 		if ($link2[1] == $link[1]){
	 			$A[$x].className = "active";
	 		}
	 	} else {
	 		if ($link2[1].replace($pattern, "") != $link2[1]){
	 			$A[$x].className = "active";
	 		}
	 	}
	}

}


//======================================================================================

function wbg_show_header($title, $right){
	var $string = '';
	$string += '<table class="header">';
	$string += 		'<tr>';
	$string +=			'<td class="center" width="100%" style="padding-left:0"><img src="images/header-left.gif" align="absmiddle" style="margin-right:6px"/>'+$title+'</td>';
	if ($right){
		$string +=			'<td class="center" nowrap>'+$right+'</td>';
	}
	$string +=			'<td><img src="images/header-right.gif" align="absmiddle"/><br></td>';
	$string += 		'</tr>'
	$string += '</table>';
	document.write($string);
}

function wbg_show_dropdown_menu($x, $y, $width, $title, $html){
	if (document.getElementById($title)){
		document.getElementById($title).parentNode.removeChild(document.getElementById($title));
		return;
	}
	var $newDiv = document.createElement("DIV");
	$newDiv.innerHTML = $html;
	$newDiv.id = $title;
	$newDiv.style.position = "absolute";
	$newDiv.style.left = $x+"px";
	$newDiv.style.width = $width+"px";

	$newDiv.style.top = $y+"px";
	document.body.appendChild($newDiv);
}

function wbg_category_in_popup($category_id, $add_to_get){
	open_popup("", 700, 800);
}

//======================================================================================

function open_popup($url, $width, $height){
	$mainWidth = document.body.scrollWidth;
	$mainHeight = document.body.scrollHeight;
	$left = $mainWidth/2 - $width/2;
	$top = $mainHeight/2 - $height/2;
	open($url, "", "width="+$width+", height="+$height+", scrollbars=yes, resizable=yes, left="+$left+", top="+$top+"");
}
