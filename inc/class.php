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

class Award {
	public $NominatorEmpNum;
	public $NominatedEmpNum;
	public $ApproverEmpNum;
	public function nominator(){
		global $db;
		$stmt = $db->prepare('SELECT Fname, Sname, Eaddress FROM tblempall WHERE EmpNum = :NominatorEmpNum');
		$stmt->execute(array('NominatorEmpNum' => $this->NominatorEmpNum));
		$result = $stmt->fetch(PDO::FETCH_OBJ);
		$result->full_name = $result->Fname. ' ' . $result->Sname;
		return $result;
	}
	public function nominee(){
		global $db;
		$stmt = $db->prepare('SELECT Fname, Sname, Eaddress, Shop, JobTitle, LMEmpNum FROM tblempall WHERE EmpNum = :NominatedEmpNum');
		$stmt->execute(array('NominatedEmpNum' => $this->NominatedEmpNum));
		$result = $stmt->fetch(PDO::FETCH_OBJ);
		$result->full_name = $result->Fname. ' ' . $result->Sname;
		if ($result->Shop != '' && $result->JobTitle != 'Shop Mgr'){
			$result->offline = 'YES';
		}
		return $result;
	}
	public function approver(){
		global $db;
		$stmt = $db->prepare('SELECT Fname, Sname, Eaddress FROM tblempall WHERE EmpNum = :ApproverEmpNum');
		$stmt->execute(array('ApproverEmpNum' => $this->ApproverEmpNum));
		$result = $stmt->fetch(PDO::FETCH_OBJ);
		$result->full_name = $result->Fname. ' ' . $result->Sname;
		return $result;
	}
	public function lineManager(){
		global $db;
		$stmt = $db->prepare('SELECT Fname, Sname, Eaddress FROM tblempall WHERE EmpNum = :LMEmpNum');
		$stmt->execute(array('LMEmpNum' => $this->nominee()->LMEmpNum));
		$result = $stmt->fetch(PDO::FETCH_OBJ);
		$result->full_name = $result->Fname. ' ' . $result->Sname;
		return $result;
	}
}
class teamAward {
	public $NominatorEmpNum;
	public $ID;
	public $ApproverEmpNum;
	public function nominator(){
		global $db;
		$stmt = $db->prepare('SELECT Fname, Sname, Eaddress FROM tblempall WHERE EmpNum = :NominatorEmpNum');
		$stmt->execute(array('NominatorEmpNum' => $this->NominatorEmpNum));
		$result = $stmt->fetch(PDO::FETCH_OBJ);
		$result->full_name = $result->Fname. ' ' . $result->Sname;
		return $result;
	}
	public function teamNominees(){
		global $db;
		$stmt = $db->prepare('SELECT e.EmpNum, e.Fname, e.Sname, e.Eaddress, e.Shop, e.JobTitle, e.LMEmpNum, e.LMFname, e.LMSname, e.LMEaddress 
								FROM tblempall e INNER JOIN tblnominations_teamusers nt
								ON nt.EmpNum = e.EmpNum
								WHERE nt.nomination_teamID = :ID');
		$stmt->execute(array('ID' => $this->ID));
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $result;
	}
	public function approver(){
		global $db;
		$stmt = $db->prepare('SELECT Fname, Sname, Eaddress FROM tblempall WHERE EmpNum = :ApproverEmpNum');
		$stmt->execute(array('ApproverEmpNum' => $this->ApproverEmpNum));
		$result = $stmt->fetch(PDO::FETCH_OBJ);
		$result->full_name = $result->Fname. ' ' . $result->Sname;
		return $result;
	}
}


class allApprovalsList{
    public function getAllApprovalsList() {
		global $db;
		$stmt = $db->prepare("SELECT * FROM tblnominations WHERE AprStatus=0 AND littleExtra='Yes' ORDER BY NomDate DESC");
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $result;
    }
}

class MyApprovalsHistory{
    public function getAllMyApprovalsHistory($empnum) {
		global $db;
		$stmt = $db->prepare("SELECT * FROM tblnominations WHERE ApproverEmpNum = :empnum AND AprStatus<>0 AND littleExtra='Yes' ORDER BY NomDate DESC");
		$stmt->execute(array('empnum' => $empnum));
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $result;
    }
}

class claimedAwardsList{
    public function getAllclaimedAwardsList($empnum) {
		global $db;
		$stmt = $db->prepare("SELECT * FROM tblnominations WHERE NominatedEmpNum = :empnum AND AprStatus=1 AND AwardClaimed='Yes' ORDER BY amount ASC, NomDate DESC");
		$stmt->execute(array('empnum' => $empnum));
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $result;
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
		$stmt = $db->prepare('SELECT * FROM tblnominations WHERE NominatedEmpNum = :empnum AND AprStatus=1 ORDER BY AprDate DESC');
		$stmt->execute(array('empnum' => $empnum));
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $result;
    }
}

class searchUsers{
    public function getAllUserSearch($search) {
		global $db;
		$stmt = $db->prepare("SELECT * FROM tblempall WHERE (Fname LIKE '%$search%' OR Sname LIKE '%$search%') AND EmpNum <> :empnum LIMIT 20");
		$stmt->execute(array('empnum' => $_SESSION['user']->EmpNum));
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $result;
    }
    public function getAllAdminSearch($search) {
		global $db;
		$stmt = $db->prepare("SELECT * FROM tblempall WHERE (Fname LIKE '%$search%' OR Sname LIKE '%$search%') LIMIT 20");
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $result;
    }
    public function getAllTeamSearch($search) {
		global $db;
		$stmt = $db->prepare("SELECT * FROM tblempall WHERE Team LIKE '%$search%' GROUP BY Team LIMIT 20 ");
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $result;
    }
    public function getAllSearch($search) {
		global $db;
		$stmt = $db->prepare("SELECT * FROM tblempall WHERE (Fname LIKE '%$search%' OR Sname LIKE '%$search%'
									OR CONCAT(Fname,' ',Sname) like '%".str_replace(" ","%",$search)."%')
									AND EmpNum <> :empnum");
		$stmt->execute(array('empnum' => $_SESSION['user']->EmpNum));
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $result;
    }
    public function getAdminAllSearch($search) {
		global $db;
		$stmt = $db->prepare("SELECT * FROM tblempall WHERE (Fname LIKE '%$search%' OR Sname LIKE '%$search%'
									OR CONCAT(Fname,' ',Sname) like '%".str_replace(" ","%",$search)."%')");
		$stmt->execute();
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