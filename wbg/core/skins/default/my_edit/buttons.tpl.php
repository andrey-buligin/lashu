<?php

// Eto buttoni kotorije pokazivajutsa naverhu
$button_normal_container = '<div style="float:right; margin-bottom:4px">{BUTTONS}</div><div style="clear:both"></div>';
$button_normal[0] = '<div class="button"><input type="button" value="Save and return" onclick="window.sendform()"/></div>';
$button_normal[1] = '<div class="button"><input type="button" value="Save and coninue" onclick="window.applyform()"/></div>';
$button_normal[2] = '<div class="button"><input type="button" value="Return to list" onclick="window.cancelform()"/></div>';

// Eto buttoni kotirje idut v JS v parent Frame
$button_for_js[0] = '<div class="button"><input type="button" value=" Save and return " onclick=window.frames[0].window.sendform()></div>';
$button_for_js[1] = '<div class="button"><input type="button" value=" Save and coninue " onclick=window.frames[0].window.applyform()></div>';
$button_for_js[2] = '<div class="button"><input type="button" value=" Return to list " onclick=window.frames[0].window.cancelform()></div>';
$button_for_js[3] = '<span style="margin-left:40px; float:left">&nbsp;</span><div class="button"><input type="button" value=" Create New " onclick=window.frames[0].window.createnew()></div>';

?>