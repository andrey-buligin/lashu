
// Images + Image popup

//======================================================================================
// [[[ Images

	/**
	*	Otrkivajem popup s filamanagerom
	*/
	function make_imageInsert(){
		_open_popup("../wbg_parse_template.class/popups/popup.manage_images.php?elname=imagewsyg&dir=text/", "width=700,height=600,left=100,top=100,scrollbars=yes, resizeable=yes");
	}

	/**
	*	Vizivajetsa iz filamangera
	*/
	function insert_uploaded_image($width, $height, $width2, $height2, $src){
		insert_wsygImage("images/"+$src, "", "", 0, 0, "");
		var $obj = window.imageToEdit;
		_open_popup($urlToThisFile + "popups/popup.image.php?image="+$obj.src+"&obj=1&lang="+$currentLang, "width=500,height=440,left=100,top=100,scrollbars=yes,resizable=yes");

	}

	/**
	*	Funkcija vizivajetsa pri pravom klike na kartinku
	*/
	function edit_wsygImage($obj){
		window.imageToEdit = $obj;
		_open_popup($urlToThisFile + "popups/popup.image.php?image="+$obj.src+"&obj=1&lang="+$currentLang, "width=500,height=440,left=100,top=100,scrollbars=yes,resizable=yes");
		//_open_popup("../wysiwyg/popups/popup.conf.image.php?image="+$obj.src+"&obj=1", "width=500,height=440,left=100,top=100,scrollbars=yes,resizable=yes");
	}


	function insert_wsygImage($src, $align, $style, $hspace, $vspace){

		$hspace = parseInt($hspace);
		$vspace = parseInt($vspace);

		if ($editorWindow.selection){ // IE

	        $editorWindow.focus();

	        var $selection	= $editorWindow.selection.createRange();
	        var $HTML 		= "<img src='"+$src+"' style='"+$style+"' align='"+$align+"' border='0' id='wsyg_temp_image'/>";

	        $selection.pasteHTML($HTML);
	        window.imageToEdit = window.frames[0].window.document.getElementById("wsyg_temp_image");
	        window.imageToEdit.removeAttribute("id");


	    } else {
			$image = window.frames[0].window.document.createElement("IMG");
			$image.src = $src;
			$image.align = $align;
			$image.setAttribute("style", $style);
			$image.setAttribute("hspace", $hspace);
			$image.setAttribute("vspace", $vspace);

			$obj = window.frames[0].window.getSelection();
	    	$range = $obj.getRangeAt(0);
	    	$range.insertNode($image);

	    	window.imageToEdit = $image;
	    }

	    window.Popup.close();
	}

	function image_update_properties($align, $margin_left, $margin_right, $margin_top, $margin_bottom, $style, $text_under_image){

		var $image = get_image_tag(window.imageToEdit);

		$image[0].align = $align;
		$image[0].style.marginLeft 		= $margin_left;
		$image[0].style.marginRight 	= $margin_right;
		$image[0].style.marginTop 		= $margin_top;
		$image[0].style.marginBottom 	= $margin_bottom;

    	if ($text_under_image && $image[1] == 0){ // Esli nuzhno dobavitj table
    		var $newTable = window.frames[0].window.document.createElement("table");
    		$newTable.className = "wysiwyg_image_w_text";
    		var $newTR = $newTable.insertRow(0);
    		var $newTD = $newTR.insertCell(0);
			$newTD.innerHTML = $text_under_image;
    		var $newTR = $newTable.insertRow(0);
    		var $newTD = $newTR.insertCell(0);
			$image[0].parentNode.insertBefore($newTable, $image[0]);
			$newTD.appendChild($image[0]);
			$image[0].className = "wysiwyg_image_w_text";
		} else if ($text_under_image && $image[1] == 1){ // Esli eto update uzhe gotovoj tablici
			$image[0].rows[1].cells[0].innerHTML = $text_under_image;
		} else if (!$text_under_image && $image[1] == 1) { // Esli nuzhno ubratj table
			$images = $image[0].getElementsByTagName("img");
			$counter = $images.length;
			for ($x=0; $x < $counter; $x++) {
				if ($images[$x].className == "wysiwyg_image_w_text"){
					$images[$x].className = '';
					$image[0].parentNode.insertBefore($images[$x], $image[0]);
					$image[0].parentNode.removeChild($image[0]);
					break;
				}
			}
		}
	}

	function image_delete(){
		var $image = get_image_tag(window.imageToEdit);
		$image[0].parentNode.removeChild($image[0]);
	}

	function get_image_tag($obj){
		var $is_table = 0;
		if ($obj.className == "wysiwyg_image_w_text"){ // Esli eto image with text under it
			if ($obj.parentNode.tagName == "A" && $obj.parentNode.className == "wysiwyg_link_on_image") {
				$obj = $obj.parentNode;
			}
			var $obj = $obj.parentNode.parentNode.parentNode;
			if ($obj.tagName == "TBODY") {
				$obj = $obj.parentNode;
			}
			$is_table = 1;
		}
		return new Array($obj, $is_table);
	}

	function change_image($imagesrc){
		window.imageToEdit.src = "images/"+$imagesrc;
	}

	function image_set_link($target, $link){
		var $parentTag = window.imageToEdit.parentNode;
		if ($parentTag.tagName == "A" && $parentTag.className == "wysiwyg_link_on_image"){
			if ($link){
				$parentTag.href = $link;
				$parentTag.target = $target;
			} else {
				doRichEditCommand('unlink');
			}
		} else {
			if (!$link) return
			$a = window.frames[0].window.document.createElement("A");
			$a.href = $link;
			$a.className = "wysiwyg_link_on_image";
			$a.target = $target;
			window.imageToEdit.parentNode.insertBefore($a, window.imageToEdit);
			$a.appendChild(window.imageToEdit);
		}
	}

	function image_set_popup_image($imgsrc){
		var $temp = $imgsrc.split($urlToRootFull);
		var $link = "open('images/wysiwyg_popup.php?img='+this.getAttribute(\'imageonclick\'),\'\',\'width=300,height=300\');"
		window.imageToEdit.setAttribute("onclick", $link);
		window.imageToEdit.setAttribute("imageonclick", $temp[1]);
		window.imageToEdit.style.cursor = "pointer";
	}


// ]]] Image
//======================================================================================
// [[[ Image Popup

	function make_imagePopupInsert(){
		window.imageScript = "insert_uploaded_imagePopup";
		_open_popup("../wbg_parse_template.class/popups/popup.manage_images.php?elname=imagewsyg&dir=text/", "width=700,height=600,left=100,top=100,scrollbars=yes, resizeable=yes");
	}

	function insert_uploaded_imagePopup($width, $height, $width2, $height2, $src){
		_open_popup("../wysiwyg/popups/popup.conf.imagePopup.php?image="+$urlToImages+$src+"&obj=0", "width=400,height=600,left=100,top=100,scrollbars=yes,resizeable=yes");
	}
	function edit_wsygImagePopup($obj){
		window.imageToEdit = $obj;
		_open_popup("../wysiwyg/popups/popup.conf.imagePopup.php?image="+$obj.src+"&obj=1", "width=400,height=600,left=100,top=100,scrollbars=yes,resizeable=yes");
	}


	function insert_wsygImagePopup($src, $align, $style, $bigImage, $bigImageWidth, $bigImageHeight){
		if ($editorWindow.selection){ // IE
	        var sel = $editorWindow.selection.createRange();
	        temp=sel.text;
	        $editorWindow.focus();
	        sel.pasteHTML ("<img src='"+$src+"' style='"+$style+"' align='"+$align+"' border='0' onclick='open(\"tools/img_preview.php?img="+$bigImage+"\",\"\",\"width="+$bigImageWidth+",height="+$bigImageHeight+"\");' class='wysiwyg_popupimage'/>");
	    } else {
			$image = window.frames[0].window.document.createElement("IMG");
			$image.src = $src;
			$image.align = $align;
			if ($style){
				$image.setAttribute("style", $style);
			}
			$image.setAttribute("onclick","open(\"tools/img_preview.php?img="+$bigImage+"\",\"\",\"width="+$bigImageWidth+",height="+$bigImageHeight+"\")");
			$obj = window.frames[0].window.getSelection();
	    	$range = $obj.getRangeAt(0);
	    	$range.insertNode($image);
	    }
	    window.Popup.close();
	}