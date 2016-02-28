<?php
////////////////////////////////////////////////////////////////////////////////////
function createNominee($empnum){
	global $db;
	$stmt = $db->prepare('SELECT * FROM tblempall WHERE EmpNum = :EmpNum');
	$stmt->execute(array('EmpNum' => $empnum));
	$stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
	if ($result = $stmt->fetch()){
		if ($result->Shop != ''  && $result->JobTitle != 'Shop Mgr'){
			$result->offline = 'YES';
			// find Shop Mgr
			$stmt = $db->prepare('SELECT * FROM tblempall WHERE Shop = :Shop AND JobTitle= :JobTitle');
			$stmt->execute(array('Shop' => $result->Shop, 'JobTitle' => 'Shop Mgr' ));
			if ($mgr = $stmt->fetch(PDO::FETCH_OBJ)){
				$result->shopMEmpNum = $mgr->EmpNum;
				$result->shopMFname = $mgr->Fname;
				$result->shopMSname = $mgr->Sname;
				$result->shopMEaddress = $mgr->Eaddress;
			}
		}
		print_r($result);
		if ($result->AppEmpNum == ''){
			$result = getApprover($result);
		}
		$_SESSION['nominee'] = $result;
	}
}
////////////////////////////////////////////////////////////////////////////////////
function getApprover($approver){
	global $db;
	// Get fullname and email address
	// Trading region = Trading Area Manager
	if (strpos(strtoupper($approver->Team),strtoupper('Trading Region')) !== false){
		// find Area Mgr
		$stmt = $db->prepare('SELECT * FROM tblempall WHERE RetailArea = :RetailArea AND Grade= :Grade');
		$stmt->execute(array('RetailArea' => $approver->RetailArea, 'Grade' => 'Manager 1' ));
		if ($mgr = $stmt->fetch(PDO::FETCH_OBJ)){
			$approver->AppEmpNum = $mgr->EmpNum;
			$approver->AppFname = $mgr->Fname;
			$approver->AppSname = $mgr->Sname;
			$approver->AppEaddress = $mgr->Eaddress;
echo "<br>1 ran here<br>";
		} else {
			$stmt = $db->prepare('SELECT * FROM tblempall WHERE Team = :Team AND Grade= :Grade');
			$stmt->execute(array('Team' => $approver->Team, 'Grade' => 'Manager 2' ));
			if ($mgr = $stmt->fetch(PDO::FETCH_OBJ)){
				$approver->AppEmpNum = $mgr->EmpNum;
				$approver->AppFname = $mgr->Fname;
				$approver->AppSname = $mgr->Sname;
				$approver->AppEaddress = $mgr->Eaddress;
echo "<br>2 ran here<br>";
			}
		}
	} else {
		// volunteer fundraising = senior Manager
		if (strpos(strtoupper($approver->Section),strtoupper('Volunteer Fundraising')) !== false){
			// if manager 3 nominated then use manager 4. No manager 4 So who is approver
			if($approver->Grade == 'Manager 3'){
				$stmt = $db->prepare('SELECT * FROM tblempall WHERE Department = :Department AND Grade= :Grade');
				$stmt->execute(array('Department' => $approver->Department, 'Grade' => 'Manager 4' ));
				if ($mgr = $stmt->fetch(PDO::FETCH_OBJ)){
					$approver->AppEmpNum = $mgr->EmpNum;
					$approver->AppFname = $mgr->Fname;
					$approver->AppSname = $mgr->Sname;
					$approver->AppEaddress = $mgr->Eaddress;
echo "<br>3 ran here<br>";
				} else {
					$stmt = $db->prepare("SELECT * FROM tblempall WHERE SuperUser = 'Y'");
					$stmt->execute();
					if ($mgr = $stmt->fetch(PDO::FETCH_OBJ)){
						$approver->AppEmpNum = $mgr->EmpNum;
						$approver->AppFname = $mgr->Fname;
						$approver->AppSname = $mgr->Sname;
						$approver->AppEaddress = $mgr->Eaddress;
	echo "<br>SU ran here<br>";
					}
				}
			} else {
				// if manager 2 nominated then use manager 3.
				if($approver->Grade == 'Manager 2'){
					$stmt = $db->prepare('SELECT * FROM tblempall WHERE Section = :Section AND Grade= :Grade');
					$stmt->execute(array('Section' => $approver->Section, 'Grade' => 'Manager 3' ));
					if ($mgr = $stmt->fetch(PDO::FETCH_OBJ)){
						$approver->AppEmpNum = $mgr->EmpNum;
						$approver->AppFname = $mgr->Fname;
						$approver->AppSname = $mgr->Sname;
						$approver->AppEaddress = $mgr->Eaddress;
echo "<br>4 ran here<br>";
					} else {
						$stmt = $db->prepare("SELECT * FROM tblempall WHERE SuperUser = 'Y'");
						$stmt->execute();
						if ($mgr = $stmt->fetch(PDO::FETCH_OBJ)){
							$approver->AppEmpNum = $mgr->EmpNum;
							$approver->AppFname = $mgr->Fname;
							$approver->AppSname = $mgr->Sname;
							$approver->AppEaddress = $mgr->Eaddress;
		echo "<br>SU ran here<br>";
						}
					}
				} else {
					$stmt = $db->prepare('SELECT * FROM tblempall WHERE Section = :Section AND Team = :Team AND Grade= :Grade');
					$stmt->execute(array('Section' => $approver->Section,'Team' => $approver->Team,  'Grade' => 'Manager 2' ));
					if ($mgr = $stmt->fetch(PDO::FETCH_OBJ)){
						$approver->AppEmpNum = $mgr->EmpNum;
						$approver->AppFname = $mgr->Fname;
						$approver->AppSname = $mgr->Sname;
						$approver->AppEaddress = $mgr->Eaddress;
echo "<br>5 ran here<br>";
					} else {
						echo '<br>'.$approver->Section.'<br>';
						$stmt = $db->prepare('SELECT * FROM tblempall WHERE Section = :Section AND Grade= :Grade');
						$stmt->execute(array('Section' => $approver->Section, 'Grade' => 'Manager 2' ));
						if ($mgr = $stmt->fetch(PDO::FETCH_OBJ)){
							echo $mgr->EmpNum;
							$approver->AppEmpNum = $mgr->EmpNum;
							$approver->AppFname = $mgr->Fname;
							$approver->AppSname = $mgr->Sname;
							$approver->AppEaddress = $mgr->Eaddress;
echo "<br>6 ran here<br>";
						} else {
							$stmt = $db->prepare('SELECT * FROM tblempall WHERE Section = :Section AND Grade= :Grade');
							$stmt->execute(array('Section' => $approver->Section, 'Grade' => 'Manager 3' ));
							if ($mgr = $stmt->fetch(PDO::FETCH_OBJ)){
								$approver->AppEmpNum = $mgr->EmpNum;
								$approver->AppFname = $mgr->Fname;
								$approver->AppSname = $mgr->Sname;
								$approver->AppEaddress = $mgr->Eaddress;
echo "<br>7 ran here<br>";
							} else {
								$stmt = $db->prepare('SELECT * FROM tblempall WHERE Department = :Department AND Grade= :Grade');
								$stmt->execute(array('Department' => $approver->Department, 'Grade' => 'Manager 4' ));
								if ($mgr = $stmt->fetch(PDO::FETCH_OBJ)){
									$approver->AppEmpNum = $mgr->EmpNum;
									$approver->AppFname = $mgr->Fname;
									$approver->AppSname = $mgr->Sname;
									$approver->AppEaddress = $mgr->Eaddress;
echo "<br>9 ran here<br>";
								} else {
									$stmt = $db->prepare("SELECT * FROM tblempall WHERE SuperUser = 'Y'");
									$stmt->execute();
									if ($mgr = $stmt->fetch(PDO::FETCH_OBJ)){
										$approver->AppEmpNum = $mgr->EmpNum;
										$approver->AppFname = $mgr->Fname;
										$approver->AppSname = $mgr->Sname;
										$approver->AppEaddress = $mgr->Eaddress;
					echo "<br>SU ran here<br>";
									}
								}
							}
						}
					}
				}
			}
		} else {
			echo "<br>run general<br>";
			//everyone else department head
			if($approver->Grade == 'Manager 4'){
				// fix for above manager 4 need to grade above manager 4
				$stmt = $db->prepare('SELECT * FROM tblempall WHERE Directorate = :Directorate AND Grade= :Grade');
				$stmt->execute(array('Department' => $approver->Department, 'Grade' => 'Manager 4' ));
				if ($mgr = $stmt->fetch(PDO::FETCH_OBJ)){
					$approver->AppEmpNum = $mgr->EmpNum;
					$approver->AppFname = $mgr->Fname;
					$approver->AppSname = $mgr->Sname;
					$approver->AppEaddress = $mgr->Eaddress;
echo "<br>10 ran here<br>";
				} else {
					$stmt = $db->prepare("SELECT * FROM tblempall WHERE SuperUser = 'Y'");
					$stmt->execute();
					if ($mgr = $stmt->fetch(PDO::FETCH_OBJ)){
						$approver->AppEmpNum = $mgr->EmpNum;
						$approver->AppFname = $mgr->Fname;
						$approver->AppSname = $mgr->Sname;
						$approver->AppEaddress = $mgr->Eaddress;
	echo "<br>SU ran here<br>";
					}
				}
			} else {
				if($approver->Grade == 'Manager 3'){
					// fix
					$stmt = $db->prepare('SELECT * FROM tblempall WHERE Department = :Department AND Grade= :Grade');
					$stmt->execute(array('Department' => $approver->Department, 'Grade' => 'Manager 4' ));
					if ($mgr = $stmt->fetch(PDO::FETCH_OBJ)){
						$approver->AppEmpNum = $mgr->EmpNum;
						$approver->AppFname = $mgr->Fname;
						$approver->AppSname = $mgr->Sname;
						$approver->AppEaddress = $mgr->Eaddress;
echo "<br>11 ran here<br>";
					} else {
						$stmt = $db->prepare("SELECT * FROM tblempall WHERE SuperUser = 'Y'");
						$stmt->execute();
						if ($mgr = $stmt->fetch(PDO::FETCH_OBJ)){
							$approver->AppEmpNum = $mgr->EmpNum;
							$approver->AppFname = $mgr->Fname;
							$approver->AppSname = $mgr->Sname;
							$approver->AppEaddress = $mgr->Eaddress;
		echo "<br>SU ran here<br>";
						}
					}
				} else {
					$stmt = $db->prepare('SELECT * FROM tblempall WHERE Section = :Section AND Grade= :Grade');
					$stmt->execute(array('Section' => $approver->Section, 'Grade' => 'Manager 3' ));
					if ($mgr = $stmt->fetch(PDO::FETCH_OBJ)){
						$approver->AppEmpNum = $mgr->EmpNum;
						$approver->AppFname = $mgr->Fname;
						$approver->AppSname = $mgr->Sname;
						$approver->AppEaddress = $mgr->Eaddress;
echo "<br>12 ran here<br>";
					} else {
						$stmt = $db->prepare('SELECT * FROM tblempall WHERE Department = :Department AND Grade= :Grade');
						$stmt->execute(array('Department' => $approver->Department, 'Grade' => 'Manager 3' ));
						if ($mgr = $stmt->fetch(PDO::FETCH_OBJ)){
							$approver->AppEmpNum = $mgr->EmpNum;
							$approver->AppFname = $mgr->Fname;
							$approver->AppSname = $mgr->Sname;
							$approver->AppEaddress = $mgr->Eaddress;
echo "<br>13 ran here<br>";
						} else {
							$stmt = $db->prepare('SELECT * FROM tblempall WHERE Department = :Department AND Grade= :Grade');
							$stmt->execute(array('Department' => $approver->Department, 'Grade' => 'Manager 4' ));
							if ($mgr = $stmt->fetch(PDO::FETCH_OBJ)){
								$approver->AppEmpNum = $mgr->EmpNum;
								$approver->AppFname = $mgr->Fname;
								$approver->AppSname = $mgr->Sname;
								$approver->AppEaddress = $mgr->Eaddress;
echo "<br>14 ran here<br>";
							} else {
								$stmt = $db->prepare('SELECT * FROM tblempall WHERE Directorate = :Directorate AND Grade= :Grade');
								$stmt->execute(array('Directorate' => $approver->Directorate, 'Grade' => 'Manager 3' ));
								if ($mgr = $stmt->fetch(PDO::FETCH_OBJ)){
									$approver->AppEmpNum = $mgr->EmpNum;
									$approver->AppFname = $mgr->Fname;
									$approver->AppSname = $mgr->Sname;
									$approver->AppEaddress = $mgr->Eaddress;
echo "<br>15 ran here<br>";
								} else {
									$stmt = $db->prepare("SELECT * FROM tblempall WHERE SuperUser = 'Y'");
									$stmt->execute();
									if ($mgr = $stmt->fetch(PDO::FETCH_OBJ)){
										$approver->AppEmpNum = $mgr->EmpNum;
										$approver->AppFname = $mgr->Fname;
										$approver->AppSname = $mgr->Sname;
										$approver->AppEaddress = $mgr->Eaddress;
					echo "<br>SU ran here<br>";
									}
								}
							}
						}
					}
				}
			}
		}
	}
	return $approver;
}
////////////////////////////////////////////////////////////////////////////////////
function getTotalNominations($empnum){
	global $db;
	// need to fix to add team
	$stmt = $db->prepare("SELECT * FROM tblnominations WHERE awardType='1' And NominatorEmpNum = :EmpNum");
	$stmt->execute(array('EmpNum' => $empnum));
	if ($result = $stmt->fetch()){
		return $stmt->rowCount();
	} else{
		return 0;
	}
}
////////////////////////////////////////////////////////////////////////////////////
function getTotalNewNominations($empnum){
	global $db;
	$stmt = $db->prepare("SELECT * FROM tblnominations WHERE NominatedEmpNum = :EmpNum AND littleExtra='Yes' AND AprStatus=1 AND AwardClaimed = 'No'");
	$stmt->execute(array('EmpNum' => $empnum));
	if ($result = $stmt->fetch()){
		return $stmt->rowCount();
	} else{
		return 0;
	}
}
////////////////////////////////////////////////////////////////////////////////////
function getTotalPendingNominations($empnum){
	global $db;
	$count =0;
	
	$stmt = $db->prepare('SELECT * FROM tblnominations WHERE ApproverEmpNum = :EmpNum AND AprStatus=0');

	$stmt->execute(array('EmpNum' => $empnum));
	if ($result = $stmt->fetch()){
		$count += $stmt->rowCount();
	}

	$stmt = $db->prepare('SELECT * FROM tblnominations_team WHERE ApproverEmpNum = :EmpNum AND AprStatus=0');
	
	$stmt->execute(array('EmpNum' => $empnum));
	if ($result = $stmt->fetch()){
		$count += $stmt->rowCount();
	}
	
	return $count;
}
////////////////////////////////////////////////////////////////////////////////////
function getTotalApprovedNominations($empnum){
	global $db;
	$stmt = $db->prepare('SELECT * FROM tblnominations WHERE NominatorEmpNum = :EmpNum AND AprStatus=1');
	$stmt->execute(array('EmpNum' => $empnum));
	if ($result = $stmt->fetch()){
		return $stmt->rowCount();
	} else{
		return 0;
	}
}
////////////////////////////////////////////////////////////////////////////////////
function getMostRecentAwards () {
	global $db;
	$Department = $_SESSION['user']->Department;
	$sql = 'SELECT X.* FROM (
				(SELECT  "individual"			AS Type,
						n.ID					AS ID,
						e.Fname					AS name,
						e.Sname					AS sname,
						e.DirectorateInitials	AS DirectorateInitials,
						n.BeliefID				AS BeliefID,
						""						AS TeamID,
						n.AprDate				AS AprDate
			FROM tblnominations AS n
			INNER JOIN tblempall AS e
			ON n.NominatedEmpNum = e.EmpNum
			WHERE n.awardType=1 AND n.AprStatus=1 AND e.Department = :Department)
				) X
			ORDER BY AprDate DESC LIMIT 20';
	$stmt = $db->prepare($sql);
	$stmt->execute(array('Department' => $Department));
	$arr = array();
	while($result = $stmt->fetch( PDO::FETCH_ASSOC )) {
		$arr[] = $result;
	}
	if(count($arr) == 0){
		return 0;
	}
	return $arr;
}
/* removed from above as we dont know which department
UNION
				(SELECT  "Team"					AS Type,
						ID						AS ID,
						Team					AS name,
						""						AS sname,
						""						AS DirectorateInitials,
						BeliefID				AS BeliefID,
						TeamID					AS TeamID,
						AprDate					AS AprDate
				FROM tblnominations_team
				WHERE awardType=2 AND AprStatus=1)*/
////////////////////////////////////////////////////////////////////////////////////
function fixMenuSpace($i){
	switch ($i) {
		case 1:
			return '<div class="tableReportsHead tableColumn-6 noRightBorder"></div>';
		case 2:
			return '<div class="tableReportsHead tableColumn-4 noRightBorder"></div>';
		case 3:
			return '<div class="tableReportsHead tableColumn-2 noRightBorder"></div>';
	}
}
////////////////////////////////////////////////////////////////////////////////////
////////////    TEAM FUNCTIONS    ////////////////////////////////////////////////////
function getmyTeams($empnum){
	global $db;
	$stmt = $db->prepare('SELECT * FROM tblteams WHERE EmpNum = :EmpNum ');
	$stmt->execute(array('EmpNum' => $empnum));
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_OBJ);
}
////////////////////////////////////////////////////////////////////////////////////
function getmyTeamName($id){
	if (is_numeric($id)) {
		global $db;
		$stmt = $db->prepare('SELECT myTeamName FROM tblteams WHERE id = :id ');
		$stmt->execute(array('id' => $id));
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_OBJ);
		return $result->myTeamName;
	} else {
		if($id == 'myteam'){
			return 'My Team';
		} else {
			return $id ;
		}
	}
}
////////////////////////////////////////////////////////////////////////////////////
function getAllTeamsMembers($teamID) {
	global $db;
	if($teamID != 'myteam'){
		$stmt = $db->prepare("SELECT * FROM tblteamusers tu INNER JOIN tblempall e ON tu.EmpNum=e.EmpNum WHERE tu.teamID = :teamID ORDER BY e.Sname");
		$stmt->execute(array('teamID' => $teamID));
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $result;
	} else {
		$stmt = $db->prepare("SELECT * FROM tblempall WHERE Shop<>'' AND Shop = :Shop AND EmpNum <> :EmpNum ORDER BY Sname");
		$stmt->execute(array('Shop' => $_SESSION['user']->Shop, 'EmpNum' => $_SESSION['user']->EmpNum));
		if ($result = $stmt->fetchAll(PDO::FETCH_OBJ)){
			return $result;
		} else {
			$stmt = $db->prepare("SELECT * FROM tblempall WHERE RetailArea<>'' AND RetailArea = :RetailArea AND EmpNum <> :EmpNum ORDER BY Sname");
			$stmt->execute(array('RetailArea' => $_SESSION['user']->RetailArea, 'EmpNum' => $_SESSION['user']->EmpNum));
			if ($result = $stmt->fetchAll(PDO::FETCH_OBJ)){
				return $result;
			} else {
				$stmt = $db->prepare("SELECT * FROM tblempall WHERE Team<>'' AND Team = :Team AND EmpNum <> :EmpNum ORDER BY Sname");
				$stmt->execute(array('Team' => $_SESSION['user']->Team, 'EmpNum' => $_SESSION['user']->EmpNum));
				if ($result = $stmt->fetchAll(PDO::FETCH_OBJ)){
					return $result;
				} else {
					$stmt = $db->prepare("SELECT * FROM tblempall WHERE Section<>'' AND Section = :Section AND EmpNum <> :EmpNum ORDER BY Sname");
					$stmt->execute(array('Section' => $_SESSION['user']->Section, 'EmpNum' => $_SESSION['user']->EmpNum));
					if ($result = $stmt->fetchAll(PDO::FETCH_OBJ)){
						return $result;
					} else {
						$stmt = $db->prepare("SELECT * FROM tblempall WHERE Department = :Department AND EmpNum <> :EmpNum ORDER BY Sname");
						$stmt->execute(array('Department' => $_SESSION['user']->Department, 'EmpNum' => $_SESSION['user']->EmpNum));
						if ($result = $stmt->fetchAll(PDO::FETCH_OBJ)){
							return $result;
						} 
					}
				}
			}
		}
	}
}
////////////////////////////////////////////////////////////////////////////////////
function addTeamMember($empnum) {
	if(isset($_SESSION['TeamMembers'])){
	} else {
		$_SESSION['TeamMembers'] =  array();
	}
	$name = getName($empnum);
	if (in_array_r($empnum, $_SESSION['TeamMembers'])) {
	} else {
		$_SESSION['TeamMembers'][] = (object)array('EmpNum' => $empnum, 'full_name' => $name);
	}
	return $_SESSION['TeamMembers'];
}
////////////////////////////////////////////////////////////////////////////////////
function addSelectedTeamMembers($Team) {
	global $db;
	$stmt = $db->prepare("SELECT * FROM tblempall WHERE Team = :Team AND EmpNum <> :EmpNum ORDER BY Sname");
	$stmt->execute(array('Team' => $Team, 'EmpNum' => $_SESSION['user']->EmpNum));
	if ($result = $stmt->fetchAll(PDO::FETCH_OBJ)){
		return $result;
	} 
}
////////////////////////////////////////////////////////////////////////////////////
function getThisTeamMembers($teamID) {
	global $db;
	$stmt = $db->prepare("SELECT * FROM tblnominations_teamusers tu INNER JOIN tblempall e ON tu.EmpNum=e.EmpNum WHERE tu.nomination_teamID = :teamID ORDER BY e.Sname");
	$stmt->execute(array('teamID' => $teamID));
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $result;
}
////////////////////////////////////////////////////////////////////////////////////
function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }
    return false;
}
////////////////////////////////////////////////////////////////////////////////////
function removeTeamMember($empnum) {
     foreach($_SESSION['TeamMembers'] as $subKey => $subArray){
          if($subArray->EmpNum == $empnum){
               unset($_SESSION['TeamMembers'][$subKey]);
          }
     }
     return $_SESSION['TeamMembers'];
}
////////////////////////////////////////////////////////////////////////////////////
function shortenName($name){
	return (strlen($name) > 13) ? substr($name,0,10).'...' : $name;
}
////////////////////////////////////////////////////////////////////////////////////
function getTeamsApprover($EmpNum) {
	global $db;
	$stmt = $db->prepare("SELECT AppEmpNum, AppFname, AppSname, AppEaddress FROM tblempall WHERE EmpNum = :EmpNum");
	$stmt->execute(array('EmpNum' => $EmpNum));
	$result = $stmt->fetch(PDO::FETCH_OBJ);
	return $result;
}
////////////////////////////////////////////////////////////////////////////////////
function cleanWorkAward($workAward){
	if( $workAward == 'TeamEvent'){
		return 'Team event';
	} else {
		return '&pound;20 Voucher per person';
	}
}
////////////////////////////////////////////////////////////////////////////////////
function getSUemail(){
	global $db;
	$stmt = $db->prepare("SELECT Eaddress FROM tblempall WHERE SuperUser = 'Y'");
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_OBJ);
	return $result->Eaddress;
}
////////////////////////////////////////////////////////////////////////////////////
function getSUApprover(){
	global $db;
	$stmt = $db->prepare("SELECT * FROM tblempall WHERE EmpNum = 'hradmin'");
	$stmt->execute();
	if ($mgr = $stmt->fetch(PDO::FETCH_OBJ)){
		$suapprover->AppEmpNum = $mgr->EmpNum;
		$suapprover->AppFname = $mgr->Fname;
		$suapprover->AppSname = $mgr->Sname;
		$suapprover->AppEaddress = $mgr->Eaddress;
		$stmt = $db->prepare("SELECT Eaddress FROM tblempall WHERE SuperUser = 'Y'");
		$stmt->execute();
		if ($searchList = $stmt->fetchAll(PDO::FETCH_OBJ)){
			foreach ($searchList as $list){
				$teamEmailList .= $list->Eaddress.", ";
			}
		}
		$teamEmailList = chop($teamEmailList,", ");
		$suapprover->SUEaddress = $teamEmailList;
	}
	return $suapprover;
}
////////////////////////////////////////////////////////////////////////////////////
?>