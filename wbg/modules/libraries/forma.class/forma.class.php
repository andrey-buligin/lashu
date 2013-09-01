<?php

	interface FormInterface {
		
		function showForm($msg = '');
		function checkData($name);
		function _checkForExistance($fieldname, $POST, &$ERROR);
		function _oneRow($title, $name);
		
	}

//////////////////////////////////////////////////////////////////////////////////////////////////

	class Form implements FormInterface {
		
		static $ERROR = array();
		static $POST = array();
		
		function showForm($msg = '') {
			global $web;
			
			return  '<form method="post" name="" id="form">
						'.$msg.'
						<table cellpadding="0" cellspacing="0" border="0" align="center">
							<tr valign="top">
								<td>
									<div>'.WBG::message("form_name", null, 1).'<span>*</span></div><input class="input" name="name" type="text" value="'.@$_POST['name'].'" />
								</td>
							</tr>
							<tr valign="top">
								<td><div>'.WBG::message("form_subject", null, 1).'</div><input class="input" name="subject" type="text" value="'.@$_POST['subject'].'" /></td>
							</tr>
							<tr valign="top">
								<td><div>'.WBG::message("form_phone_number", null, 1).'</div><input class="input" name="phone" type="text" value="'.@$_POST['phone'].'" /></td>
							</tr>
							<tr valign="top">
								<td><div>'.WBG::message("form_question", null, 1).'<span>*</span></div><textarea name="question">'.@$_POST['question'].'</textarea></td>
							</tr>
							<tr valign="top">
								<td align="center">
									<div align="center"><a href="#" onclick="$(\'#form\').submit()">'.WBG::message("form_sent", null, 1).'</a></div>
									<div align="center"><a href="#" onclick="$(\'#form\').get(0).reset()">'.WBG::message("form_cancel", null, 1).'</a></div>
								</td>
							</tr>
						</table>
						<input type="hidden" value="1" name="formSubmit" />
					</form>';
		}
		
		function checkData($name) {
			global $web;
			
			if (@$_POST[$name]) {
				
				self::$POST = $_POST;
				
				self::_checkForExistance('name', $_POST, self::$ERROR);
				self::_checkForExistance('question', $_POST, self::$ERROR);
				
				if (!self::$ERROR) {
					$recepient 	= WBG::message("form_receiver", null, 1);
					$subject 	= WBG::message("form_mail_subject", null, 1);
					$text 		= WBG::message("form_mail_text", null, 1).' "'.print_r(self::$POST,1);
					mail("surfer@inbox.lv",$subject,$text);
					//self::send_mail($recepient, $text, $subject, 'kinoskola@info.lv', 'kino_skola.lv');
					return '<div class="msgText" style="color:#6b2525; font-size:14px; ">'.WBG::message("form_mail_succes_sent", null, 1).'</div>';
				} else {
					return '<div class="msgText" style="color:#6b2525; font-size:14px; ">'.WBG::message("form_check_fields", null, 1).'</div>';
				}
			}
		}
		
		function _oneRow($title, $name, $type = 'input', $options=''){
			
			$cellStyle = '';
			switch ($type) {
				case 'textarea':
					$input = '<textarea name="'.$name.'" >'.@self::$POST[$name].'</textarea>';
					break;
				case 'select':
					 $input = '<select class="input" name="'.$name.'" >'.$options.'</select>';
					  break;
				case 'checkbox':
					 if ($options) {
					 	//neskolko checkboxov
					 	$cellStyle = ' align="right"';
					 	$input  = '';
					 	$c 		= 0;
					 	foreach ($options as $key=> $value) {
					 		$input .= '<span '.($key=='operatora_darbs'?'style="border:0px solid red;width:115px;"':'').'>'.$value.'<input type="checkbox" '.(@$_POST[$key]?'checked':'').' name="'.$key.'" value="1" ></span>'.(++$c%3==0?'<br/>':'');
					 	}
					 	if ($name == 'kadi_kursi_interese'){
					 		$input .= '<br class="spacer"/>vēl kas cits<input class="small_input"  type="text" name="interese_citi" value="'.@self::$POST['interese_citi'].'">';
					 	}
					 } else {
					 	$input = '<input type="checkbox" value="1" name="'.$name.'" >';
					 }
					 break;
				default:
					$input = '<input class="input"  type="text" name="'.$name.'" value="'.@self::$POST[$name].'">';
					break;
			}
			return '<tr valign="top">
						<td class="fieldCell" '.@self::$ERROR[$name].'>'.$title.'</td>
						<td '.$cellStyle.'> <div class="inputCell">'.$input.'</div></td>
					</tr>';
		}
		
		function _checkForExistance($fieldname, $POST, &$ERROR) {
			if (!isset($_POST[$fieldname])) {
				$ERROR[$fieldname] = ' style="color:red"';
			} else {
				if (is_array($POST[$fieldname])) {
					foreach ($POST[$fieldname] as $key => $value) {
						if (!trim($POST[$fieldname][$key])){
							$ERROR[$fieldname][$key] = ' style="color:red"';
						}
					}
				} else {
					if (!trim($POST[$fieldname])){
						$ERROR[$fieldname] = ' style="color:red"';
					}
				}
			}
		}
		
		function send_mail($to='surfer@inbox.lv', $body, $subject, $fromaddress, $fromname, $attachments=false){
			$eol="\r\n";
			$mime_boundary=md5(time());
			$headers = '';
			
			# Common Headers
			$headers .= "From: ".$fromname."<".$fromaddress.">".$eol;
			$headers .= "Reply-To: ".$fromname."<".$fromaddress.">".$eol;
			$headers .= "Return-Path: ".$fromname."<".$fromaddress.">".$eol;    // these two to set reply address
			$headers .= "Message-ID: <".time()."-".$fromaddress.">".$eol;
			$headers .= "X-Mailer: PHP v".phpversion().$eol;          // These two to help avoid spam-filters
			
			# Boundry for marking the split & Multitype Headers
			//$headers .= 'MIME-Version: 1.0'.$eol.$eol;
			$headers .= "Content-Type: multipart/mixed; boundary=\"".$mime_boundary."\"".$eol.$eol;
			
			# Open the first part of the mail
			$msg = "--".$mime_boundary.$eol;
			
			$htmlalt_mime_boundary = $mime_boundary."_htmlalt"; //we must define a different MIME boundary for this section
			# Setup for text OR html -
			$msg .= "Content-Type: multipart/alternative; boundary=\"".$htmlalt_mime_boundary."\"".$eol.$eol;
			
			# Text Version
			$msg .= "--".$htmlalt_mime_boundary.$eol;
			$msg .= "Content-Type: text/plain; charset=utf-8".$eol;
			$msg .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
			$msg .= strip_tags(str_replace("<br>", "\n", substr($body, (strpos($body, "<body>")+6)))).$eol.$eol;
			
			# HTML Version
//			$msg .= "--".$htmlalt_mime_boundary.$eol;
//			$msg .= "Content-Type: text/html; charset=utf-8".$eol;
//			$msg .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
//			$msg .= $body.$eol.$eol;
			
			//close the html/plain text alternate portion
			$msg .= "--".$htmlalt_mime_boundary."--".$eol.$eol;
			
			if ($attachments != false){
				for($i=0; $i < count($attachments); $i++){
					if (is_file($attachments[$i]["file"])){  
						# File for Attachment
						$file_name = substr($attachments[$i]["file"], (strrpos($attachments[$i]["file"], "/")+1));
						$handle=fopen($attachments[$i]["file"], 'rb');
						$f_contents=fread($handle, filesize($attachments[$i]["file"]));
						$f_contents=chunk_split(base64_encode($f_contents));    //Encode The Data For Transition using base64_encode();
						$f_type=filetype($attachments[$i]["file"]);
						fclose($handle);
						
						# Attachment
						$msg .= "--".$mime_boundary.$eol;
						$msg .= "Content-Type: ".$attachments[$i]["content_type"]."; name=\"".$file_name."\"".$eol;  // sometimes i have to send MS Word, use 'msword' instead of 'pdf'
						$msg .= "Content-Transfer-Encoding: base64".$eol;
						$msg .= "Content-Description: ".$file_name.$eol;
						$msg .= "Content-Disposition: attachment; filename=\"".$file_name."\"".$eol.$eol; // !! This line needs TWO end of lines !! IMPORTANT !!
						$msg .= $f_contents.$eol.$eol;
					}
				}
			}
			
			# Finished
			$msg .= "--".$mime_boundary."--".$eol.$eol;  // finish with two eol's for better security. see Injection.
	
			# SEND THE EMAIL
			$mail_sent = mail($to, "=?UTF-8?B?".base64_encode($subject)."?=", $msg, $headers);
			
			return $mail_sent;
		}
	}

//////////////////////////////////////////////////////////////////////////////////////////////////

?>