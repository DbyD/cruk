<?php
	include_once('../inc/config.php');
	include_once('../inc/header.php');
	if(isset($_COOKIE['pruNom']['FromDate'])){
		$startdate = $_COOKIE['pruNom']['FromDate'];
	} else {
		//$startdate = new DateTime('first day of this month');
	}
	if(isset($_COOKIE['pruNom']['ToDate'])){
		$enddate = $_COOKIE['pruNom']['ToDate'];
	} else {
		//$enddate = new DateTime('last day of this month');
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
					<div class="tableReportsHead tableColumn-3 clickAble white" data-type="gourl" data-url="nomination.php">
						Nomination
					</div>
					<div class="tableReportsHead tableColumn-3 clickAble" data-type="gourl" data-url="redemption.php">
						Redemption
					</div>
					<div class="tableColumn-3">
					</div>
				</div>
			</div>
		</div>
		<div id="subHome" class="callout panel dashboard white reportHome">
			<form action="createExport.php" method="post" name="nominateReport" id="nominateReport">
				<div class="medium-6 columns">
					<div class="row ">
						<div class="medium-4 columns">
							From Date
						</div>
						<div class="medium-8 columns">
							<input id="datepickerfrom" name="FromDate" type="text" value="" />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Nominee Employee ID
						</div>
						<div class="medium-2 columns">
							<input name="NomineeID" type="checkbox" value="yes" <?php if ($_COOKIE['pruNom']['NomineeID']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Nominee
						</div>
						<div class="medium-2 columns">
							<input name="Nominee" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['Nominee']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Nominee Team
						</div>
						<div class="medium-2 columns">
							<input name="Team" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['Team']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Nominee Function
						</div>
						<div class="medium-2 columns">
							<input name="Function" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['Function']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Nominee Department
						</div>
						<div class="medium-2 columns">
							<input name="Department" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['Department']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Nominee Grade
						</div>
						<div class="medium-2 columns">
							<input name="NomGrade" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['NomGrade']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Nominator Employee ID
						</div>
						<div class="medium-2 columns">
							<input name="NominatorID" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['NominatorID']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Nominator
						</div>
						<div class="medium-2 columns">
							<input name="Nominator" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['Nominator']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Nominator Department
						</div>
						<div class="medium-2 columns">
							<input name="NominatorDept" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['NominatorDept']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Nominator Grade
						</div>
						<div class="medium-2 columns">
							<input name="NominatorGrade" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['NominatorGrade']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Volunteer Name
						</div>
						<div class="medium-2 columns">
							<input name="VolName" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['VolName']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Date Nominated
						</div>
						<div class="medium-2 columns">
							<input name="NomDate" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['NomDate']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Core Belief
						</div>
						<div class="medium-2 columns">
							<input name="CoreBelief" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['CoreBelief']=="yes") echo  "checked"; ?> />
						</div>
					</div>
				</div>
				<div class="medium-6 columns">
					<div class="row ">
						<div class="medium-4 columns">
							To Date
						</div>
						<div class="medium-8 columns">
							<input id="datepickerto" name="ToDate" type="text" value="<?php echo date("d/m/Y",$enddate); ?>" />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Nominated For
						</div>
						<div class="medium-2 columns">
							<input name="NomFor" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['NomFor']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Nomination Reason
						</div>
						<div class="medium-2 columns">
							<input name="NomReason" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['NomReason']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Personal Message
						</div>
						<div class="medium-2 columns">
							<input name="PMessage" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['PMessage']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Line Manager
						</div>
						<div class="medium-2 columns">
							<input name="LineManager" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['LineManager']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Store Manager
						</div>
						<div class="medium-2 columns">
							<input name="StoreManager" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['StoreManager']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Site Name
						</div>
						<div class="medium-2 columns">
							<input name="SiteName" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['SiteName']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Approved
						</div>
						<div class="medium-2 columns">
							<input name="Approved" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['Approved']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Approved Date
						</div>
						<div class="medium-2 columns">
							<input name="ApprovedDate" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['ApprovedDate']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Approver
						</div>
						<div class="medium-2 columns">
							<input name="Approver" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['Approver']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Declined Reason
						</div>
						<div class="medium-2 columns">
							<input name="DecReason" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['DecReason']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Did Approver amend award (remove any of the &quot;little extra&quot; award options)
						</div>
						<div class="medium-2 columns">
							<input name="LittleExtra" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['LittleExtra']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Status
						</div>
						<div class="medium-2 columns">
							<input name="Status" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['Status']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Total value of approved cash rewards
						</div>
						<div class="medium-2 columns">
							<input name="TotalVal" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['TotalVal']=="yes") echo  "checked"; ?> />
						</div>
					</div>
				</div>
				<div id="buttonRow" class="row buttonRow">
					<div class="row  noBorder valign-middle">
						<div class="medium-12 columns textRight ">
							Check All &nbsp;
							<input name="all checked" id="allchecked" type="checkbox" value="yes" <?php if ($_COOKIE['pruNom']['all checked']=="yes") echo  "checked"; ?>  onChange="CheckAll()" />
						</div>
					</div>
					<input type="submit" class="submit">
				</div>
				<input type="hidden" name="eType" value="1" />
			</form>
		</div>
	</div>
</div>
<?php include_once('../inc/footer.php'); ?>
