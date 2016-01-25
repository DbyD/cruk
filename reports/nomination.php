<?php
	include_once('../inc/header.php');
	$startdate=new DateTime('first day of this month'); 
	$enddate=new DateTime('last day of this month'); 
?>

<div id="content" class="large-8 large-push-2 columns">
	<div class="title">
		<div class="inlineDiv clickAble" data-type="gourl" data-url="index.php">
			Reports
		</div>
		<i class="icon-icons_thickrightarrow smalli"></i> <span class="subSubTitle">Dashboard</span>
	</div>
	<div class="row">
		<div class="medium-12 columns leftnp rightnp">
			<div class="callout panel fillHeight white">
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
		<form action="nominate-colleague.php" method="post" name="nominateColleague" id="nominateColleague">
			<div class="rowe">
				<div class="medium-6 columns">
					<div class="row ">
						<div class="medium-10 columns">
							Nominee Employee ID
						</div>
						<div class="medium-2 columns">
							<input name="Nominee Employee ID" type="checkbox" value="yes" <?php if ($_COOKIE['pruNom']['Nominee Employee ID']=="yes") echo  "checked"; ?> />
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
							<input name="Nominee Team" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['Nominee Team']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Nominee Function
						</div>
						<div class="medium-2 columns">
							<input name="Nominee Function" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['Nominee Function']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Nominee Department
						</div>
						<div class="medium-2 columns">
							<input name="Nominee Department" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['Nominee Department']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Redemption date
						</div>
						<div class="medium-2 columns">
							<input name="Redemption date" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['Redemption date']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Order code
						</div>
						<div class="medium-2 columns">
							<input name="Order code" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['Order code']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Product Category
						</div>
						<div class="medium-2 columns">
							<input name="Product Category" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['Product Category']=="yes") echo  "checked"; ?> />
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
				</div>
				<div class="medium-6 columns">
					<div class="row ">
						<div class="medium-10 columns">
							Amount spent
						</div>
						<div class="medium-2 columns">
							<input name="Amount spent" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['Amount spent']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Email
						</div>
						<div class="medium-2 columns">
							<input name="Email" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['Email']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Telephone Number
						</div>
						<div class="medium-2 columns">
							<input name="Telephone Number" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['Telephone Number']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Delivery details
						</div>
						<div class="medium-2 columns">
							<input name="Delivery details" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['Delivery details']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Total number of awards to date
						</div>
						<div class="medium-2 columns">
							<input name="Total number of awards to date" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['Total number of awards to date']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Total number of points to date
						</div>
						<div class="medium-2 columns">
							<input name="Total number of points to date" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['Total number of points to date']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Total number of redemptions transactions to date
						</div>
						<div class="medium-2 columns">
							<input name="Total number of redemptions transactions to date" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['Total number of redemptions transactions to date']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Total value of redemption transactions completed to date
						</div>
						<div class="medium-2 columns">
							<input name="Total value of redemption transactions completed to date" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['Total value of redemption transactions completed to date']=="yes") echo  "checked"; ?> />
						</div>
					</div>
					<div class="row ">
						<div class="medium-10 columns">
							Current points balance
						</div>
						<div class="medium-2 columns">
							<input name="Current points balance" type="checkbox" value="yes" <?php if ($_COOKIE['pruRed']['Current points balance']=="yes") echo  "checked"; ?> />
						</div>
					</div>
				</div>
			</div>
			<div id="buttonRow" class="row buttonRow hidden">
				<div class="row  noBorder valign-middle">
					<div class="medium-12 columns textRight ">
						Check All &nbsp;
						<input name="all checked" id="allchecked" type="checkbox" value="yes" <?php if ($_COOKIE['pruNom']['all checked']=="yes") echo  "checked"; ?>  onChange="CheckAll()" />
					</div>
				</div>
				<input type="submit" class="submit">
			</div>
		</form>
	</div>
</div>
<?php include_once('../inc/footer.php'); ?>
