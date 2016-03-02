<!doctype html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Our Heroes</title>
<link rel="stylesheet" href="../css/hub2/bootstrap/bootstrap.css" />
<link rel="stylesheet" href="../css/hub2/style.css">
<link rel="stylesheet" href="../css/icomoon.css">
<link rel="shortcut icon" href="../favicon.ico"> 
</head>
<body>
<?php 
include '../inc/config.php';
?>
<div id="wrap" class="container">

	<!-- First Row -->
	<div class="row fixedWidth">
		<div class="col-md-6">
			<div id="benefits" class="clickable" href="https://crukip.cancerresearchuk.org/portal/server.pt/community/Benefits%20including%20Rewards%20Gateway/2045">
				<p>Benefits at <br> CRUK  <br> Overview</p>
				<div class="image"></div>
			</div>

			<div class="boxed clickable" href="https://crukip.cancerresearchuk.org/portal/server.pt/community/People/592" style="margin-top: 20px;" id="pensions">
				<p>Pensions and Retirement</p>
					<div class="image">
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="callout panel clickable" href="../winners-wall/index.php" id="winners">
				<div class="header">
					The Our Heroes recognition portal<div class="image"></div>
				</div>
				<div class="body">
					<p> Recent Winners </p>
					<div class="star">20</div>
					<?php
						//get last 2 nominees
						$nominees = $db->prepare('SELECT * FROM tblnominations as n JOIN tblempall as e ON n.NominatedEmpNum = e.EmpNum ORDER BY n.AprDate DESC LIMIT 2');
						$nominees->execute();

						$index = 0;
						while($nominee = $nominees->fetch(PDO::FETCH_OBJ))
						{	
							//get the nominator by his NominatorEmpNum
							$nominator = $db->prepare('SELECT * FROM tblempall WHERE EmpNum LIKE :EmpNum');
							$nominator->execute(array(':EmpNum' => $nominee->NominatorEmpNum));

							$nominator = $nominator->fetch(PDO::FETCH_OBJ);

							if($nominee->Photo != '')
									$photo = $nominee->Photo;
								else
									$photo = "images/no_photo.png";

							$nominatorName = $nominator->Fname.' '.$nominator->Sname;
							$nomineeName = $nominee->Fname.' '.$nominee->Sname;
							
							/*if (strlen($nominatorName) > 11)
  								 $nominatorName = substr($nominatorName, 0, 11) . '.';

  							if (strlen($nomineeName) > 11)
  								 $nomineeName = substr($nomineeName, 0, 11) . '.';*/
								 
								 $class = str_replace(' ','',$nominee->BeliefID);

							if($index == 0)
							{
	

								echo '
								<div class="person1 '.$class.'">
									<div class="person1_header">
										<div class="image"><i class="icon-icons_mail"></i></div>
										<div class="image1" style="background: url(../'.$photo.') no-repeat; background-size: 100px 100px;"></div>
										<div class="name1">'.$nomineeName.'</div>
										<div class="subname1">'.$nominee->DirectorateInitials.'</div>
									</div>
									<div class="person1_footer">
										Our Beliefs: <b>'.$nominee->BeliefID.'</b>
	
										<br><br>
	
										Nominated by:
										<br>
										<b>'.$nominatorName.'</b>
									</div>
								</div>
								';

								$index++;
							}
							else
							{
	

								echo '
								<div class="person1 '.$class.'">
									<div class="person1_header">
										<div class="image"><i class="icon-icons_mail"></i></div>
										<div class="image1" style="background: url(../'.$photo.') no-repeat; background-size: 100px 100px;"></div>
										<div class="name1">'.$nomineeName.'</div>
										<div class="subname1">'.$nominee->DirectorateInitials.'</div>
									</div>
									<div class="person1_footer">
										Our Beliefs: <b>'.$nominee->BeliefID.'</b>
	
										<br><br>
										
										Nominated by:
										<br>
										<b>'.$nominatorName.'</b>
									</div>
								</div>
								';
							}
						}
					?>
				</div>
				<div class="footer"> 
					<div class="text"> See who else has won and nominate your colleagues
					<div class="plus"><div class="image"></div></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End First Row -->

	<!-- Start Second Row -->
	<div class="row fixedWidth">
		<div id="hrquestions" class="col-md-3 clickable" href="mailto:hrservicecentre@cancer.org.uk">
			<div class="boxed">			
				<div class="header">
					Any Questions <br>
					for HR?
				</div>

				<div class="phone"></div>

				<div class="subheader">
					Call 0203 469 8220 <br>or Email<br>hrservicecentre@cancer.org.uk
				</div>
			</div>
		</div>

		<div id="health" class="col-md-3">
			<div class="boxed clickable" href="https://crukip.cancerresearchuk.org/portal/server.pt/community/Health%20and%20Wellbeing/601">
				<p>Health and Wellbeing</p>
				<div class="image"></div>
			</div>
		</div>

		<div id="childcare" class="col-md-6">
			<div class="boxed clickable" href="https://crukip.cancerresearchuk.org/portal/server.pt/community/benefits_including_rewards_gateway/2045/childcare_vouchers/21954 ">
				<div class="corner_image"></div>
				<p>Childcare Vouchers</p>
				<div class="image"></div>
			</div>
		</div>
	</div>
	<!-- End Second Row -->

	<!-- Start Third Row -->
	<div class="row fixedWidth">
		<div class="col-md-6">
			<div id="financial" class="clickable" href="https://crukip.cancerresearchuk.org/portal/server.pt/community/benefits_and_your_finance%2C_health_and_wellbeing/594/financial_advice_and_information/35069">
				<p>Financial Advice<br>and<br>Information</p>
				<div class="image"></div>
				<div class="icon"></div>
			</div>
		</div>

		<div class="col-md-3" id="cycle">
			<div class="boxed clickable" href="https://crukip.cancerresearchuk.org/portal/server.pt/community/benefits_including_rewards_gateway/2045/cycle2work/21955 ">
				<p>Cycle to Work</p>
				<div class="image"></div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="clickable boxed" href="https://crukip.cancerresearchuk.org/portal/server.pt/community/season_ticket_loan/599" id="tickets">

					<p>Season Ticket Loan</p>
					<div class="image"></div>

			</div>
			<div class="clickable" href="https://crukip.cancerresearchuk.org/portal/server.pt/community/benefits_including_rewards_gateway/2045/tastecards/21959" id="tastecard">

					<div class="image"></div>

			</div>
		</div>
	</div>
	<!-- End Third Row -->
</div>

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="../js/hub2.js"></script>	
</body>
</html>