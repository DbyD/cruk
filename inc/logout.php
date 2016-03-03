<?php
	include 'config.php';
	
	session_unset();
	/*
	$_SESSION['user'] = false;
	$_SESSION['admin'] = false;
	*/
	session_destroy();
	if(isset($_GET['redir']))
		header( 'Location: ../index.php');
	else
		header('Location: https://cruk3.xexec.com/Home/Logout/?redir=0');
?>