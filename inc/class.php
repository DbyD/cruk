<?php
class User {
	public $Fname;
	public $Sname;
	public $LMFname;
	public $LMSname;
	public $AppFname;
	public $AppSname;
	public function full_name(){
		return $this->Fname . ' ' . $this->Sname;
	}
	public function full_LM_name(){
		return $this->LMFname . ' ' . $this->LMSname;
	}
	public function full_App_name(){
		// this is not always correct
		return $this->AppFname . ' ' . $this->AppSname;
	}
	public function approver(){
		global $db;
		$stmt = $db->prepare('SELECT 1 FROM tblempall WHERE AppEmpNum = :AppEmpNum');
		$stmt->execute(array('AppEmpNum' => $this->EmpNum));
		if ($stmt->fetch()){
			return "YES";
		} else {
			return "NO";
		}
	}
}
class NominationsList{
    public function getAllNominationsList($empnum) {
		global $db;
		$stmt = $db->prepare('SELECT * FROM tblnominations WHERE NominatorEmpNum = :empnum ORDER BY NomDate DESC');
		$stmt->execute(array('empnum' => $empnum));
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $result;
    }
}

class MyNominationsList{
    public function getAllMyNominationsList($empnum) {
		global $db;
		$stmt = $db->prepare('SELECT * FROM tblnominations WHERE NominatedEmpNum = :empnum AND AprStatus=1 ORDER BY NomDate DESC');
		$stmt->execute(array('empnum' => $empnum));
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $result;
    }
}
class searchAllUsers{
    public function getAllUserSearch($search) {
		global $db;
		$stmt = $db->prepare("SELECT * FROM tblempall WHERE (Fname LIKE '%$search%' OR Sname LIKE '%$search%') AND EmpNum <> :empnum");
		$stmt->execute(array('empnum' => $_SESSION['user']->EmpNum));
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $result;
    }
}

class searchUsers{
    public function getAllSearch($search) {
		global $db;
		$stmt = $db->prepare("SELECT * FROM tblempall WHERE (Fname LIKE '%$search%' OR Sname LIKE '%$search%'
									OR CONCAT(Fname,' ',Sname) like '%".str_replace(" ","%",$search)."%')
									AND EmpNum <> :empnum");
		$stmt->execute(array('empnum' => $_SESSION['user']->EmpNum));
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $result;
    }
}

class AdminUsers{
    public function getAlladmin() {
		global $db;
		$stmt = $db->prepare('SELECT * FROM tbladmin');
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $result;
    }
}

class AllUsers{
    public function getAllUsers() {
		global $db;
		$stmt = $db->prepare('SELECT * FROM tblempall');
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $result;
    }
}

class Encryption {
	var $skey 	= "SuPerEncKey2010"; // you can change it
    public  function safe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }
	public function safe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
    public  function encode($value){ 
	    if(!$value){return false;}
        $text = $value;
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->skey, $text, MCRYPT_MODE_ECB, $iv);
        return trim($this->safe_b64encode($crypttext)); 
    }
    public function decode($value){
        if(!$value){return false;}
        $crypttext = $this->safe_b64decode($value); 
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->skey, $crypttext, MCRYPT_MODE_ECB, $iv);
        return trim($decrypttext);
    }
}
?>