<?php

require 'Mysql.php';

class Membership {
	
	function validate_user($un, $pwd) {
		$mysql = New Mysql();
		$ID = $mysql->verify_Username_and_Pass($un, hash('sha256', $pwd));
		
		if($ID) {
			$_SESSION['status'] = 'authorized';
			header("location: index.php");
			$_SESSION['username'] = $un;
			$_SESSION['ID'] = $ID;
		} else return "Please enter a correct username and password";
		
	} 
	
	function log_User_Out() {
		if(isset($_SESSION['status'])) {
			unset($_SESSION['status']);
			
			if(isset($_COOKIE[session_name()])) 
				setcookie(session_name(), '', time() - 1000);
				session_destroy();
		}
	}
	
	function confirm_Member() {
		session_start();
		if($_SESSION['status'] !='authorized') header("location: login.php");
	}

	function add_user($un, $pwd) {

		//Check format of email address
		if (!filter_var($un, FILTER_VALIDATE_EMAIL)) {
    		return "Please enter a valid email address";
		}
		
		$mysql = New Mysql();
		$username_taken = $mysql->find_Username($un);

		if (!$username_taken) {
			//add user to database
			$mysql->register_User($un, hash('sha256', $pwd));
			//log user in
			$_SESSION['status'] = 'authorized';
			header("location: index.php");
			$_SESSION['username'] = $un;
		}
		else
			return "Email has already been registered.";
	}
	
}