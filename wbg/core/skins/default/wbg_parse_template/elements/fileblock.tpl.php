<?php
global $_CFG;

//$BUTTON = '<input type="button" class="button" value=" '.__PRS_ADD__.' " onclick="addfile(\''.$field.'\')">';
$BUTTON = '<a href="#" onclick="fileblock_edit_file(null, \''.$field.'\', '.(int)$rename_files.'); return false"><img src="'.$this->url_to_skin.'images/button-add-'.$_CFG['user']['interface_language'].'.gif" border="0" style="vertical-align:middle"/></a>';
//$BUTTON = '<a href="#" onclick="fileblock_add_file(\''.$field.'\', \'1\', \'2\', \'3\', \'4\'); return false"><img src="'.$this->url_to_skin.'images/button-add.gif" border="0" style="vertical-align:middle"/></a>';


$BUTTON = '<input type="button" onclick="fileblock_edit_file(null, \''.$field.'\', '.(int)$rename_files.');" value="    '.__PRS_FB5__.'   " class="button">';

$CONTAINER = '
	<div style="padding:5px 0px 10px 0px">
	<div style="padding-bottom:5px">'.$BUTTON.'</div>
	<table class="fileblock" id="fileblock['.$field.']">
		<tr>
			<th>'.__PRS_FB1__.'</th>
			<th>'.__PRS_FB2__.'</th>
			<th>'.__PRS_FB3__.'</th>
			<th>'.__PRS_FB4__.'</th>
			<th></th>
			<th></th>
		</tr>
		'.$LIST.'
	</table>
	</div>';
?>