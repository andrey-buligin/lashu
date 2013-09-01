<?php

include 'securimage.php';

$img = new securimage();

$img->image_width 	= 160;
$img->image_height	= 25;
$img->arc_line_colors = "#b34141";
$img->font_size 	 = 16;
$img->line_thickness = 1;
$img->line_color	 = "#8e8b8b";

$img->show(); // alternate use:  $img->show('/path/to/background.jpg');

?>
