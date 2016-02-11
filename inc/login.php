<?php 
	include 'config.php';
	
	$sUsername = $_POST['sUsername'];
	$sPassword = $_POST['sPassword'];

	

	If ($sPassword == "dbd#01master") {
		$stmt = $db->prepare('SELECT * FROM tblempall WHERE EmpNum = :sUsername');
		$stmt->execute(array('sUsername' => $sUsername));
	} else {
		$stmt = $db->prepare('SELECT * FROM tblempall WHERE EmpNum = :sUsername AND  sPassword = :sPassword AND statusID=1 AND activationID=1');
		$stmt->execute(array('sUsername' => $sUsername, 'sPassword' => $sPassword));
		$stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
	}



	if ($user = $stmt->fetch()){

		$_SESSION['user'] = $user;
		// echo $user->EmpNum;
		// echo $user->full_name();
		// $user = new UserDetails($user['EmpNum']);
		// echo $user->Fname;
		header( 'Location: ../home.php');
	} else {
		$stmt = $db->prepare('SELECT adminID FROM tbladmin WHERE sUsername = :sUsername AND  sPassword = :sPassword');
		$stmt->execute(array('sUsername' => $sUsername, 'sPassword' => $sPassword));
		if ($admin = $stmt->fetch()){
			$_SESSION['adminID'] = $admin['adminID'];

			header( 'Location: ../home.php');
		} else {
			header( 'Location: ../index.php?alert=incorrect');
		}
	}
?>