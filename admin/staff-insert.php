<?php
	include_once('../inc/config.php');

	$SQL = "INSERT INTO tblempall(EmpNum,Fname,Sname,PreferredFname,Eaddress,JobTitle,Grade,Shop,RetailArea,
			Team,Section,Department,Directorate,LocationName,LocationAddress,SuperUser,LMEmpNum,LMFname,
			LMSname,LMEaddress,LMGrade,AppEmpNum,AppFname,AppSname,AppEaddress,eligible,activated) 
			VALUES(:EmpNum,:Fname,:Sname,:PreferredFname,:Eaddress,:JobTitle,:Grade,:Shop,:RetailArea,
			:Team,:Section,:Department,:Directorate,:LocationName,:LocationAddress,:SuperUser,
			:LMEmpNum,:LMFname,:LMSname,:LMEaddress,:LMGrade,:AppEmpNum,:AppFname,:AppSname,:AppEaddress,:eligible,:activated)";
	global $db;
	$stmt = $db->prepare($SQL);
	$stmt->bindParam(':EmpNum', $_POST["EmpNum"]);
	$stmt->bindParam(':Fname', $_POST["Fname"]);
	$stmt->bindParam(':Sname', $_POST["Sname"]);
	$stmt->bindParam(':PreferredFname', $_POST["PreferredFname"]);
	$stmt->bindParam(':Eaddress', $_POST["Eaddress"]);
	$stmt->bindParam(':JobTitle', $_POST["JobTitle"]);
	$stmt->bindParam(':Grade', $_POST["Grade"]);
	$stmt->bindParam(':Shop', $_POST["Shop"]);
	$stmt->bindParam(':RetailArea', $_POST["RetailArea"]);
	$stmt->bindParam(':Team', $_POST["Team"]);
	$stmt->bindParam(':Section', $_POST["Section"]);
	$stmt->bindParam(':Department', $_POST["Department"]);
	$stmt->bindParam(':Directorate', $_POST["Directorate"]);
	$stmt->bindParam(':LocationName', $_POST["LocationName"]);
	$stmt->bindParam(':LocationAddress', $_POST["LocationAddress"]);
	$stmt->bindParam(':SuperUser', $_POST["SuperUser"]);
	$stmt->bindParam(':LMEmpNum', $_POST["LMEmpNum"]);
	$stmt->bindParam(':LMFname', $_POST["LMFname"]);
	$stmt->bindParam(':LMSname', $_POST["LMSname"]);
	$stmt->bindParam(':LMEaddress', $_POST["LMEaddress"]);
	$stmt->bindParam(':LMEaddress', $_POST["LMEaddress"]);
	$stmt->bindParam(':LMGrade', $_POST["LMGrade"]);
	$stmt->bindParam(':AppEmpNum', $_POST["AppEmpNum"]);
	$stmt->bindParam(':AppFname', $_POST["AppFname"]);
	$stmt->bindParam(':AppSname', $_POST["AppSname"]);
	$stmt->bindParam(':AppEaddress', $_POST["AppEaddress"]);
	$stmt->bindParam(':eligible',  $_POST["eligible"] , PDO::PARAM_INT);
	$stmt->bindParam(':activated',  $_POST["activated"] , PDO::PARAM_INT);
	$stmt->execute();
		
	header("location:staff.php");
?>