<?php
	include_once('../inc/config.php');
	include_once('../inc/header.php');
	if ($_POST['EmpNum']){
		$staff = getUser($_POST['EmpNum']);
	}
?>

<div id="content" class="large-8 large-push-2 columns">
	<div class="title">
		<div class="inlineDiv clickAble" data-type="gourl" data-url="index.php">
			Admin
		</div>
		<i class="icon-icons_thickrightarrow smalli"></i> <span class="subTitle clickAble" data-type="gourl" data-url="staff.php">Staff</span>
		<i class="icon-icons_thickrightarrow smalli"></i> <span class="subTitle clickAble" data-type="gourl" data-url="staff-search.php">Staff Search</span>
		<i class="icon-icons_thickrightarrow smalli"></i> <span class="subSubTitle"><?php echo $staff->Fname.' '.$staff->Sname?></span>
	</div>
	<div class="row contentFill">
		<div id="staffedit" class="callout panel dashboard white fillHeight white">
			<form action="staff-update.php" method="post" name="updateStaffForm" id="updateStaffForm">
				<input type="hidden" name="formName" value="updateStaff">
				<input type="hidden" value="<?=$staff->id?>" name="id" id="id" required>
				
				<div class="row">
					<div class="medium-6 columns">
						<div class="row">
							<div class="medium-12 columns">
								<h2>Employee</h2>
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Emp Number
							</div>
							<div class="medium-8 columns">
								<input type="text" value="<?=$staff->EmpNum?>" name="EmpNum" id="EmpNum" required>
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Password
							</div>
							<div class="medium-8 columns">
								<input type="password" value="<?=$staff->sPassword?>" name="sPassword" id="sPassword" >
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns doubleLine">
								Repeat Password
							</div>
							<div class="medium-8 columns">
								<input type="password" value="<?=$staff->sPassword?>" name="repeatPassword" id="repeatPassword" >
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								First name
							</div>
							<div class="medium-8 columns">
								<input type="text" value="<?=$staff->Fname?>" name="Fname" id="Fname" required>
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Surname
							</div>
							<div class="medium-8 columns">
								<input type="text" value="<?=$staff->Sname?>" name="Sname" id="Sname" required>
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Preferred Name
							</div>
							<div class="medium-8 columns">
								<input type="text" value="<?=$staff->PreferredFname?>" name="PreferredFname" id="PreferredFname">
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Email address
							</div>
							<div class="medium-8 columns">
								<input type="text" value="<?=$staff->Eaddress?>" name="Eaddress" id="Eaddress">
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Job Title
							</div>
							<div class="medium-8 columns">
								<input type="text" value="<?=$staff->JobTitle?>" name="JobTitle" id="JobTitle">
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Grade
							</div>
							<div class="medium-8 columns">
								<input type="text" value="<?=$staff->Grade?>" name="Grade" id="Grade" >
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Shop
							</div>
							<div class="medium-8 columns">
								<input type="text" value="<?=$staff->Shop?>" name="Shop" id="Shop" >
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Retail Area
							</div>
							<div class="medium-8 columns">
								<input type="text" value="<?=$staff->RetailArea?>" name="RetailArea" id="RetailArea" >
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Team
							</div>
							<div class="medium-8 columns">
								<input type="text" value="<?=$staff->Team?>" name="Team" id="Team" >
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Section
							</div>
							<div class="medium-8 columns">
								<input type="text" value="<?=$staff->Section?>" name="Section" id="Section" >
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Department
							</div>
							<div class="medium-8 columns">
								<input type="text" value="<?=$staff->Department?>" name="Department" id="Department">
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Directorate
							</div>
							<div class="medium-8 columns">
								<input type="text" value="<?=$staff->Directorate?>" name="Directorate" id="Directorate">
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Location Name
							</div>
							<div class="medium-8 columns">
								<input type="text" value="<?=$staff->LocationName?>" name="LocationName" id="LocationName" >
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns doubleLine">
								Location Address
							</div>
							<div class="medium-8 columns">
								<input type="text" value="<?=$staff->LocationAddress?>" name="LocationAddress" id="LocationAddress" >
							</div>
						</div>
					</div>
					<div class="medium-6 columns">
						<div class="row">
							<div class="medium-12 columns">
								<h2>Line Manager</h2>
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Emp Number
							</div>
							<div class="medium-8 columns">
								<input type="text" value="<?=$staff->LMEmpNum?>" name="LMEmpNum" id="LMEmpNum">
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								First name
							</div>
							<div class="medium-8 columns">
								<input type="text" value="<?=$staff->LMFname?>" name="LMFname" id="LMFname">
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Surname
							</div>
							<div class="medium-8 columns">
								<input type="text" value="<?=$staff->LMSname?>" name="LMSname" id="LMSname">
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Email address
							</div>
							<div class="medium-8 columns">
								<input type="text" value="<?=$staff->LMEaddress?>" name="LMEaddress" id="LMEaddress">
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Grade
							</div>
							<div class="medium-8 columns">
								<input type="text" value="<?=$staff->LMGrade?>" name="LMGrade" id="LMGrade" >
							</div>
						</div>
						<div class="row">
							<div class="medium-12 columns">
								<h2>Approver</h2>
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Emp Number
							</div>
							<div class="medium-8 columns">
								<input type="text" value="<?=$staff->AppEmpNum?>" name="AppEmpNum" id="AppEmpNum" >
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								First name
							</div>
							<div class="medium-8 columns">
								<input type="text" value="<?=$staff->AppFname?>" name="AppFname" id="AppFname" >
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Surname
							</div>
							<div class="medium-8 columns">
								<input type="text" value="<?=$staff->AppSname?>" name="AppSname" id="AppSname" >
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Email address
							</div>
							<div class="medium-8 columns">
								<input type="text" value="<?=$staff->AppEaddress?>" name="AppEaddress" id="AppEaddress" >
							</div>
						</div>
						<div class="row">
							<div class="medium-12 columns">
								<h2>Privileges</h2>
							</div>
						</div>
						<div class="row">
							<div class="small-6 medium-6 columns">
								Eligible
							</div>
							<div class="small-3 medium-3 columns">
								YES &nbsp; <input type="radio" value="1" name="eligible" id="eligible1" <?php if($staff->eligible == 1) echo 'checked'; ?>>
							</div>
							<div class="small-3 medium-3 columns">
								NO &nbsp; <input type="radio" value="0" name="eligible" id="eligible2" <?php if($staff->eligible == 0) echo 'checked'; ?> >
							</div>
						</div>
						<div class="row">
							<div class="small-6 medium-6 columns">
								Activated
							</div>
							<div class="small-3 medium-3 columns">
								YES &nbsp; <input type="radio" value="1" name="activated" id="activated1" <?php if($staff->activated == 1) echo 'checked'; ?>>
							</div>
							<div class="small-3 medium-3 columns">
								NO &nbsp; <input type="radio" value="0" name="activated" id="activated2" <?php if($staff->activated == 0) echo 'checked'; ?> >
							</div>
						</div>
						<div class="row">
							<div class="small-6 medium-6 columns">
								Super User
							</div>
							<div class="small-3 medium-3 columns">
								YES &nbsp; <input type="radio" value="Y" name="SuperUser" id="SuperUser1" <?php if($staff->SuperUser == 'Y') echo 'checked'; ?>>
							</div>
							<div class="small-3 medium-3 columns">
								NO &nbsp; <input type="radio" value="N" name="SuperUser" id="SuperUser2" <?php if($staff->SuperUser != 'Y') echo 'checked'; ?> >
							</div>
						</div>
						<div class="row">
							<div class="medium-12 columns textRight">
								<p><a href="#" class="pinkButton clickAble" data-type="submit" data-url="updateStaffForm">Save</a></p>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php include_once('../inc/footer.php'); ?>
