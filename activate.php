<?php 
	include 'inc/config.php';
	If ($_GET["activate"]=='yes'){
		$EmpNum = $_GET["EmpNum"];
		echo $EmpNum."<br>";
		$retrunEmpNum = $encrypt->decode($EmpNum);
		echo $retrunEmpNum;
		$stmt = $db->prepare('UPDATE tblempall SET statusID=1 WHERE EmpNum = :EmpNum');
		if($stmt->execute(array(':EmpNum' => $EmpNum))){
			header( 'Location: activated.php?status=done');
		} else {
			header( 'Location: activated.php?status=error');
		}
	}
?>