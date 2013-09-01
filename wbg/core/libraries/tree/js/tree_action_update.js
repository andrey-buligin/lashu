
function tree_function_update($id,  $parent_id, $title, $is_folder, $is_opened, $is_last, $type, $enabled, $active, $children, $dir) {
	document.getElementById("t-"+$id).innerHTML = $title;
	$categories[$id].$dir = $dir;
	$categories[$id].$title = $title;
}