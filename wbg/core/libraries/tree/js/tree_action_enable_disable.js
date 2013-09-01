
function tree_function_enable_disable($category_id, $mode){
	$categories[$category_id].$enabled = $mode ? 1 : 0;
	treeItem_changeIcons($category_id);
}