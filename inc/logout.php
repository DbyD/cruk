<?php
	include 'config.php';
	
	session_start();
	session_unset();
	/*
	$_SESSION['user'] = false;
	$_SESSION['admin'] = false;
	*/
	session_destroy();
	header( 'Location: ../index.php');
?>