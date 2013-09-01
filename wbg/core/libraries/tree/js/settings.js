function change_cat_data($id, $from_popup){

	$title	= document.getElementById("title").value;
	if (document.getElementById("dir")){
		$dir  = document.getElementById("dir").value;
	} else {
		$dir = '';
	}
	$active				= document.getElementById("active").checked ? 1 : 0;
	$enabled			= document.getElementById("enabled").checked ? 1 : 0;
	$output_template 	= document.getElementById("output_template").value;
	$input_module		= document.getElementById("input_module").value;
	$output_module		= document.getElementById("output_module").value;
	$property_template		= null;

	if ($from_popup){
		$tree_window = window.opener.window;
	} else {
		$tree_window = window.parent.window;
	}
	$tree_window.tree_UpdateCategory($id, $title, $dir, $active, $enabled, $output_template, $input_module, $output_module, $property_template);

	dateObj = new Date();
	document.getElementById("message-field").innerHTML = "Data saved : "+dateObj.toUTCString();;
}

function create($parent_id){

	$title				= document.getElementById("title").value;
	document.getElementById("title").value	= '';
	if (document.getElementById("dir")){
		$dir			= document.getElementById("dir").value;
		document.getElementById("dir").value	= '';
	} else {
		$dir 			= '';
	}
	$active				= document.getElementById("active").checked ? 1 : 0;
	$enabled			= document.getElementById("enabled").checked ? 1 : 0;
	$output_template 	= document.getElementById("output_template").value;
	$input_module		= document.getElementById("input_module").value;
	$output_module		= document.getElementById("output_module").value;
	$property_template		= document.getElementById("property_template").value;
	$property_template2	= document.getElementById("property_template2").value;
	$insert_before		= document.getElementById("insert_before").value;

	if (document.getElementById("id")){
		$id	= document.getElementById("id").value;
	} else {
		$id = 0;
	}
	window.opener.window.tree_CreateCategory($parent_id, $title, $dir, $active, $enabled, $output_template, $input_module, $output_module, $property_template, $property_template2, $insert_before, $id);
	document.getElementById("title").focus();
}

//======================================================================================

function save_set(){
	if (window.Popup) window.Popup.close();

	$t1 = document.getElementById("output_template");
	$t2 = document.getElementById("input_module");
	$t3 = document.getElementById("output_module");

	var $output_template 	= $t1.options[$t1.selectedIndex].value;
	var $input_module 		= $t2.options[$t2.selectedIndex].value;
	var $output_module 		= $t3.options[$t3.selectedIndex].value;

	var $link = '';
	$link += '&output_template='+$output_template;
	$link += '&input_module='+$input_module;
	$link += '&output_module='+$output_module;

	window.Popup = window.open($url_to_cms+'core/sets/popup.edit_set.php?id='+window.parent.window.current_cat_id + $link ,'','width=600px,height=500px,left=100px,top=100px')
}

function edit_set(){
	if (window.Popup) window.Popup.close();
	$id = document.getElementById("category_set").value;
	window.Popup = window.open($url_to_cms+'core/sets/popup.edit_set.php?edit='+$id ,'','width=600px,height=500px,left=100px,top=100px')
}

//======================================================================================
// [[[ Dejstvija nad mirrors

	function open_mirror_popup($category_id){
		if (window.Popup) window.Popup.close();
		window.Popup = window.open($url_to_cms+'core/libraries/tree/popups/popup.set_mirror.php?id='+$category_id ,'','width=700px,height=500px,left=100px,top=100px, resizable=yes, scrollbars=yes');
	}

	// Eta funkcija vizivajetsa iz popupa set mirror i dinamicheski menjajet pokaz linkovannih kategorij
	function replace_mirror($language, $lang_prefix,  $title, $id){
		if (document.getElementById("mirror-lang-"+$language)){
			$tr = document.getElementById("mirror-lang-"+$language);
			$tr.cells[1].innerHTML = "[ID:"+$id+"]";
			$tr.cells[2].innerHTML = '<a href="#" onclick="open_mirror_cat('+$id+'); return false" style="color:#000000; font-weight:bold">'+$title+'</a>';
		} else {
			var $table = document.getElementById("mirror-cat-container");
			$tr = $table.insertRow(-1);
			$tr.id = "mirror-lang-"+$language;
			$td = $tr.insertCell(-1);
			$td.innerHTML = $lang_prefix;
			$td = $tr.insertCell(-1);
			$td.innerHTML = "[ID:"+$id+"]";
			$td = $tr.insertCell(-1);
			$td.innerHTML = '<a href="#" onclick="open_mirror_cat('+$id+'); return false" style="color:#000000; font-weight:bold">'+$title+'</a>';
		}
	}

// ]]] Dejstvija nad mirrors
//======================================================================================


function popup_edit_category($id){
	if (window.Popup) window.Popup.close();
	window.insPopup = window.open("../libraries/sitetree.class/popup.edit_category.php?id="+$id,"","width=550,height=400,scrollbars=yes,resizeable=yes,left=100,top=100");
}


function replace_chars(nameOld){
	newName = '';
	for (x=0;x<nameOld.length;x++){
		if (code_set[nameOld.charCodeAt(x)]){
			newName += code_set[nameOld.charCodeAt(x)];
		} else {
			if (nameOld.charCodeAt(x) <48 || (nameOld.charCodeAt(x) > 57 && nameOld.charCodeAt(x) <65) || nameOld.charCodeAt(x) > 122){
				newName += "_";
			} else {
				newName += nameOld.charAt(x);
			}
		}
    }
	newName = newName.toLowerCase();
	return newName;

}


//*****
// Automatically creates value in Directory Field
// Takes data from name field and converts it
//****


var code_set = new Array ();

code_set[92] = "_";  // eto \
code_set[91] = "_";  // eto [
code_set[93] = "_";  // eto ]
code_set[94] = "_";  // eto ^
code_set[96] = "_";  // eto `

// Latvian
code_set[275] = "e";  code_set[274] = "e";
code_set[363] = "u";  code_set[362] = "u";
code_set[299] = "i";  code_set[298] = "i";
code_set[257] = "a";  code_set[256] = "a";
code_set[353] = "s";  code_set[352] = "s";
code_set[291] = "g";  code_set[290] = "g";
code_set[311] = "k";  code_set[310] = "k";
code_set[316] = "l";  code_set[315] = "l";
code_set[382] = "z";  code_set[381] = "z";
code_set[269] = "c";  code_set[268] = "c";
code_set[326] = "n";  code_set[325] = "n";


// Russian
code_set[1081] = "i";  code_set[1049] = "I";
code_set[1094] = "c";  code_set[1062] = "C";
code_set[1091] = "u";  code_set[1059] = "U";
code_set[1082] = "k";  code_set[1050] = "K";
code_set[1077] = "e";  code_set[1045] = "E";
code_set[1085] = "n";  code_set[1053] = "N";
code_set[1075] = "g";  code_set[1043] = "G";
code_set[1096] = "s";  code_set[1064] = "S";
code_set[1097] = "s";  code_set[1065] = "S";
code_set[1079] = "z";  code_set[1047] = "Z";
code_set[1093] = "h";  code_set[1061] = "H";
code_set[1098] = "";   code_set[1066] = "";
code_set[1092] = "f";  code_set[1060] = "F";
code_set[1099] = "i";  code_set[1067] = "I";
code_set[1074] = "v";  code_set[1042] = "V";
code_set[1072] = "a";  code_set[1040] = "A";
code_set[1087] = "p";  code_set[1055] = "P";
code_set[1088] = "r";  code_set[1056] = "R";
code_set[1086] = "o";  code_set[1054] = "O";
code_set[1083] = "l";  code_set[1051] = "L";
code_set[1076] = "d";  code_set[1044] = "D";
code_set[1078] = "z";  code_set[1046] = "Z";
code_set[1101] = "e";  code_set[1069] = "E";
code_set[1103] = "a";  code_set[1071] = "A";
code_set[1095] = "c";  code_set[1063] = "C";
code_set[1089] = "s";  code_set[1057] = "S";
code_set[1084] = "m";  code_set[1052] = "M";
code_set[1080] = "i";  code_set[1048] = "I";
code_set[1090] = "t";  code_set[1058] = "T";
code_set[1100] = "";   code_set[1068] = "";
code_set[1073] = "b";  code_set[1041] = "B";
code_set[1102] = "u";  code_set[1070] = "U";


function change_dir($value){
	if (document.getElementById("dir")){
		if (!document.getElementById("dir").value){
			document.getElementById("dir").value = replace_chars($value);
		}
	}
}

function change_set($obj, $current_set){

	document.getElementById("new-set-button").style.display = "none";
	document.getElementById("edit-set-button").style.display = "none";

	if (!$current_set){
		$current_set = $obj.options[$obj.selectedIndex].value;
	}
	if ($sets[$current_set]){
		$selected_items = $sets[$current_set].split(";");
		_set_select($selected_items[0], document.getElementById("output_template"));
		_set_select($selected_items[1], document.getElementById("input_module"));
		_set_select($selected_items[2], document.getElementById("output_module"));
	}

	if ($current_set == 0){
		document.getElementById("new-set-button").style.display = "";
		document.getElementById("sets_list").style.display = "none";
		document.getElementById("selects_list").style.display = "";
	} else {
		document.getElementById("edit-set-button").style.display = "";
		document.getElementById("sets_list").style.display = "";
		document.getElementById("selects_list").style.display = "none";
	}


	if ($current_set =="-1"){
		document.getElementById("edit-set-button").style.display = "none";
		document.getElementById("output_template").selectedIndex = 0;
		document.getElementById("input_module").selectedIndex = 0;
		document.getElementById("output_module").selectedIndex = 0;
		document.getElementById("subsettings").style.display = "none";
		document.getElementById("subsettings-sp").style.display = "none";
	} else {
		document.getElementById("subsettings").style.display = "";
		document.getElementById("subsettings-sp").style.display = "";
	}
}
function _set_select($data, $select){
	$counter = $select.options.length;
	for ($x=0; $x < $counter; $x++) {
		if ($select.options[$x].value == $data){
			$select.selectedIndex = $x;
			$title = $select.getAttribute("id");
			document.getElementById("set_"+$title).innerHTML = $select.options[$x].innerHTML;
			return;
		}
	}
}