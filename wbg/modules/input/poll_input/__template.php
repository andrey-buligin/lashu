<?php
$this->textline("Poll question");
$this->spacer();
?>
<?php
$this->smalltext("question_lat", "Question lat", "80", "60");
$this->smalltext("question_eng", "Question eng", "80", "60");
$this->smalltext("question_rus", "Question rus", "80", "60");

$query = mysql_query("SELECT * FROM _mod_poll_options WHERE ques_id=".$_GET['edit']);
while( $option = mysql_fetch_assoc($query)) {
	$this->content['value_eng'][] = $option['value_eng'];
	$this->content['value_lat'][] = $option['value_lat'];
	$this->content['value_rus'][] = $option['value_rus'];
}

$this->start_repeat_block("List of available options", "Options");
    echo "Option eng:" . $this->text("value_eng", null, 20);
    echo "&nbsp;";
    echo "Option lat" . $this->text("value_lat", null, 20);
    echo "&nbsp;";
    echo "Option rus" . $this->text("value_rus", null, 20);
$this->end_repeat_block(); 
?>