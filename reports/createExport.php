<?php
	session_start();
	include_once('../inc/config.php');
	include_once("../inc/report-functions.php");
	switch(intval($_POST["eType"])){
		case 1:
			$filename = "Nominations_" . date("Ymd") . ".csv";
			$dataLine = createNominationExport($_POST);
			break;
		case 2:
			$filename = "Redemption_" . date("Ymd") . ".csv";
			$dataLine = createRedemptionExport($_POST);
			break;
	}
	
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Description: File Transfer");
	header("Content-type: text/csv");
	header("Content-Disposition: attachment; filename={$filename}");
	header("Expires: 0");
	header("Content-Transfer-Encoding: binary");
	header("Pragma: public");

	$fh = @fopen( "php://output", "w" );
	$dataString = $dataLine . "\n";
	fwrite($fh, $dataString);
	fclose($fh);
	exit;
?>