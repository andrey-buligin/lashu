function mylist_parse_table($obj){
	$obj.onmouseover = "";
	$tds = $obj.getElementsByTagName("TD");
	$counter = $tds.length;
	for ($x=0; $x < $counter; $x++) {
		if ($tds[$x].className == "spacer"){ // Esli eto spacer to nichego s nim ne delajem
			continue;
		}
		if (!$tds[$x].onclick){
			$tds[$x].onclick = edit_element;
		}
		if (!$tds[$x].onmouseover){
			$tds[$x].onmouseover = on_TD_over;
			$tds[$x].onmouseout = on_TD_out;
		}
		$tds[$x].style.cursor = "pointer";
	}
}
function edit_element($id){
	if (!parseInt($id) && $id!=="0" && $id!==0){
		var re = new RegExp("[0-9]+","g");
		$id = parseInt(re.exec(this.parentNode.getAttribute("id")));
	}
	if (!window._ml_withselect_onclick){
		alert("Call of javascript function _ml_withselect_onclick($ELEMENT_ID) is failed. You need to create it !!!");
		return;
	}
	_ml_withselect_onclick($id);
}

function on_TD_over(){
	_mark_all(this,"mouse_overed");
}
function on_TD_out(){
	_mark_all(this,"");
}
function _mark_all($obj, $color){
	$temp = $obj.parentNode.firstChild;
	while($temp){
		$_color = $color;
		if (!$_color){
			$_color = $temp.getAttribute("oldColor");
			$temp.removeAttribute("oldColor");
		} else {
			$temp.setAttribute("oldColor", $temp.className);
		}
		$temp.className = $_color;
		$temp = $temp.nextSibling;
	}
}