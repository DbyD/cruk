<?php 
	include '../inc/config.php';
	If ($_GET["activate"]=='yes')
	{
		$EmpNum = $_GET["EmpNum"];
		echo $EmpNum."<br>";
		$retrunEmpNum = $encrypt->decode($EmpNum);
		echo $retrunEmpNum;
		$stmt = $db->prepare('UPDATE tblempall SET activated=1 WHERE EmpNum = :EmpNum');
		if($stmt->execute(array(':EmpNum' => $retrunEmpNum)))
		{
			header( 'Location: ?activated');
		}
		 else 
		 {
			header( 'Location: ?notactivated');
		}
	}
?>