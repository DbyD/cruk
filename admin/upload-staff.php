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
				$SQL = "INSERT INTO tblempall(EmpNum,Fname,Sname,PreferredFname,Eaddress,JobTitle,Grade,Shop,
				   		Team,Section,Department,Directorate,LocationName,LocationAddress,SuperUser,LMEmpNum,LMFname,
				   		LMSname,LMEaddress,AppEmpNum,eligible)
				   		VALUES(:EmpNum,:Fname,:Sname,:PreferredFname,:Eaddress,:JobTitle,:Grade,:Shop,
				   		:Team,:Section,:Department,:Directorate,:LocationName,:LocationAddress,:SuperUser,
				   		:LMEmpNum,:LMFname,:LMSname,:LMEaddress,:APPEnum,:eligable)";
					
				$stmt = $db->prepare($SQL);
				$stmt->bindParam(':EmpNum', $linearray[0]);
				$stmt->bindParam(':Fname', $linearray[1]);
				$stmt->bindParam(':Sname', $linearray[2]);
				$stmt->bindParam(':PreferredFname', $linearray[3]);
				$stmt->bindParam(':Eaddress', $linearray[4]);
				$stmt->bindParam(':JobTitle', $linearray[5]);
				$stmt->bindParam(':Grade', $linearray[6]);
				$stmt->bindParam(':Shop', $linearray[7]);
				$stmt->bindParam(':Team', $linearray[8]);
				$stmt->bindParam(':Section', $linearray[9]);
				$stmt->bindParam(':Department', $linearray[10]);
				$stmt->bindParam(':Directorate', $linearray[11]);
				$stmt->bindParam(':LocationName', $linearray[12]);
				$stmt->bindParam(':LocationAddress', $linearray[13]);
				$stmt->bindParam(':SuperUser', $linearray[14]);
				$stmt->bindParam(':LMEmpNum', $linearray[15]);
				$stmt->bindParam(':LMFname', $linearray[16]);
				$stmt->bindParam(':LMSname', $linearray[17]);
				$stmt->bindParam(':LMEaddress', $linearray[18]);
				$stmt->bindParam(':APPEnum', $linearray[20]);
				$stmt->bindParam(':eligable', $linearray[21]);
				$stmt->execute();
			} else {
				$SQL = "UPDATE tblempall SET Fname = :FName, Sname = :Sname, 
						PreferredFname = :PreferredFname, Eaddress = :Eaddress, JobTitle = :JobTitle, 
						Grade = :Grade, Shop = :Shop, Team = :Team, Section = :Section, Department = :Department, 
						Directorate = :Directorate, LocationName = :LocationName, LocationAddress = :LocationAddress, 
						SuperUser = :SuperUser, LMEmpNum = :LMEmpNum, LMFname = :LMFname,
				   		LMSname  = :LMSname, LMEaddress = :LMEaddress, AppEmpNum = :AppEmpNum, eligible = :eligible
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
				$stmt->bindParam(':Team', $linearray[8]);
				$stmt->bindParam(':Section', $linearray[9]);
				$stmt->bindParam(':Department', $linearray[10]);
				$stmt->bindParam(':Directorate', $linearray[11]);
				$stmt->bindParam(':LocationName', $linearray[12]);
				$stmt->bindParam(':LocationAddress', $linearray[13]);
				$stmt->bindParam(':SuperUser', $linearray[14]);
				$stmt->bindParam(':LMEmpNum', $linearray[15]);
				$stmt->bindParam(':LMFname', $linearray[16]);
				$stmt->bindParam(':LMSname', $linearray[17]);
				$stmt->bindParam(':LMEaddress', $linearray[18]);
				$stmt->bindParam(':APPEnum', $linearray[20]);
				$stmt->bindParam(':eligable', $linearray[21]);
				$stmt->execute();
			}
		}
	}
	header("location:staff.php");
?>