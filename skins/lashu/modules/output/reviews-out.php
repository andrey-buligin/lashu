<?php
global $_CFG;

include_once($_CFG['path_to_modules'].'/components/show_comments.php');

class reviews extends comments
{

	function init() {
		global $_CFG;

		include_once($_CFG['path_to_modules'].'/components/recaptcha.php');

		self::$sql_table_name	= '_mod_reviews';
		self::$inited 			= true;

		if (isset($_POST['comment'])) {
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

	function insert_comment($name, $email, $comment) {

		self::_check_need_data();

		$SQL_str = "INSERT INTO ".self::$sql_table_name."
						SET
							active			= '1',
							name 			= '".mysql_escape_string($name)."',
							email			= '".mysql_escape_string($email)."',
							text 			= '".mysql_escape_string($comment)."',
							ip				= '".$_SERVER['REMOTE_ADDR']."',
							datums			= '".time()."'";
		mysql_query($SQL_str);
		self::$saved = 1;
	}

	function show_form() {

		self::_check_need_data();

		$recaptcha = new Recaptcha();
		$msg       = '<div class="pleaseFillForm">'.WBG::message("reviews_welcome", null,1).'</div>';
		$show      = false;

		if ( self::$error_on_comment ) {
			$show = true;
			$msg  .= '<div class="submitErr">'.WBG::message("review_please_check_fields", null,1).'</div>';
		} elseif ( self::$saved == 1 ) {
			$msg  .= '<div class="submitSucc">'.WBG::message("review_succesufuly_added", null,1).'</div>';
		}

		return '<div id="writeComment"><a href="#" id="formOpener">'.WBG::message("review_add",null,1).'</a></div>
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
					<input class="submit-button" name="submit" value="'.WBG::message("review_add_button", null, 1).'" type="submit" />
				</div>
			</form>';
	}

	public function showReviews()
	{
		return '<div id="reviews">
					<header><h1>'.WBG_HELPER::insertCatTitle().'</h1></header>'.
					'<div id="formContainer">'.
				 		self::show_form().
				 	'</div>'.
					self::showFrontEndValidation().
				 	self::show_comments( null, null, '', true).
				'</div>';
	}
}

reviews::init();

$return_from_module = reviews::showReviews();

?>