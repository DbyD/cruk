<?php
	include_once('../inc/config.php');
	include_once('../inc/header.php');
	if(isset($_COOKIE['crukTeamNom']['FromDate'])){
		$startdate = date("d-m-Y",strtotime($_COOKIE['crukTeamNom']['FromDate']));
	}
	if(isset($_COOKIE['crukTeamNom']['ToDate'])){
		$enddate = date("d-m-Y",strtotime($_COOKIE['crukTeamNom']['ToDate']));
	}
?>

<div id="content" class="large-8 large-push-2 columns">
	<div class="title">
		<div class="inlineDiv clickAble" data-type="gourl" data-url="index.php">
			Reports
		</div>
		<i class="icon-icons_thickrightarrow smalli"></i> <span class="subSubTitle">Nomination</span>
	</div>
	<div class="row contentFill">
		<div class="medium-12 columns leftnp rightnp">
			<div class="callout panel white">
				<div class="tableReports">
					<div class="tableReportsHead tableColumn-3 clickAble" data-type="gourl" data-url="index.php">
						Dashboard
					</div>
					<div class="tableReportsHead tableColumn-3 clickAble" data-type="gourl" data-url="nomination.php">
						Individual Nomination
					</div>
					<div class="tableReportsHead tableColumn-3 clickAble white" data-type="gourl" data-url="team-nomination.php">
						Team Nomination
					</div>
					<div class="tableReportsHead tableColumn-3 clickAble" data-type="gourl" data-url="redemption.php">
						Redemption
					</div>
				</div>
			</div>
		</div>
		<div id="subHome" class="callout panel dashboard white reportHome height605">
			<form action="createExport.php" method="post" name="nominateReport" id="nominateReport">
				<div class="row">
					<div class="medium-6 columns">
						<div class="row dateInput">
							<div class="medium-4 columns">
								From Date
							</div>
							<div class="medium-8 columns">
								<input id="datepickerfrom" name="FromDate" type="text" value="<?php echo $startdate; ?>" />
							</div>
						</div>
					</div>
					<div class="medium-6 columns">
						<div class="row dateInput">
							<div class="medium-4 columns">
								To Date
							</div>
							<div class="medium-8 columns">
								<input id="datepickerto" name="ToDate" type="text" value="<?php echo $enddate; ?>" />
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="medium-6 columns">
						<div class="row ">
							<div class="medium-10 columns">
								Team
							</div>
							<div class="medium-2 columns">
								<input name="Team" type="checkbox" value="yes" <?php if ($_COOKIE['crukTeamNom']['Team']=="yes") echo  "checked"; ?> />
							</div>
						</div>
						<div class="row ">
							<div class="medium-10 columns">
								Nominees
							</div>
							<div class="medium-2 columns">
								<input name="Nominees" type="checkbox" value="yes" <?php if ($_COOKIE['crukTeamNom']['Nominees']=="yes") echo  "checked"; ?> />
							</div>
						</div>
						<div class="row ">
							<div class="medium-10 columns">
								Nominator Employee ID
							</div>
							<div class="medium-2 columns">
								<input name="NominatorID" type="checkbox" value="yes" <?php if ($_COOKIE['crukTeamNom']['NominatorID']=="yes") echo  "checked"; ?> />
							</div>
						</div>
						<div class="row ">
							<div class="medium-10 columns">
								Nominator
							</div>
							<div class="medium-2 columns">
								<input name="Nominator" type="checkbox" value="yes" <?php if ($_COOKIE['crukTeamNom']['Nominator']=="yes") echo  "checked"; ?> />
							</div>
						</div>
						<div class="row ">
							<div class="medium-10 columns">
								Nominator Department
							</div>
							<div class="medium-2 columns">
								<input name="NominatorDept" type="checkbox" value="yes" <?php if ($_COOKIE['crukTeamNom']['NominatorDept']=="yes") echo  "checked"; ?> />
							</div>
						</div>
						<div class="row ">
							<div class="medium-10 columns">
								Nominator Grade
							</div>
							<div class="medium-2 columns">
								<input name="NominatorGrade" type="checkbox" value="yes" <?php if ($_COOKIE['crukTeamNom']['NominatorGrade']=="yes") echo  "checked"; ?> />
							</div>
						</div>
						<div class="row ">
							<div class="medium-10 columns">
								Include me
							</div>
							<div class="medium-2 columns">
								<input name="includeMe" type="checkbox" value="yes" <?php if ($_COOKIE['crukTeamNom']['includeMe']=="yes") echo  "checked"; ?> />
							</div>
						</div>
						<div class="row ">
							<div class="medium-10 columns">
								Volunteer Name
							</div>
							<div class="medium-2 columns">
								<input name="VolName" type="checkbox" value="yes" <?php if ($_COOKIE['crukTeamNom']['VolName']=="yes") echo  "checked"; ?> />
							</div>
						</div>
					</div>
					<div class="medium-6 columns">
						<div class="row ">
							<div class="medium-10 columns">
								Date Nominated
							</div>
							<div class="medium-2 columns">
								<input name="NomDate" type="checkbox" value="yes" <?php if ($_COOKIE['crukTeamNom']['NomDate']=="yes") echo  "checked"; ?> />
							</div>
						</div>
						<div class="row ">
							<div class="medium-10 columns">
								Core Belief
							</div>
							<div class="medium-2 columns">
								<input name="CoreBelief" type="checkbox" value="yes" <?php if ($_COOKIE['crukTeamNom']['CoreBelief']=="yes") echo  "checked"; ?> />
							</div>
						</div>
						<div class="row ">
							<div class="medium-10 columns">
								Nomination Reason
							</div>
							<div class="medium-2 columns">
								<input name="NomReason" type="checkbox" value="yes" <?php if ($_COOKIE['crukTeamNom']['NomReason']=="yes") echo  "checked"; ?> />
							</div>
						</div>
						<div class="row ">
							<div class="medium-10 columns">
								Personal Message
							</div>
							<div class="medium-2 columns">
								<input name="PMessage" type="checkbox" value="yes" <?php if ($_COOKIE['crukTeamNom']['PMessage']=="yes") echo  "checked"; ?> />
							</div>
						</div>
						<div class="row ">
							<div class="medium-10 columns">
								Approver
							</div>
							<div class="medium-2 columns">
								<input name="Approver" type="checkbox" value="yes" <?php if ($_COOKIE['crukTeamNom']['Approver']=="yes") echo  "checked"; ?> />
							</div>
						</div>
						<div class="row ">
							<div class="medium-10 columns">
								Approval Status
							</div>
							<div class="medium-2 columns">
								<input name="Approved" type="checkbox" value="yes" <?php if ($_COOKIE['crukTeamNom']['Approved']=="yes") echo  "checked"; ?> />
							</div>
						</div>
						<div class="row ">
							<div class="medium-10 columns">
								Approved/Declined Date
							</div>
							<div class="medium-2 columns">
								<input name="ApprovedDate" type="checkbox" value="yes" <?php if ($_COOKIE['crukTeamNom']['ApprovedDate']=="yes") echo  "checked"; ?> />
							</div>
						</div>
						<div class="row ">
							<div class="medium-10 columns">
								Declined Reason
							</div>
							<div class="medium-2 columns">
								<input name="DecReason" type="checkbox" value="yes" <?php if ($_COOKIE['crukTeamNom']['DecReason']=="yes") echo  "checked"; ?> />
							</div>
						</div>
						<div class="row ">
							<div class="medium-10 columns">
								Amount
							</div>
							<div class="medium-2 columns">
								<input name="Amount" type="checkbox" value="yes" <?php if ($_COOKIE['crukTeamNom']['Amount']=="yes") echo  "checked"; ?> />
							</div>
						</div>
					</div>
				</div>
				<div class="row buttonRow">
					<div class="medium-12 columns">
						<div class="medium-6 columns">
							Check All &nbsp;
							<input name="select_all" id="select_all" type="checkbox" value="yes" <?php if ($_COOKIE['crukTeamNom']['select_all']=="yes") echo  "checked"; ?> />
						</div>
						<div class="medium-6 columns textRight ">
							<a href="#" class="pinkButton clickAble" data-type="submit" data-url="nominateReport">Export</a>
						</div>
					</div>
				</div>
				<input type="hidden" name="eType" value="1" />
				<input type="hidden" name="EmpNum" value="<?php echo $_SESSION["user"]->EmpNum;?>" />
			</form>
		</div>
	</div>
</div>
<?php include_once('../inc/footer.php'); ?>
