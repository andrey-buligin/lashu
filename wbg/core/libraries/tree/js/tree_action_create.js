
function tree_function_create(		$id,  $parent_id, $title, $is_folder, $is_opened, $is_last, $type, $enabled, $active, $children, $dir, $insert_before) {

	$categories[$id] = new treeItem($id,  $parent_id, $title, 0, $is_folder, $is_opened, $is_last, $type, $enabled, $active, $dir);

	var $children = $children.split(",");
	$categories[$parent_id].$children = $children;

	$categories[$id].$ident = treeItem_recalcIdent($id);

	/*--------------------------------------------------------------------------------------*/

		$HTML = treeItem_to_HTML($id);
		var $container = document.createElement("DIV");
		$container.innerHTML = $HTML;
		
		/* Vstavljajem sam element */
		if ($insert_before*1 == -1){
			document.getElementById("c-"+$parent_id).insertBefore($container, document.getElementById("c-"+$parent_id).firstChild);
		} else if ($insert_before*1 == 0) {
			document.getElementById("c-"+$parent_id).appendChild($container);
		} else {
			document.getElementById("c-"+$parent_id).insertBefore($container, document.getElementById("cat-"+$insert_before));
		}

		/* Vstavljajem kontainer dlja subkategorij */
		var $container2 = document.createElement("DIV");
		$container2.setAttribute("id" , "c-"+$id);
		if ($insert_before*1 == -1){
			document.getElementById("c-"+$parent_id).insertBefore($container2, $container.nextSibling);
		} else if ($insert_before*1 == 0) {
			document.getElementById("c-"+$parent_id).appendChild($container2);
		} else {
			document.getElementById("c-"+$parent_id).insertBefore($container2, document.getElementById("cat-"+$insert_before));
		}		

	/*--------------------------------------------------------------------------------------*/

		$categories[$parent_id].$is_folder = true;
		$categories[$parent_id].$is_opened = true;
		cookies_UpdateCookie($parent_id, $cookie_name, "add");

		document.getElementById("c-"+$parent_id).style.display = "block";
		treeItem_changeIcons($parent_id);
		$opened_elements = $opened_elements.replace(";"+$parent_id+";", "");
		$opened_elements += ";"+$parent_id+";";

	/*======================================================================================*/

	treeItem_fixLasts($parent_id);
}