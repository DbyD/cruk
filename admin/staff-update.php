<?php
	include_once('../inc/config.php');

	$SQL = "UPDATE tblempall SET Fname = :Fname, Sname = :Sname, PreferredFname = :PreferredFname, 
			Eaddress = :Eaddress, JobTitle = :JobTitle, Grade = :Grade, Shop = :Shop, RetailArea = :RetailArea,	
		    Team = :Team, Section = :Section, Department = :Department, Directorate = :Directorate, 
			LocationName = :LocationName, LocationAddress = :LocationAddress, SuperUser = :SuperUser, 
			LMEmpNum = :LMEmpNum, LMFname = :LMFname, LMSname = :LMSname, LMEaddress = :LMEaddress, LMGrade = :LMGrade, 
			AppEmpNum = :AppEmpNum, AppFname = :AppFname, AppSname = :AppSname, AppEaddress = :AppEaddress, eligible = :eligible, activated = :activated
		   WHERE EmpNum = :EmpNum";
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