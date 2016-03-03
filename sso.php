<?php

include 'inc/config.php';

$secret = '6wpq3rQ92VdA06NO';

if(isset($_GET['id']) && isset($_GET['date']) && isset($_GET['sig']))
{
	$email = $_GET['id'];
	$date = $_GET['date'];
	$sig = $_GET['sig'];

	//check if the signature contains the secret and the correct encoding
	if($sig == md5($date.'|'.$email.'|'.$secret))
	{
		//log the user in
		$stmt = $db->prepare('SELECT * FROM tblempall WHERE (EmpNum = :sUsername OR  Eaddress = :sUsername)');
		$stmt->execute(array('sUsername' => $email));
		$stmt->setFetchMode(PDO::FETCH_CLASS, 'User');

		if ($user = $stmt->fetch())
		{	
			//if the user is not activated, let's activate him
			if($user->activated == 0)
			{
				$rs = $db->prepare("UPDATE tblempall SET activated = '1' WHERE EmpNum LIKE :EmpNum");
				$rs->execute(array(":EmpNum" => $user->EmpNum));
			}

			$_SESSION['user'] = $user;
			header( 'Location: ../home.php');
		}
		else
		{
			echo "The user does not exist or isn't eligible!!!";
		}
		
	}
}