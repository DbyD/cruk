<?php
	session_start();
	$_SESSION['user'] = false;
	$_SESSION['admin'] = false;
	session_destroy();
	header( 'Location: ../index.php');
?>