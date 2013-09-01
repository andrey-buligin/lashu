//======================================================================================
// [[[ Funkcii otvechajut za obrabotku pravogo klika na element kakoj libo v wsyge

	function OnClickIE(){
		$e = document.getElementById("editorWindow").contentWindow.event;
		$obj = $e.srcElement;
		return edit_object($obj);
	}

	function OnClickFF($e){
		$obj = $e.target;
		edit_object($obj, true, $e)
	}

	function edit_object($obj, $isFF, $e){
		switch($obj.tagName){
			case "IMG" :
				if ($obj.className != "wysiwyg_popupimage"){
					edit_wsygImage($obj)
				} else {
					edit_wsygImagePopup($obj)
				}
				if ($isFF){$e.preventDefault();}
				return false;
			case "A" :
				$onclick = $obj.getAttribute("onclick");
				if ($onclick){
					edit_popupInsert($obj)
				} else {
					edit_wsygLink($obj);
				}
				if ($isFF){$e.preventDefault();}
				return false;
			case "TD" :
				edit_TD_tag($obj);
				if ($isFF){$e.preventDefault();}
				return false;
		}
		return true;
	}

// ]]] Funkcii otvechajut za obrabotku pravogo klika na element kakoj libo v wsyge
//======================================================================================