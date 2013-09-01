<?php

$this->content['affect_subcats'] = 0;

global $_CFG;

// Tut dobivajutsa spiski shablonov i modulej
include_once($_CFG['path_to_cms'].'core/libraries/tree/includes/_get_data.inc.php');

$header = '<input type="checkbox" name="" value="1" style="vertical-align:middle; margin-right:10px" onclick="set_mode(this)"/>';
$this->make_container("",$header ."Change settings :");

$DISABLED = ' disabled';
include_once($_CFG['path_to_cms'].'core/libraries/tree/includes/_get_sets.inc.php');
$this->spacer();

$header = '<input type="checkbox" name="" value="1" style="vertical-align:middle; margin-right:10px" onclick="make_checked(this,\'property_template\')"/>'.'Change Property template 1';
$this->select("property_template", $header , $property_templates, null, "disabled");

$header = '<input type="checkbox" name="" value="1" style="vertical-align:middle; margin-right:10px" onclick="make_checked(this,\'property_template2\')"/>'.'Change Property template 2';
$this->select("property_template2",$header, $property_templates, null, "disabled");

$this->spacer();
$data = $this->checkbox("affect_subcats", null);
$this->make_container($data, "Affects subcategories too", 'style="background:#ffffff"');
$this->spacer();


?>
<script>
function make_checked($obj, $item){
	document.getElementById($item).disabled = $obj.checked ? 0 : 1;
}
function set_mode($obj){
	var $mode = $obj.checked ? "" : "none";
	$table = $obj.parentNode.parentNode.parentNode;
	dis_all($table.rows[3], $mode);
	dis_all($table.rows[5], $mode);
}

function dis_all($row, $mode){
	$inputs = $row.getElementsByTagName("select");
	$counter = $inputs.length;
	for ($x=0; $x < $counter; $x++) {
		$inputs[$x].disabled = $mode;
	}
}
</script>