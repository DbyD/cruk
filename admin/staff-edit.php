<?php
	include_once('../inc/config.php');
	include_once('../inc/header.php');
?>
			<div id="content" class="large-8 large-push-2 columns">
				<div class="title">
					<div class="inlineDiv clickAble" data-type="gourl" data-url="index.php">
						Admin
					</div>
					<i class="icon-icons_thickrightarrow smalli"></i> <span class="subSubTitle">Staff Data</span>
				</div>
				<div class="row contentFill">
					<div class="callout panel white contentFill">
						<form action="staff-update.php" method="post" name="updateStaff" id="updateStaff">
							<input type="hidden" name="formName" value="updateStaff">
							<input type="hidden" value="<?=$staff->id?>" name="id" id="id" required>
							<?php
								if ($_POST['EmpNum']){
									//echo $_POST['EmpNum'];
									$staff = getUser($_POST['EmpNum']);
									//print_r($staff);
								}
							?>
							<div class="row  valign-middle">
								<div class="medium-2 columns">
									EmpNum
								</div>
								<div class="medium-4 columns">
									<input type="text" value="<?=$staff->EmpNum?>" name="EmpNum" id="EmpNum" required>
								</div>
								<div class="medium-2 columns">
									Password
								</div>
								<div class="medium-4 columns">
									<input type="password" value="<?=$staff->sPassword?>" name="sPassword" id="sPassword" required>
								</div>
							</div>
							<div class="row  valign-middle">
								<div class="medium-2 columns">
									First name
								</div>
								<div class="medium-4 columns">
									<input type="text" value="<?=$staff->Fname?>" name="Fname" id="Fname" required>
								</div>
								<div class="medium-2 columns">
									Surname
								</div>
								<div class="medium-4 columns">
									<input type="text" value="<?=$staff->Sname?>" name="Sname" id="Sname" required>
								</div>
							</div>
							<div class="row valign-middle">
								<div class="medium-2 columns">
									Preferred Name
								</div>
								<div class="medium-4 columns">
									<input type="text" value="<?=$staff->PreferredFname?>" name="PreferredFname" id="PreferredFname" required>
								</div>
								<div class="medium-2 columns">
									Photo
								</div>
								<div class="medium-4 columns">
									<input type="text" value="<?=$staff->Photo?>" name="Photo" id="Photo" required>
								</div>
							</div>
							<div class="row valign-middle">
								<div class="medium-2 columns">
									Email address
								</div>
								<div class="medium-4 columns">
									<input type="text" value="<?=$staff->Eaddress?>" name="Eaddress" id="Eaddress" required>
								</div>
								<div class="medium-2 columns">
									Job Title
								</div>
								<div class="medium-4 columns">
									<input type="text" value="<?=$staff->JobTitle?>" name="JobTitle" id="JobTitle" required>
								</div>
							</div>
							<div class="row valign-middle">
								<div class="medium-2 columns">
									Grade
								</div>
								<div class="medium-4 columns">
									<input type="text" value="<?=$staff->Grade?>" name="Grade" id="Grade" required>
								</div>
								<div class="medium-2 columns">
									Shop
								</div>
								<div class="medium-4 columns">
									<input type="text" value="<?=$staff->Shop?>" name="Shop" id="Shop" required>
								</div>
							</div>
							<div class="row valign-middle">
								<div class="medium-2 columns">
									Retail Area
								</div>
								<div class="medium-4 columns">
									<input type="text" value="<?=$staff->RetailArea?>" name="RetailArea" id="RetailArea" required>
								</div>
								<div class="medium-2 columns">
									Team
								</div>
								<div class="medium-4 columns">
									<input type="text" value="<?=$staff->Team?>" name="Team" id="Team" required>
								</div>
							</div>
							<div class="row valign-middle">
								<div class="medium-2 columns">
									Section
								</div>
								<div class="medium-4 columns">
									<input type="text" value="<?=$staff->Section?>" name="Section" id="Section" required>
								</div>
								<div class="medium-2 columns">
									Department
								</div>
								<div class="medium-4 columns">
									<input type="text" value="<?=$staff->Department?>" name="Department" id="Department" required>
								</div>
							</div>
							<div class="row valign-middle">
								<div class="medium-2 columns">
									Directorate
								</div>
								<div class="medium-4 columns">
									<input type="text" value="<?=$staff->Directorate?>" name="Directorate" id="Directorate" required>
								</div>
								<div class="medium-2 columns">
									Location Name
								</div>
								<div class="medium-4 columns">
									<input type="text" value="<?=$staff->LocationName?>" name="LocationName" id="LocationName" required>
								</div>
							</div>
							<div class="row valign-middle">
								<div class="medium-2 columns">
									LocationAddress
								</div>
								<div class="medium-4 columns">
									<input type="text" value="<?=$staff->LocationAddress?>" name="LocationAddress" id="LocationAddress" required>
								</div>
								<div class="medium-2 columns">
									Shop Manager
								</div>
								<div class="medium-4 columns">
									<input type="checkbox" value="<?=$staff->ShopManager?>" name="ShopManager" id="ShopManager" required>
								</div>
							</div>
							<div class="row valign-middle">
								<div class="medium-2 columns">
									Super User
								</div>
								<div class="medium-4 columns">
									<input type="checkbox" value="<?=$staff->SuperUser?>" name="SuperUser" id="SuperUser" required>
								</div>
								<div class="medium-2 columns">
									Line Manager EmpNum
								</div>
								<div class="medium-4 columns">
									<input type="text" value="<?=$staff->LMEmpNum?>" name="LMEmpNum" id="LMEmpNum" required>
								</div>
							</div>
							<div class="row valign-middle">
								<div class="medium-2 columns">
									Line Manager Firest name
								</div>
								<div class="medium-4 columns">
									<input type="text" value="<?=$staff->LMFname?>" name="LMFname" id="LMFname" required>
								</div>
								<div class="medium-2 columns">
									Line Manager Surname
								</div>
								<div class="medium-4 columns">
									<input type="text" value="<?=$staff->LMSname?>" name="LMSname" id="LMSname" required>
								</div>
							</div>
							<div class="row valign-middle">
								<div class="medium-2 columns">
									Line Manager Email address
								</div>
								<div class="medium-4 columns">
									<input type="text" value="<?=$staff->LMEaddress?>" name="LMEaddress" id="LMEaddress" required>
								</div>
								<div class="medium-2 columns">
									AppEmpNum
								</div>
								<div class="medium-4 columns">
									<input type="text" value="<?=$staff->AppEmpNum?>" name="AppEmpNum" id="AppEmpNum" required>
								</div>
							</div>
							<div class="row valign-middle">
								<div class="medium-2 columns">
									Approver First name
								</div>
								<div class="medium-4 columns">
									<input type="text" value="<?=$staff->AppFname?>" name="AppFname" id="AppFname" required>
								</div>
								<div class="medium-2 columns">
									Approver Surname
								</div>
								<div class="medium-4 columns">
									<input type="text" value="<?=$staff->AppSname?>" name="AppSname" id="AppSname" required>
								</div>
							</div>
							<div class="row valign-middle">
								<div class="medium-2 columns">
									Approver Email address
								</div>
								<div class="medium-4 columns">
									<input type="text" value="<?=$staff->AppEaddress?>" name="AppEaddress" id="AppEaddress" required>
								</div>
								<div class="medium-2 columns">
									status
								</div>
								<div class="medium-4 columns">
									<input type="text" value="<?=$staff->activated?>" name="activated" id="activated" required>
								</div>
							</div>
							<div id="buttonRow" class="row buttonRow">
								<div class="row searchResult noBorder valign-middle">
									<div class="medium-12 columns textRight ">
										<a href="#" class="pinkButton clickAble" data-type="submit" data-url="editStaff">Update Employee</a>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<?php include_once('../inc/footer.php'); ?>
