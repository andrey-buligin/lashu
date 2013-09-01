<?php
	function validateName($name){
		//if it's NOT valid
		if(strlen($name) < 3)
			return false;
		//if it's valid
		else
			return true;
	}
	function validateEmail($email){
		return ereg("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
	}
	function validatePasswords($pass1, $pass2) {
		//if DOESN'T MATCH
		if(strpos($pass1, ' ') !== false)
			return false;
		//if are valid
		return $pass1 == $pass2 && strlen($pass1) > 5;
	}
	function validateMessage($message){
		//if it's NOT valid
		if(strlen($message) < 10)
			return false;
		//if it's valid
		else
			return true;
	}
?>