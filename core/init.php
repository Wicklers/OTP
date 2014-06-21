<?php
session_start();
error_reporting(E_ALL);
spl_autoload_register(function($class){
	require_once 'classes/'.$class.'.php';	
});
/*
 require_once 'classes/OTP.php';
 require_once 'classes/Token.php';
 require_once 'classes/Hash.php';
 require_once 'classes/Teacher.php';
 require_once 'classes/Input.php';
 require_once 'classes/Recaptcha.php';
 require_once 'classes/Redirect.php';
 require_once 'classes/Session.php';
 require_once 'classes/Validate.php';
*/
?>
