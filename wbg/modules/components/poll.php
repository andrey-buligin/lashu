<?php

include_once(dirname(__FILE__).'/../../config/config.php');

$pollCategories['64'] = 72;//philosophy

if( !isset($_POST['poll']) || !isset($_POST['pollid'])) 
{
    $category = 28;
    if ( isset($_GET['category'])) {
        if ( isset( $pollCategories[$_GET['category']] ) )
        {
            $category = $pollCategories[$_GET['category']];
        }
    }
    
	$query = mysql_query("SELECT id, question_eng FROM _mod_poll_questions WHERE active=1 AND category_id=$category ORDER BY id DESC LIMIT 1");
	while( $row = @mysql_fetch_assoc($query)){
		//display question
		echo "<p class=\"pollques\" >".$row['question_eng']."</p>";
		$poll_id=$row['id'];
	}
	
	if(@$_GET["result"] == 1 || @$_COOKIE["voted".$poll_id] == 'yes')
	{
		//if already voted or asked for result
		showresults($poll_id);
		exit;
	} else {
		//display options with radio buttons
		if ( !isset($poll_id) )
		{
		    echo '<div id="formcontainer"><p>Poll can\' be loaded.</p></div>';
		    exit;
		}
		$query = mysql_query("SELECT id, value_eng FROM _mod_poll_options WHERE ques_id=$poll_id");
		if( mysql_num_rows($query) ){
			echo '<div id="formcontainer" ><form method="post" id="pollform" action="'.$_SERVER['PHP_SELF'].'" >';
			echo '<input type="hidden" name="pollid" value="'.$poll_id.'" />';
			while($row=mysql_fetch_assoc($query)){
				echo '<p><input type="radio" name="poll" value="'.$row['id'].'" id="option-'.$row['id'].'" /> 
				<label for="option-'.$row['id'].'" >'.$row['value_eng'].'</label></p>';
			}
			echo '<p><input type="submit" id="pollSubmit" value="Submit" /></p></form>';
			echo '<p id="viewresult_p"><a href="'.$_SERVER['PHP_SELF'].'?result=1" id="viewresult">View result</a></p></div>';
		}
	}
} 
else 
{
	if( @$_COOKIE["voted".$_POST['pollid']] != 'yes' ){
		
		//Check if selected option value is there in database?
		$query = mysql_query("SELECT * FROM _mod_poll_options WHERE id='".intval($_POST["poll"])."'");
		if(mysql_num_rows($query)){
			$query = "INSERT INTO _mod_poll_votes(option_id, voted_on, ip) VALUES('".$_POST["poll"]."', '".date('Y-m-d H:i:s')."', '".$_SERVER['REMOTE_ADDR']."')";
			if(mysql_query($query))
			{
				//Vote added to database
				setcookie("voted".$_POST['pollid'], 'yes', time()+86400*300);				
			}
			else
				echo "There was some error processing the query: ".mysql_error();
		}
	}
	showresults(intval($_POST['pollid']));
}

function showresults($poll_id){
	
	$query = mysql_query("SELECT COUNT(*) as totalvotes FROM _mod_poll_votes WHERE option_id IN(SELECT id FROM _mod_poll_options WHERE ques_id='$poll_id')");
	while( $row = mysql_fetch_assoc($query))
		$total = $row['totalvotes'];
		$query = mysql_query("SELECT options.id, options.value_eng, COUNT(*) as votes FROM _mod_poll_votes as votes, _mod_poll_options as options 
							  WHERE votes.option_id=options.id AND votes.option_id IN(SELECT id FROM _mod_poll_options WHERE ques_id='$poll_id') GROUP BY votes.option_id");
	while($row = mysql_fetch_assoc($query)){
		$percent = round(($row['votes']*100)/$total);
		echo '<div class="option" ><p>'.$row['value_eng'].' (<em>'.$percent.'%, '.$row['votes'].' votes</em>)</p>';
		echo '<div class="bar ';
		if(@$_POST['poll']==$row['id']) echo ' yourvote';
		echo '" style="width: '.$percent.'%; " ></div></div>';
	}
	echo '<p>Total Votes: '.$total.'</p>';
}
?>