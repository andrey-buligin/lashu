/**
*	Eto fail kotorij u menja podgruzhajetsa v popupe v kotorom mi perenosim 
*	kategoriju iz odnogo jazika v drugoj. failik - popup.other_language.php
*/

/**
*	Eta funkcija vipolnjajet onclick na Kategoriju v dereve
*/

function init(){
}

function clickOnCat(e){
	_copy_move_el(e);
	return false;
}


function _copy_move_el(e){
	if (!e) {
		window.event.cancelBubble = true;
		e = window.event;
		$obj = event.srcElement;
	} else {
		$obj = e.target;
		e.stopPropagation();
	}
	if ($obj.tagName == "A"){ // Nado proveritj - klick mozhet bitj na TD , a mozhet na A . Nam nuzhen TD
		$obj = $obj.parentNode;
	}
	if ($obj.getAttribute("nolink")){
		alert(" Wrong INPUT MODULE ! You can't copy/move data There !");
		return;
	}
	$temp = $obj.id.split("-");
	$element_id = $temp[1]
	
	$actionframe = window.opener.window.document;
	$temp = $actionframe.location.href.split("?");
	
	$todo = (document.getElementById("m_copy").checked) ? 'copy' : 'move';
	$actionframe.forms['mainform'].action = $temp[0]+"?id="+$current_cat+"&txt_action="+$todo+"&txt_target="+$element_id;
	$actionframe.forms['mainform'].submit();
	window.close()
	return false;
}


// ====================================================================
//  [[[ Reagirujem na dblclick

	function dblClickOnCat(e){
	}
	

//  [[[ Reagirujem na dblclick
// ====================================================================
//  [[[ GEnerim menju onRigthClick


	function RclickOnCat(e){
	}

	
//  ]]] GEnerim menju onRigthClick
// ====================================================================

	function remove_contextMenu(){
	}
