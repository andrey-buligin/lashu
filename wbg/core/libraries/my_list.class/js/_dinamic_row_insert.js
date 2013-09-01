function myl_insert_row($table, $items, $id){
	$tr = $table.insertRow(1);
	$tr.className = "active";
	$tr.setAttribute("id","tr["+$id+"]");

	$counter = $items.length;
	for ($x=0; $x < $counter; $x++) {
		$td = $tr.insertCell(0);
		$td.innerHTML = $items[$x];
		$td.onclick = edit_element;
		$td.style.cursor = "pointer";

	}
	$td = $tr.insertCell(0);
	$td.innerHTML = $id;
	$td.onclick = edit_element;
	$td.style.cursor = "pointer";
	$td = $tr.insertCell(0);
	$td.innerHTML = '<input type="checkbox" value="'+$id+'" name="chk_el[]" class="checkbox"/>';
	return $tr;
}