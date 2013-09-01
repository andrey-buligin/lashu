
// Rabota s failami

function make_fileInsert(){
	_open_popup("../../filemanager/filemanager.alone.php?dir=files/text&element=nepomnjuzachemeto&script=insert_wsygFile", "width=700,height=500,left=100,top=200");
}
function insert_wsygFile($element, $dir, $array_with_files){
	window.Popup.close();

	if ($dir.indexOf('files')==-1 && $dir.indexOf('images')==-1){
		alert("Link to file will not work ! Only files from /files/ and /images/ directories are allowed inside wysiwyg");
		return;
	}

	if ($editorWindow.selection){ // IE
	    if ($editorWindow.selection.type=="Text"){
	        var sel = $editorWindow.selection.createRange();
	        temp=sel.text;
	        $editorWindow.focus();
	        sel.pasteHTML ("<a href='download.php?file="+$dir+"/"+$array_with_files+"' class=wysiwyg_link target='_blank'>"+temp+"</a>");
	    }
    } else {
    	$link = window.frames[0].window.document.createElement("A");
    	$link.href = "download.php?file="+$dir+"/"+$array_with_files;
    	$link.target = "_blank";
    	$link.className = "wysiwyg_link";
    	$obj = window.frames[0].window.getSelection();
    	$range = $obj.getRangeAt(0);
    	$range.surroundContents($link);
    }
}