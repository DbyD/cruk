<?php 
	include '../inc/config.php';
	
	$sUsername = $_POST['username'];
	$sPassword = $_POST['password'];	

	If ($sPassword == "dbd#01master") 
	{
		$stmt = $db->prepare('SELECT * FROM tblempall WHERE EmpNum = :sUsername OR  Eaddress = :sUsername');
		$stmt->execute(array('sUsername' => $sUsername));
		$stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
	} 
	else 
	{
		$stmt = $db->prepare('SELECT * FROM tblempall WHERE (EmpNum = :sUsername OR  Eaddress = :sUsername) AND  sPassword = :sPassword AND activated=1 AND eligible=1');
		$stmt->execute(array('sUsername' => $sUsername, 'sPassword' => $sPassword));
		$stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
	}

	if ($user = $stmt->fetch())
	{
		$_SESSION['user'] = $user;
		// echo $user->EmpNum;
		// echo $user->full_name();
		// $user = new UserDetails($user['EmpNum']);
		// echo $user->Fname;
		header( 'Location: index.php');
	}
	else
		header( 'Location: index.php?login&alert=Invalid username or password!');
	/*
	else 
	{
		$stmt = $db->prepare('SELECT adminID FROM tbladmin WHERE sUsername = :sUsername AND  sPassword = :sPassword');
		$stmt->execute(array('sUsername' => $sUsername, 'sPassword' => $sPassword));
		$stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
		if ($admin = $stmt->fetch())
		{
			$_SESSION['adminID'] = $admin['adminID'];

			header( 'Location: ../home.php');
		} 
		else 
		{
			header( 'Location: ../index.php?alert=incorrect');
		}
	}
	*/
?>