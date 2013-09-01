function tree_do_onclick($id, $is_rightclick){
	
	if ($is_rightclick) return;
    var $cat = window.$active_categories.split(";");
    if($cat.length > 3){
        return;
    }
    if (!$id || $current_event.shiftKey || $current_event.ctrlKey){
        return;
    }

    document.getElementById("category_id").value = $id;
    document.getElementById("mainform").submit();

}
