
function tree_function_create(		$id,  $parent_id, $title, $is_folder, $is_opened, $is_last, $children) {

	$categories[$id] = new treeItem($id,  $parent_id, $title, 0, $is_folder, $is_opened, $is_last);
	$categories[$id].$ident = treeItem_recalcIdent($id);

	var $children = $children.split(",");
	$categories[$parent_id].$children = $children;

	/*--------------------------------------------------------------------------------------*/

		$HTML = treeItem_to_HTML($id);
		var $container = document.createElement("DIV");
		$container.innerHTML = $HTML;
		document.getElementById("c-"+$parent_id).appendChild($container);

		var $container = document.createElement("DIV");
		$container.setAttribute("id" , "c-"+$id);
		document.getElementById("c-"+$parent_id).appendChild($container);

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