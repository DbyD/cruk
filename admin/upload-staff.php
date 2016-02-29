<?php
	include_once('../inc/config.php');
	
	$filename = $_FILES['staffFile']['name'];
	$tempname = $_FILES['staffFile']['tmp_name'];
	$filesize = $_FILES['staffFile']['size'];
	$dfiletype = $_FILES['staffFile']['type'];
	
	$uploadfile = basename($filename);
	$sourcefile = $tempname;
	move_uploaded_file($sourcefile, "../uploads/" . $uploadfile);
	$lineseparator = "\n";
	
	$csvfile = "../uploads/" . $uploadfile;
	if(!file_exists($csvfile)) {
		echo "File not found. " .$csvfile. " Make sure you specified the correct path.\n";
		exit;
	}
	$file = fopen($csvfile,"r");
	if(!$file) {
		echo "Error opening data file.\n";
		exit;
	}
	$size = filesize($csvfile);
	if(!$size) {
		echo "File is empty.\n";
		exit;
	}
	$csvcontent = fread($file,$size);
	fclose($file);
	$lines = 0;
	$counter = 0;
	global $db;
	foreach(explode($lineseparator,$csvcontent) as $line) {
		echo $line . "\r" . "\n";
		$lines++;
		if(trim($line != "")){
			$linearray = explode(",",$line);
			// Create SQL Statement
			// Prepare and pass data into parameters
			// Execute 
			$SQL = "SELECT COUNT(*) AS Cnt FROM tblempall WHERE EmpNum = :EmpNum";
			$stmt = $db->prepare($SQL);
			$stmt->bindParam(':EmpNum', $linearray[0]);
			$stmt->execute();
			$check = $stmt->fetchAll(PDO::FETCH_OBJ);
			if($check[0]->Cnt == 0){
				$SQL = "INSERT INTO tblempall(EmpNum,Fname,Sname,PreferredFname,Eaddress,JobTitle,Grade,Shop,RetailArea
				   		Team,Section,Department,Directorate,DirectorateInitials,LocationName,LocationAddress,Offline,SuperUser,
						LMEmpNum,LMFname,LMSname,LMEaddress,LMGrade,AppEmpNum,AppFname,AppSname,AppEaddresseligible)
				   		VALUES(:EmpNum,:Fname,:Sname,:PreferredFname,:Eaddress,:JobTitle,:Grade,:Shop,:RetailArea,
				   		:Team,:Section,:Department,:Directorate,:DirectorateInitials,:LocationName,:LocationAddress,:Offline,:SuperUser,
				   		:LMEmpNum,:LMFname,:LMSname,:LMEaddress,:,LMGrade:AppEmpNum,:AppFname,:AppSname,:AppEaddress,:eligable)";
					
				$stmt = $db->prepare($SQL);
				$stmt->bindParam(':EmpNum', $linearray[0]);
				$stmt->bindParam(':Fname', $linearray[1]);
				$stmt->bindParam(':Sname', $linearray[2]);
				$stmt->bindParam(':PreferredFname', $linearray[3]);
				$stmt->bindParam(':Eaddress', $linearray[4]);
				$stmt->bindParam(':JobTitle', $linearray[5]);
				$stmt->bindParam(':Grade', $linearray[6]);
				$stmt->bindParam(':Shop', $linearray[7]);
				$stmt->bindParam(':RetailArea', $linearray[8]);
				$stmt->bindParam(':Team', $linearray[9]);
				$stmt->bindParam(':Section', $linearray[10]);
				$stmt->bindParam(':Department', $linearray[11]);
				$stmt->bindParam(':Directorate', $linearray[12]);
				$stmt->bindParam(':DirectorateInitials', $linearray[13]);
				$stmt->bindParam(':LocationName', $linearray[14]);
				$stmt->bindParam(':LocationAddress', $linearray[15]);
				$stmt->bindParam(':Offline', $linearray[16]);
				$stmt->bindParam(':SuperUser', $linearray[17]);
				$stmt->bindParam(':LMEmpNum', $linearray[18]);
				$stmt->bindParam(':LMFname', $linearray[19]);
				$stmt->bindParam(':LMSname', $linearray[20]);
				$stmt->bindParam(':LMEaddress', $linearray[21]);
				$stmt->bindParam(':LMGrade', $linearray[22]);
				$stmt->bindParam(':AppEmpNum', $linearray[23]);
				$stmt->bindParam(':AppFname', $linearray[24]);
				$stmt->bindParam(':AppSname', $linearray[25]);
				$stmt->bindParam(':AppEaddress', $linearray[26]);
				$stmt->bindParam(':eligable', $linearray[27]);
				$stmt->execute();
			} else {
				$SQL = "UPDATE tblempall SET Fname = :FName, Sname = :Sname, 
						PreferredFname = :PreferredFname, Eaddress = :Eaddress, JobTitle = :JobTitle, 
						Grade = :Grade, Shop = :Shop, RetailArea = :RetailArea, Team = :Team, Section = :Section, Department = :Department, 
						Directorate = :Directorate, DirectorateInitials = :DirectorateInitials, LocationName = :LocationName, LocationAddress = :LocationAddress, 
						Offline = :Offline, SuperUser = :SuperUser, LMEmpNum = :LMEmpNum, LMFname = :LMFname,LMSname  = :LMSname,LMEaddress = :LMEaddress,  
				   		AppEmpNum = :AppEmpNum, AppFname = :AppFname, AppSname = :AppSname, AppEaddress = :AppEaddress, eligible = :eligible
				   		WHERE EmpNum = :EmpNum";
					
				$stmt = $db->prepare($SQL);
				$stmt->bindParam(':EmpNum', $linearray[0]);
				$stmt->bindParam(':Fname', $linearray[1]);
				$stmt->bindParam(':Sname', $linearray[2]);
				$stmt->bindParam(':PreferredFname', $linearray[3]);
				$stmt->bindParam(':Eaddress', $linearray[4]);
				$stmt->bindParam(':JobTitle', $linearray[5]);
				$stmt->bindParam(':Grade', $linearray[6]);
				$stmt->bindParam(':Shop', $linearray[7]);
				$stmt->bindParam(':RetailArea', $linearray[8]);
				$stmt->bindParam(':Team', $linearray[9]);
				$stmt->bindParam(':Section', $linearray[10]);
				$stmt->bindParam(':Department', $linearray[11]);
				$stmt->bindParam(':Directorate', $linearray[12]);
				$stmt->bindParam(':DirectorateInitials', $linearray[13]);
				$stmt->bindParam(':LocationName', $linearray[14]);
				$stmt->bindParam(':LocationAddress', $linearray[15]);
				$stmt->bindParam(':Offline', $linearray[16]);
				$stmt->bindParam(':SuperUser', $linearray[17]);
				$stmt->bindParam(':LMEmpNum', $linearray[18]);
				$stmt->bindParam(':LMFname', $linearray[19]);
				$stmt->bindParam(':LMSname', $linearray[20]);
				$stmt->bindParam(':LMEaddress', $linearray[21]);
				$stmt->bindParam(':LMGrade', $linearray[22]);
				$stmt->bindParam(':AppEmpNum', $linearray[23]);
				$stmt->bindParam(':AppFname', $linearray[24]);
				$stmt->bindParam(':AppSname', $linearray[25]);
				$stmt->bindParam(':AppEaddress', $linearray[26]);
				$stmt->bindParam(':eligable', $linearray[27]);
				$stmt->execute();
			}
		}
	}
	header("location:staff.php");
?>