<?php

class comments {

	static $doc_id 	= 0;
	static $saved 	= 0;
	static $sql_table_name = '';
	static $sql_table_from = '';
	static $inited = false;
	static $error_on_comment = array();

	/**
	 * Initialization
	 *
	 * @param unknown_type $id
	 * @param unknown_type $sql_table_name
	 */
	function init($id, $sql_table_name) {

		//--------------------------------------------------------------------------------------
		// [[[ Captcha include

			include_once(dirname(__FILE__).'/../components/recaptcha.php');

		// ]]] Captcha include
		//--------------------------------------------------------------------------------------

		//if (self::$inited == false){
			self::$doc_id 			= $id;
			self::$sql_table_name	= '_mod_comments';
			self::$sql_table_from	= $sql_table_name;
			self::$inited 			= true;
		//}

		if (isset($_POST['comment'])){
			self::check_comment_data();
			if (self::$error_on_comment){ // $sli oshibka bila
				foreach ($_POST as $key=>$value) {
					$_POST[$key] = $value;
				}
			} else {
				self::insert_comment($_POST['name'], $_POST['email'], $_POST['comment']);
				$_POST = array();
			}
		}
	}

	/**
	 * Error checking
	 *
	 */
	function check_comment_data() {

		if (!trim($_POST['comment'])){
			self::$error_on_comment['comment'] = 1;
		}
		if (!trim(@$_POST['name'])){
			self::$error_on_comment['name'] = 1;
		}
		if (!trim(@$_POST['email'])){
			self::$error_on_comment['email'] = 1;
		}

		$recaptcha = new Recaptcha();
 		$valid = $recaptcha->validateRecaptcha( $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field'] );
		if (!$valid)
			self::$error_on_comment['captcha'] = 1;

		//ban list
		$bans = file(dirname(__FILE__).'/../input/edit_comments/blacklist');
		$newBans = array();
		if ($bans) {
			foreach ($bans as $key => $value) {
				if ($value) $newBans[] = trim($value);
			}
		}
		if (in_array($_SERVER['REMOTE_ADDR'], $newBans)){
			self::$error_on_comment['banned'] = 1;
		}
	}

	/**
	 * form showing
	 *
	 * @param unknown_type $id
	 * @return unknown
	 */
	function show_form() {

		self::_check_need_data();

		$recaptcha = new Recaptcha();
		$msg       = '<div class="pleaseFillForm">'.WBG::message("comments_welcome", null,1).'</div>';
		$show      = false;

		if ( self::$error_on_comment ) {
			$show = true;
			$msg  .= '<div class="submitErr">'.WBG::message("comments_please_check_fields", null,1).'</div>';
		} elseif ( self::$saved == 1 ) {
			$msg  .= '<div class="submitSucc">'.WBG::message("comments_succesufuly_added", null,1).'</div>';
		}

		return '<div id="writeComment"><a href="#" id="formOpener">'.WBG::message("write_comment",null,1).'</a></div>
				'.(@self::$error_on_comment['banned']?'<div id="banned" style="padding:10px 3px">You are banned!</div>':'').'
				'.$msg.'
			<form method="post" action="#commentForm" name="" id="commentForm" class="clear">
				<div class="input-box">
					<label for="nameField">'.WBG::message("comments_name", null, 1).' <span>*</span></label>
					<input class="input'.(@self::$error_on_comment['name']?' error':'').'" type="text" size="30" name="name" value="'.@$_POST['name'].'" id="nameField"/>
					<span id="nameInfo" class="validationHelper"></span>
				</div>
				<div class="input-box">
					<label for="emailField">'.WBG::message("comments_email", null, 1).' <span>*</span></label>
					<input class="input'.(@self::$error_on_comment['email']?' error':'').'" type="text" size="30" name="email" value="'.@$_POST['email'].'" id="emailField"/>
					<span id="emailInfo" class="validationHelper"></span>
				</div>
				<div class="input-box">
					<label for="commentField">'.WBG::message("comments_comment", null, 1).' <span>*</span></label>
					<textarea rows="4" cols="20" name="comment" class="long'.(@self::$error_on_comment['comment']?' error':'').'" id="commentField">'.@$_POST['comment'].'</textarea>
				</div>
				<div class="input-box captchaCode">
					<label for="comentField">'.WBG::message("comments_code", null, 1).' <span>*</span></label>
					<div class="captcha-box'.(@self::$error_on_comment['captcha']?' error':'').'">
						'.$recaptcha->getRecaptchaHTML().'
					</div>
				</div>
				<div class="input-box">
					<input class="submit-button" name="submit" value="'.WBG::message("comments_add", null, 1).'" type="submit" />
				</div>
			</form>';
	}

	public function showFrontEndValidation()
	{
		return '';
		// use layout->requiredJS
	}

	/**
	 * Feedback inserting
	 *
	 * @param unknown_type $name
	 * @param unknown_type $email
	 * @param unknown_type $comment
	 */
	function insert_comment($name, $email, $comment) {

		self::_check_need_data();

		$SQL_str = "INSERT INTO ".self::$sql_table_name."
						SET
							active			= '1',
							doc_id			= '".self::$doc_id."',
							sql_table_name 	= '".self::$sql_table_from."',
							name 			= '".mysql_escape_string($name)."',
							email			= '".mysql_escape_string($email)."',
							text 			= '".mysql_escape_string($comment)."',
							ip				= '".$_SERVER['REMOTE_ADDR']."',
							url				= 'http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."',
							datums			= '".time()."'";
		mysql_query($SQL_str);
		self::$saved = 1;

		//$SQL_str = "UPDATE  ".self::$sql_table_name." SET  comments_count = comments_count + 1 WHERE id=".self::$doc_id;
		///mysql_query($SQL_str);
		//echo mysql_error();

	}

	/**
	 * Feedbkack/Comments records list
	 *
	 * @return string
	 */
	function show_comments($id = '', $table = '', $title = 'Comments', $showWeeks = false) {

		self::_check_need_data();

		$HTML      = '';
		$x         = 0;
		$day	   = 86400;
		$week	   = 604800;

		$today     = 'Today';
		$thisWeek  = 'This week';
		$weeksAgo  = 'Few weeks ago';
		$monthAgo  = 'A month ago';
		$fewMontsAgo  = 'Few months ago';
		$yearAgo   = 'More than year ago';
		$now       = time();

		if ( $id && $table ) {
			$conditions = "AND doc_id = '".self::$doc_id."' AND sql_table_name='".$table."'";
			$orderBy    = "ASC";
		} else {
			$conditions = "";
			$orderBy    = "DESC";
		}

		$SQL_str = "SELECT * FROM ".self::$sql_table_name." WHERE active=1 ".$conditions." order by datums ".$orderBy;
		$sql_res = mysql_query($SQL_str);
		while ($arr = @mysql_fetch_assoc($sql_res)){

			$img   = '';
			$class = ($x++ %2 == 0 ? 'white' : 'grey');

			$date = date('d.m.Y.  H:i', $arr['datums']);

			if ($showWeeks) {
				if ( $now - $arr['datums'] < $day ) {
					$date = $today;
				} elseif ($now - $arr['datums'] < $week) {
					$date = $thisWeek;
				} elseif ($now - $arr['datums'] < $week * 4) {
					$date = $weeksAgo;
				} elseif ($now - $arr['datums'] < $week * 8) {
					$date = $monthAgo;
				} elseif ($now - $arr['datums'] < $week * 48) {
					$date = $fewMontsAgo;
				} else {
					$date = $yearAgo;
				}
			}

			$HTML .= '
				<article class="item '.$class.'">
					<header><h5 class="author">'.$arr['name'].'</h5></header>
					<time datetime="'.date('Y-m-d', $arr['datums']).'" class="date">'.$date.'</time>
					<p class="commentText">'.$arr['text'].'</p>
				</article>';
		}

		$title = $title ? '<h4 class="commentsTitle">'.$title.'</h4>' : '';
		if ($HTML) $HTML = '<section id="postedComments">'.$title.$HTML.'</section>';

		return $HTML;
	}

	/*
	 * Show count of feedbacks
	 *
	 * @param unknown_type $id
	 * @param unknown_type $table
	 * @return unknown
	 */
	function showCommentsCount($id = null, $table = null) {
		$SqlStr = "SELECT count(*) FROM ".self::$sql_table_name." WHERE active=1 AND sql_table_name='".$table."' AND doc_id=".$id;
		return mysql_result(mysql_query($SqlStr),0,0);
	}

	function _check_need_data() {
		if (self::$inited == false){
			echo "NO INITED !!!!!";
		}
	}
}
?>