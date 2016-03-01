<!doctype html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Our Heroes</title>
<link rel="stylesheet" href="../css/hub2/bootstrap/bootstrap.css" />
<link rel="stylesheet" href="../css/hub2/style.css">
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
			<div id="benefits">
				<p>Benefits at <br> CRUK  <br> Overview</p>
				<div class="image"></div>
			</div>

			<div class="boxed" style="margin-top: 20px;" id="pensions">
				<p>Pensions and Retirement</p>
					<div class="image">
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="callout panel" id="winners">
				<div class="header">
					The Our Heroes recognition portal<div class="image"></div>
				</div>
				<div class="body">
					<p> Recent Winners </p>
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
							
							if (strlen($nominatorName) > 11)
  								 $nominatorName = substr($nominatorName, 0, 11) . '.';

  							if (strlen($nomineeName) > 11)
  								 $nomineeName = substr($nomineeName, 0, 11) . '.';

							if($index == 0)
							{
	

								echo '
								<div class="person1">
									<div class="image"></div>
									<div class="image1" style="background: url(../'.$photo.') no-repeat; background-size: 100px 100px;"></div>
									<div class="name1">&nbsp;&nbsp; '.$nomineeName.'</div>
									<div class="subname1">'.$nominee->Department.'</div>
								</div>
								<div class="person1_footer">
									Our Beliefs:
									<br>
									<b>'.$nominee->BeliefID.'</b>

									<br><br>

									Nominated by:
									<br>
									<b>'.$nominatorName.'</b>
								</div>
								';

								$index++;
							}
							else
							{
	

								echo '
								<div class="person2">
									<div class="image"></div>
									<div class="image2" style="background: url(../'.$photo.') no-repeat; background-size: 100px 100px;"></div>
									<div class="name2">&nbsp;&nbsp;&nbsp;&nbsp;'.$nomineeName.'</div>
									<div class="subname2">'.$nominee->Department.'</div>
								</div>

								<div class="person2_footer">
									Our Beliefs:
									<br>
									<b>'.$nominee->BeliefID.'</b>

									<br><br>
									
									Nominated by:
									<br>
									<b>'.$nominatorName.'</b>
								</div>
								';
							}
						}
					?>
					<!--
					<div class="person1">
						<div class="image"></div>
						<div class="image1"></div>
						<div class="name1">&nbsp;&nbsp; Lucia Rose <br> Accountability</div>
					</div>

					<div class="person1_footer">
						Our Beliefs:
						<br>
						<b>Delivering</b>

						<br><br>

						Nominated by:
						<br>
						<b>BusinessA A</b>
					</div>

					<div class="person2">
						<div class="image"></div>
						<div class="image2"></div>
						<div class="name2">&nbsp;&nbsp;&nbsp;&nbsp; Paul Hansen <br> Human Resources</div>
					</div>

					<div class="person2_footer">
						Our Beliefs:
						<br>
						<b>Delivering</b>

						<br><br>
						
						Nominated by:
						<br>
						<b>BusinessA A</b>
					</div>
					-->
				</div>
				<div class="footer"> 
					<div class="text"> See who else has won and nominate your colleagues
					<div class="plus clickable" href="https://cruk3.xexec.com/Pages/Rewards"><div class="image"></div></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End First Row -->

	<!-- Start Second Row -->
	<div class="row fixedWidth">
		<div id="hrquestions" class="col-md-3">
			<div class="boxed">			
				<div class="header">
					Any Questions <br>
					for HR?
				</div>

				<div class="phone"></div>

				<div class="subheader">
					Call 0202251866 <br>
					or Email info@hr.cruk.com
				</div>
			</div>
		</div>

		<div id="health" class="col-md-3">
			<div class="boxed">
				<p>Health and Wellbeing</p>
				<div class="image"></div>
			</div>
		</div>

		<div id="childcare" class="col-md-6">
			<div class="boxed">
				<div class="corner_image"></div>
				<p>Childcare Vouchers</p>
				<div class="image"></div>
			</div>
		</div>
	</div>
	<!-- End Second Row -->
	<br>

	<!-- Start Third Row -->
	<div class="row fixedWidth">
		<div class="col-md-6" id="financial">
				<p>Financial Advice <br> and  <br> Information</p>
				<div class="image"></div>
				<div class="icon"></div>
		</div>

		<div class="col-md-3" id="cycle">
			<div class="boxed">
				<p>Cycle to Work</p>
				<div class="image"></div>
			</div>
		</div>

		<div class="col-md-3">
			<div id="tickets">

					<p>Season Ticket Loan</p>
					<div class="image"></div>

			</div>
			<br>
			<div id="tastecard">

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