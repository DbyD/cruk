<?php
	include_once('../inc/config.php');
	include_once('../inc/header.php');
	if(isset($_COOKIE['pruRed']['FromDate'])){
		$startdate = date("d/m/Y",$_COOKIE['pruRed']['FromDate']);
	}
	if(isset($_COOKIE['pruRed']['ToDate'])){
		$enddate = date("d/m/Y",$_COOKIE['pruRed']['ToDate']);
	}
?>

<div id="content" class="large-8 large-push-2 columns">
	<div class="title">
		<div class="inlineDiv clickAble" data-type="gourl" data-url="index.php">
			Reports
		</div>
		<i class="icon-icons_thickrightarrow smalli"></i> <span class="subSubTitle">Redemption</span>
	</div>
	<div class="row contentFill">
		<div class="medium-12 columns leftnp rightnp">
			<div class="callout panel white">
				<div class="tableReports">
					<div class="tableReportsHead tableColumn-3 clickAble" data-type="gourl" data-url="index.php">
						Dashboard
					</div>
					<div class="tableReportsHead tableColumn-3 clickAble" data-type="gourl" data-url="nomination.php">
						Nomination
					</div>
					<div class="tableReportsHead tableColumn-3 clickAble white" data-type="gourl" data-url="redemption.php">
						Redemption
					</div>
					<div class="tableColumn-3">
					</div>
				</div>
			</div>
		</div>
		<div id="subHome" class="callout panel dashboard white reportHome height605">
			<form action="createExport.php" method="post" name="redemptionReport" id="redemptionReport">
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
								Nominee Employee ID
							</div>
							<div class="medium-2 columns">
								<input name="NomineeID" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['NomineeID']=="yes") echo  "checked"; ?> />
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
								Date Redeemed
							</div>
							<div class="medium-2 columns">
								<input name="RedeemDate" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['RedeemDate']=="yes") echo  "checked"; ?> />
							</div>
						</div>
					</div>
					<div class="medium-6 columns">
						<div class="row ">
							<div class="medium-10 columns">
								Transaction Code
							</div>
							<div class="medium-2 columns">
								<input name="TransCode" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['TransCode']=="yes") echo  "checked"; ?> />
							</div>
						</div>
						<div class="row ">
							<div class="medium-10 columns">
								Product Category
							</div>
							<div class="medium-2 columns">
								<input name="ProdCat" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['ProdCat']=="yes") echo  "checked"; ?> />
							</div>
						</div>
						<div class="row ">
							<div class="medium-10 columns">
								Product
							</div>
							<div class="medium-2 columns">
								<input name="Product" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['Product']=="yes") echo  "checked"; ?> />
							</div>
						</div>
						<div class="row ">
							<div class="medium-10 columns">
								Amount Spent
							</div>
							<div class="medium-2 columns">
								<input name="AmountSpent" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['AmountSpent']=="yes") echo  "checked"; ?> />
							</div>
						</div>
						<div class="row ">
							<div class="medium-10 columns">
								Current Balance
							</div>
							<div class="medium-2 columns">
								<input name="CurrentBalance" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['CurrentBalance']=="yes") echo  "checked"; ?> />
							</div>
						</div>
					</div>
				</div>
				<div class="row buttonRow">
					<div class="medium-12 columns">
						<div class="medium-6 columns">
							Check All &nbsp;
							<input name="select_all" id="select_all" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['select_all']=="yes") echo  "checked"; ?> />
						</div>
						<div class="medium-6 columns textRight ">
							<a href="#" class="pinkButton clickAble" data-type="submit" data-url="redemptionReport">Export</a>
						</div>
					</div>
				</div>
				<input type="hidden" name="eType" value="2" />
			</form>
		</div>
	</div>
</div>
<?php include_once('../inc/footer.php'); ?>
