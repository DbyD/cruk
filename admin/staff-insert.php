<?php
	include_once('../inc/config.php');
	
	if(getName($_POST["EmpNum"]) == 'N/A'){
		
		$SQL = "INSERT INTO tblempall(EmpNum,Fname,Sname,PreferredFname,Eaddress,JobTitle,Grade,Shop,RetailArea,
				Team,Section,Department,Directorate,DirectorateInitials,LocationName,LocationAddress,SuperUser,LMEmpNum,LMFname,
				LMSname,LMEaddress,LMGrade,AppEmpNum,AppFname,AppSname,AppEaddress,eligible,activated) 
				VALUES(:EmpNum,:Fname,:Sname,:PreferredFname,:Eaddress,:JobTitle,:Grade,:Shop,:RetailArea,
				:Team,:Section,:Department,:Directorate,:DirectorateInitials,:LocationName,:LocationAddress,:SuperUser,
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
		$stmt->bindParam(':DirectorateInitials', $_POST["DirectorateInitials"]);
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
		
		// Here we do the password stuff.
		if((Trim($_POST["sPassword"]) != "") && (Trim($_POST["repeatPassword"]) != "")){
			if(Trim($_POST["sPassword"]) == Trim($_POST["repeatPassword"])){
				$SQL = "UPDATE tblempall SET sPassword = :Pass WHERE EmpNum = :ENum";
				$stmt = $db->prepare($SQL);
				$stmt->bindParam(':ENum', $_POST["EmpNum"]);
				$stmt->bindParam(':Pass', $_POST["sPassword"]);
				$stmt->execute();
			}
		}
		echo $_POST["Fname"]." ".$_POST["Sname"]." has been added.";
	} else {
		echo "Employee number: ".$_POST["EmpNum"]." already exists in the database. If this is a new employee please contact Xexec. If not please use the Staff Edit to update their details.";
	}
	
?>