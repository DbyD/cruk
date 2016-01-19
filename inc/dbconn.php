<?php
// Global settings
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	//error_reporting(E_ALL);
	
////////////////////////////////////////////////////////////////////////////////////
// DEFINE ROOT PATHS
////////////////////////////////////////////////////////////////////////////////////
		// this is for my machine must remove /cruk/
	define("RELATIVE_PATH_ROOT", '');
	define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"] . '/cruk/');
	define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));
	define("HTTP_PATH", 'http://'. HTTP_PATH_ROOT . '/cruk/');
////////////////////////////////////////////////////////////////////////////////////
	$xexecEmail = "alec@dbyd.co.za";
	$localServer = "http://".$_SERVER['HTTP_HOST']."/cruk/";
////////////////////////////////////////////////////////////////////////////////////

	$strFrom = "From: CRUK <noreply@ourheroes.co.uk> \r\nContent-type: text/html; charset=us-ascii";

////////////////////////////////////////////////////////////////////////////////////
// Server Setup
	$db_server = 'Localhost';
	$db_database = 'cruk';
	$db_user = 'DbyDcruk';
	$db_passwd = 'dbd#01master';
	try {
		$db = new PDO("mysql:host=$db_server;dbname=$db_database", $db_user, $db_passwd);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}
////////////////////////////////////////////////////////////////////////////////////
// General include files
	include 'class.php';
	include 'function.php';
////////////////////////////////////////////////////////////////////////////////////
	$encrypt = new Encryption;
	session_start();
?>