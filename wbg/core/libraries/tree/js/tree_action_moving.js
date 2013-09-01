function tree_function_move_up($from, $to, $new_subs){
	tree_move($from, $to, $new_subs);
}

function tree_function_move_down($from, $to, $new_subs){
	tree_move($from, $to, $new_subs);
}

function tree_move($from, $to, $new_subs){
	$container1 = document.getElementById("c-"+$to);
	$category1  = document.getElementById("cat-"+$to);
	$category2  = document.getElementById("cat-"+$from);

	$category2.parentNode.insertBefore($category1 ,$category2);
	$category2.parentNode.insertBefore($container1, $category2);
	$categories[$categories[$from].$parent_id].$children = $new_subs.split(",");

	treeItem_fixLasts($categories[$from].$parent_id);
}