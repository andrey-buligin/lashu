function tree_function_insert($id, $target, $new_subs_in_old, $new_subs_target){

	$old_parent = $categories[$id].$parent_id;

	$categories[$id].$parent_id = $target;
	treeItem_recalcIdent($id, 1);

	$categories[$target].$children 		= $new_subs_target.split(",");
	$categories[$old_parent].$children 	= $new_subs_in_old.split(",");

	$categories[$target].$is_folder = 1;
	$categories[$target].$is_opened = 1;
	cookies_UpdateCookie($target, $cookie_name, "add");
	document.getElementById("c-"+$target).style.display = "block";
	treeItem_changeIcons($target);


	if (!$new_subs_in_old){
		$categories[$old_parent].$is_folder = 0;
		$categories[$old_parent].$is_opened = 0;
		treeItem_changeIcons($old_parent);
		cookies_UpdateCookie($old_parent, $cookie_name, "remove");
	}

	$container1 = document.getElementById("c-"+$id);
	$category1  = document.getElementById("cat-"+$id);
	$category2  = document.getElementById("c-"+$target);

	$category2.appendChild($category1);
	$category2.appendChild($container1);


	treeItem_fixLasts($old_parent);
	treeItem_fixLasts($target);

	tree_StopInsertMode();
}