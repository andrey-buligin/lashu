<?php

$this->textline("Contacts");
$this->smalltext("name", "Name", "30", "60");
$this->smalltext("email", "E-mail", "30", "60");

?>
<?php

$this->spacer();
$this->datums("datums", "Date");
$this->textline("Review");
$this->textarea("text","Text:","80","10");
$this->wysiwyg("text",600,500);



//$this->smalltext("ip", "IP", "30", "60");

?>