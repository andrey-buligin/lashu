function check_all($obj){
	$all = document.getElementsByTagName("INPUT");
	$count = $all.length;
	for ($x=0;$x<$count;$x++){
		if ($all[$x].getAttribute("name")=="chk_el[]"){
			$all[$x].checked = $obj.checked ? true : false;
		}
	}
}
function delete_elements($url_addon){
	if (!confirm($translation_1)) return false;
	$temp = document.location.href.split("?");
	document.forms["mainform"].action = $temp[0]+"?"+$url_addon;
	return true;
}