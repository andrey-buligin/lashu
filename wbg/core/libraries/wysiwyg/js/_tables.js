	function make_popupTable(){
		_open_popup("../wysiwyg/popups/popup.addTable.php?obj=0&lang="+$currentLang, "width=500,height=300,left=100,top=100,scrollbars=yes,resizeable=yes");
	}

	function createTable($width, $actions){
		$newTable = document.createElement("TABLE");
		$newTable.className = "wbg_table";
		$newTable.style.width=$width;
		$counter = $actions.length;
		for ($x=0; $x < $counter; $x++) {
			switch(parseInt($actions[$x])){
				case 1: $newTR = $newTable.insertRow(0);break;
				case 2:
					$newTD = $newTR.insertCell(0);
					$newTD.innerHTML = "&nbsp;";
					break;
			}

			$other_data = ($actions[$x]+"").split(":");
			if ($other_data[1]){ $newTD.colSpan = $other_data[1]; }
			if ($other_data[2]){ $newTD.rowSpan = $other_data[2]; }
			if ($other_data[3]){ $newTD.width = $other_data[3]; }
		}

		if ($editorWindow.selection){ // IE
	        var sel = $editorWindow.selection.createRange();
	        temp=sel.text;
	        $editorWindow.focus();
	        sel.pasteHTML($newTable.outerHTML);
	    } else {
			$obj = window.frames[0].window.getSelection();
	    	$range = $obj.getRangeAt(0);
	    	$range.insertNode($newTable);
	    }
	}
