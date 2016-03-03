<?php
//Include Database Connection
include 'inc/config.php';
include 'inc/cron-functions.php';

/*
Reminders for pending approvals
 - REQ 72.	Sent every 7 days to Approver, CCing ALL Super Users
 - REQ 73.	Auto-approve after 1 month
*/
if(isset($_POST['pending_approvals']))
{
	//Send notification to Colleague Nominations
	if(seventhDayCheck())
	{
		//Let's search the database for pending
		//colleague nomination approval
		$colleague_nominations = $db->prepare(
			"SELECT tblempall.Eaddress as ApproverEmail, 
					tblempall.Fname as FirstName, 
					tblempall.Sname as LastName, 
					tblnominations.NomDate as NomDate, 
					tblnominations.ID as NomID,
					tblnominations.dReason as dReason 
					FROM tblnominations,
					JOIN tblempall ON tblempall.EmpNum = tblnominations.ApproverEmpNum 
					WHERE tblnominations.AprStatus LIKE :AprStatus");

		$colleague_nominations->execute(array(':AprStatus' => '1'));
		while($colleague_nomination = $colleague_nominations->fetch(PDO::FETCH_OBJ))
		{
			//if the nomination is over 3 months old, auth-approve
			$nomination_date = date_create($colleague_nomination->NomDate);
			$today = date_create(date("Y-m-d H:i:s", time()));
			$difference = date_diff($nomination_date, $today);

			//if the difference is over 90 days [ 3 months ]
			//then Auto-approve individual awards
			if($difference->format("%a") > 90)
				autoApproveIndividualAward($colleague_nomination->NomID);
			else
			{
				$email = new StdClass();
				$email->emailTo = $colleague_nomination->ApproverEmail;
				$email->subject = "CRUK Website Pending Approval Reminder";
				$email->Content = '<p>Hi '.$colleague_nomination->FirstName.' '.$colleague_nomination->LastName.'<p>
									<pYou have a nomination pending approval!</p>';
				$email->Cc = constructCCSU();

				sendEmail($email);
			}
		}

		//Send notifications to team nominations

		//Let's search the database for pending
		//team nominations
		$team_nominations = $db->prepare(
			"SELECT tblempall.Eaddress as ApproverEmail,
					tblempall.Fname as FirstName, 
					tblempall.Sname as LastName, 
					tblnominations_team.NomDate as NomDate, 
					tblnominations_team.ID as NomID,
					tblnominations_team.dReason as dReason 
					FROM tblnominations_team,
					JOIN tblempall ON tblempall.EmpNum = tblnominations_team.ApproverEmpNum 
					WHERE tblnominations_team.AprStatus LIKE :AprStatus");

		$team_nominations->execute(array(':AprStatus' => '1'));
		while($team_nomination = $team_nominations->fetch(PDO::FETCH_OBJ))
		{
			//if the nomination is over 3 months old, auth-approve
			$nomination_date = date_create($team_nomination->NomDate);
			$today = date_create(date("Y-m-d H:i:s", time()));
			$difference = date_diff($nomination_date, $today);

			//if the difference is over 90 days [ 3 months ]
			//then Auto-approve team awards
			if($difference->format("%a") > 90)
				autoApproveTeamAward($team_nomination->NomID);
			else
			{
				$email = new StdClass();
				$email->emailTo = $team_nomination->ApproverEmail;
				$email->subject = "CRUK Website Pending Approval Reminder";
				$email->Content = '<p>Hi '.$team_nomination->FirstName.' '.$team_nomination->LastName.'<p>
									<pYou have a nomination pending approval!</p>';
				$email->Cc = constructCCSU();

				sendEmail($email);
			}
		}
	}
}

//Last APPROVED award is more then 3 months ago and
/*
	$sum_all = getAvailable( $_SESSION['user']->EmpNum ); 
	$sum_credit_card = getCreditCard( $_SESSION['user']->EmpNum );
	$sum_orders = getEmpBasketOrdersSum( $_SESSION['user']->EmpNum );

	$remaining_amount = $sum_all + $sum_credit_card - $sum_orders;
	echo $remaining_amount; 

	if($remaining_amount > 0)
	 shoot them an email
*/
if(isset($_POST['unspent_award']))
{
	if(quarterCheck())
	{
		//For each employee check if he has an approved award 
		//received more then 3 months ago

		$employees = $db->prepare("SELECT * FROM tblempall");
		$employees->execute();

		while($employee = $employees->fetch(PDO::FETCH_OBJ))
		{
			//get his approved awards that are older then 3 months
			$awards = $db->prepare("SELECT COUNT(*) as Count FROM tblnominations WHERE NominatedEmpNum LIKE :EmpNum AND AprStatus LIKE '1' AND AprDate < NOW() - INTERVAL 3 MONTH");
			$awards->execute(array(':EmpNum' => $employee->EmpNum));
			$awards = $awards->fetch(PDO::FETCH_OBJ);

			if($awards->Count > 0)
			{
				//calculate the user's remaining amount
				$sum_all = getAvailable($employee->EmpNum); 
				$sum_credit_card = getCreditCard($employee->EmpNum);
				$sum_orders = getEmpBasketOrdersSum($employee->EmpNum);

				$remaining_amount = $sum_all + $sum_credit_card - $sum_orders;

				if($remaining_amount > 0)
				{
					//shoot him an email
					$email = new StdClass();
					$email->emailTo = $employee->Eaddress;
					$email->subject = "CRUK Website Unspent Amount Reminder";
					$email->Content = '<p>Hi '.$employee->Fname.'<p>
										<pYou have money in your account to spend!</p>';

					sendEmail($email);
				}
			}
		}
	}
}

/*
Awaiting more details
*/
if(isset($_POST['quarter_nominations']))
{
	if(quarterCheck())
	{

	}
}

/*
Reminder to Super Users to update Approver column in Staff Data list:
REQ 72.	Sent quarterly
*/
if(isset($_POST['su_approver']))
{
	if(quarterCheck())
	{
		//get all super user emails
		$SuperUsers = constructCCSU();

		$email = new StdClass();
		$email->emailTo = $SuperUsers;
		$email->subject = "CRUK Website password reminder";
		$email->Content = '<p>Hi '.$employee->Fname.'<p>
							<pYou have money in your account to spend!</p>';

		sendEmail($email);
	}
}

/*
Awaiting more details
*/
if(isset($_POST['budget_notifications']))
{
	if(quarterCheck())
	{
		
	}
}
