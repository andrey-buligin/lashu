
function tree_function_delete($id,  $children) {
	tree_RemoveAllActive();
	var $parent_id = $categories[$id].$parent_id;

	if (!$children){ /* Esli mi udalili samij poslednij element*/
		$categories[$parent_id].$is_folder = 0;
		$categories[$parent_id].$is_opened = 0;
		treeItem_changeIcons($parent_id);
		cookies_UpdateCookie($parent_id, $cookie_name, "remove");
	}

	$categories[$parent_id].$children = $children.split(",");
	treeItem_fixLasts($parent_id);
	tree_removeObjFromDOM($id);

	if (document.getElementById("site-content-container")){
		var $temp = window.frames[0].window.document.location.href.split("?");
		window.frames[0].window.document.location.href = $temp[0]+"?lang="+$CURRENT_LANG;
	}

}

function tree_removeObjFromDOM($id){
	$container = document.getElementById("c-"+$id);
	$element = document.getElementById("cat-"+$id);
	if ($element){
		$container.parentNode.removeChild($container);
		$element.parentNode.removeChild($element);
	}
}