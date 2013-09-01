<?php
$this->textline("Book pages");
$this->spacer();
?>
<?php

$this->start_repeat_block('Manually specify your pages');
	echo $this->textarea("pages","Text/HTML",90, 5);
	//echo $this->smalltext("title_lat", "Name lat", "30", "60");
	echo $this->wysiwyg("pages",600,500);
$this->end_repeat_block();

$this->textarea("last_page_text","Text on last page",105, 5 );
$this->wysiwyg("last_page_text",600,500);

//$this->image("pictogram", "Pictogramme", "pictograms/");
?>