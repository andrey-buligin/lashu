<?php
/**
 * Eto wbg_parse_template shablon.
 */
/**
 * @todo - Hujnja s setami, nuzhno taki davatj ID seta kategorii
 */

global $_CFG;
// Tut dobivajutsa spiski shablonov i modulej
include_once($_CFG['path_to_cms'].'core/libraries/tree/includes/_get_data.inc.php');

//--------------------------------------------------------------------------------------
if (!defined("NEW_CATEGORY")){
	$this->make_container($this->content['id'], "ID:");
}
//--------------------------------------------------------------------------------------
$data = '<input class="input" type="text" name="title" id="title" value="'.str_replace('"','&quot;',$this->content['title']).'" size="40" onblur=change_dir(this.value)>';
$data .= '<script>document.getElementById("title").focus();</script>';
$this->make_container($data,"".__STT_7__."");
//--------------------------------------------------------------------------------------
if ($this->content['type']==1){

} else {
	if ($this->content['type'] != 2){
		$this->content['dir'] = basename($this->content['dir']);
	}
	$link = '<input class="input"  type="text" name="dir" id="dir" value="'.str_replace('"','&quot;',$this->content['dir']).'" size="40">';
	$link .= ' '.__STT_8__.' <input type="checkbox" name="dir_is_link" id="dir_is_link" style="margin:0px" '.($this->content['type']==2?'checked':'').'>';
	$this->make_container($link, "".__STT_9__."", $this->content['type']==2?"style='background:#ffe6b9'":'');
}
//--------------------------------------------------------------------------------------
if (defined("NEW_CATEGORY")){
	$this->select("insert_before","".__STT_10__."", insert_before($_GET['parent_id']));
}
//--------------------------------------------------------------------------------------
$data = '<input type="checkbox" name="active" id="active" value="1" '.($this->content['active']?'checked':'').'>';
$this->make_container($data,"".__STT_11__."");
//--------------------------------------------------------------------------------------
$data = '<input type="checkbox" name="enabled" id="enabled" value="1" '.($this->content['enabled']?'checked':'').'>';
$this->make_container($data, "".__STT_12__."");

$this->make_container("","".__STT_13__."");
include_once($_CFG['path_to_cms'].'core/libraries/tree/includes/_get_sets.inc.php');

//--------------------------------------------------------------------------------------
?>
<?php $this->spacer()?>
<?php
if (defined("NEW_CATEGORY")){
	$this->select("property_template","".__STT_14__."", $property_templates);
	$this->select("property_template2","".__STT_15__."", $property_templates);
	$this->spacer();
}
?>

<?php
function insert_before($parent_id){
	global $_CFG;
	$options[0] = "".__STT_16__."";
	$options[-1] = "".__STT_17__."";

	$sql_res = mysql_query("SELECT id,title FROM ".(@$_CFG['categories']['sql_table']?$_CFG['categories']['sql_table']:'wbg_tree_categories')." WHERE parent_id=".$parent_id." order by sort_id");
	while ($arr = mysql_fetch_assoc($sql_res)) {
		$options[$arr['id']] = $arr['title'];
	}
	return $options;
}
?>