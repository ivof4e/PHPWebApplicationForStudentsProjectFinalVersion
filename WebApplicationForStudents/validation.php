<?php
	function ValidatePostValueLength($name, $from, $to) {
		$errors = array();
		if(!isset($_POST[$name])) {
			$errors[] = "Невалидна стойност на полето $name";
		}
		$val = $_POST[$name];
		if(strlen($val) < $from || strlen($val) > $to) {
			$errors[] = "Полето $name трябва да е с дължина от $from до $to символа.";
		}
		return $errors;
	}
	
	function ValidatePostValueRequired($name) {
		$errors = array();
		if(!isset($_POST[$name]) || $_POST[$name] == '') {
			$errors[] = "Полето $name е задължително.";
		}
		return $errors;
	}
	
	function ValidatePasswords($password1, $password2) {
		$errors = array();
		if(!isset($_POST[$password1]) || !isset($_POST[$password2]) || $_POST[$password1] != $_POST[$password2]) {
			$errors[] = "Двете пароли трябва да съвпадат.";
		}
		return $errors;
	}
?>