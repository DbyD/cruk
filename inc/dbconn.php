<?php
// Global settings
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	//error_reporting(E_ALL);
	$xexecEmail = "alec@dbyd.co.za";
	$localServer = "http://".$_SERVER['HTTP_HOST']."/cruk/";
////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////
// Server Setup
	$db_server = 'Localhost';
	$db_database = 'CRUK';
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