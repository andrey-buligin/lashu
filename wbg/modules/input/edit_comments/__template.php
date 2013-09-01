<?php
$this->textline("Comment");
$this->spacer();
?>
<?php
$this->smalltext("doc_id", "Document. nr", "30", "60");
$this->smalltext("sql_table_name", "Table", "30", "60");
$this->textarea("text","Text:","80","10");
$this->wysiwyg("text",600,500);

$this->textline("Contacts");
$this->smalltext("name", "Name", "30", "60");
$this->smalltext("email", "E-mail", "30", "60");
$this->smalltext("ip", "IP", "30", "60");
$this->smalltext("url", "URL", "30", "60");
$this->datums("datums", "Datums");
?>