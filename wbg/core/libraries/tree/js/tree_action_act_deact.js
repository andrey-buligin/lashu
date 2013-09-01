
function tree_function_act_deact($category_id, $mode){
	$categories[$category_id].$active = $mode ? 1 : 0;
	treeItem_changeIcons($category_id);
}