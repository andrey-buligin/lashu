
function tree_function_update($old_id, $title, $new_id) {

	$categories[$old_id].$title = $title;
	$categories[$old_id].$id = $new_id;
	$categories[$new_id] = $categories[$old_id];
	document.getElementById("t-"+$old_id).innerHTML = $title;

}