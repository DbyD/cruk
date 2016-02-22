<?php
	include_once('../inc/config.php');
	include_once('../inc/header.php');
?>

<div id="content" class="large-8 large-push-2 columns">
	<div class="title">
		<div class="inlineDiv clickAble" data-type="gourl" data-url="index.php">
			Admin
		</div>
		<i class="icon-icons_thickrightarrow smalli"></i> <span class="subTitle clickAble" data-type="gourl" data-url="staff.php">Staff</span>
		<i class="icon-icons_thickrightarrow smalli"></i> <span class="subTitle clickAble" data-type="gourl" data-url="staff-search.php">Staff Search</span>
		<i class="icon-icons_thickrightarrow smalli"></i> <span class="subSubTitle">New Staff Details</span>
	</div>
	<div class="row contentFill">
		<div id="staffedit" class="callout panel dashboard white fillHeight white">
			<form action="staff-insert.php" method="post" name="insertStaffForm" id="insertStaffForm">
				<input type="hidden" name="formName" value="updateStaff">
				<input type="hidden" value="" name="id" id="id">
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
								<input type="text" value="" name="EmpNum" id="EmpNum" required>
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Password
							</div>
							<div class="medium-8 columns">
								<input type="password" value="" name="sPassword" id="sPassword" >
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns doubleLine">
								Repeat Password
							</div>
							<div class="medium-8 columns">
								<input type="password" value="" name="repeatPassword" id="repeatPassword" >
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								First name
							</div>
							<div class="medium-8 columns">
								<input type="text" value="" name="Fname" id="Fname" required>
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Surname
							</div>
							<div class="medium-8 columns">
								<input type="text" value="" name="Sname" id="Sname" required>
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Preferred Name
							</div>
							<div class="medium-8 columns">
								<input type="text" value="" name="PreferredFname" id="PreferredFname">
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Email address
							</div>
							<div class="medium-8 columns">
								<input type="text" value="" name="Eaddress" id="Eaddress">
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Job Title
							</div>
							<div class="medium-8 columns">
								<input type="text" value="" name="JobTitle" id="JobTitle" >
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Grade
							</div>
							<div class="medium-8 columns">
								<input type="text" value="" name="Grade" id="Grade" >
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Shop
							</div>
							<div class="medium-8 columns">
								<input type="text" value="" name="Shop" id="Shop" >
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Retail Area
							</div>
							<div class="medium-8 columns">
								<input type="text" value="" name="RetailArea" id="RetailArea" >
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Team
							</div>
							<div class="medium-8 columns">
								<input type="text" value="" name="Team" id="Team" >
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Section
							</div>
							<div class="medium-8 columns">
								<input type="text" value="" name="Section" id="Section" >
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Department
							</div>
							<div class="medium-8 columns">
								<input type="text" value="" name="Department" id="Department" >
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Directorate
							</div>
							<div class="medium-8 columns">
								<input type="text" value="" name="Directorate" id="Directorate" >
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Location Name
							</div>
							<div class="medium-8 columns">
								<input type="text" value="" name="LocationName" id="LocationName" >
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns doubleLine">
								Location Address
							</div>
							<div class="medium-8 columns">
								<input type="text" value="" name="LocationAddress" id="LocationAddress" >
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
								<input type="text" value="" name="LMEmpNum" id="LMEmpNum" >
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								First name
							</div>
							<div class="medium-8 columns">
								<input type="text" value="" name="LMFname" id="LMFname" >
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Surname
							</div>
							<div class="medium-8 columns">
								<input type="text" value="" name="LMSname" id="LMSname">
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Email address
							</div>
							<div class="medium-8 columns">
								<input type="text" value="" name="LMEaddress" id="LMEaddress">
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Grade
							</div>
							<div class="medium-8 columns">
								<input type="text" value="" name="LMGrade" id="LMGrade" >
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
								<input type="text" value="" name="AppEmpNum" id="AppEmpNum" >
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								First name
							</div>
							<div class="medium-8 columns">
								<input type="text" value="" name="AppFname" id="AppFname" >
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Surname
							</div>
							<div class="medium-8 columns">
								<input type="text" value="" name="AppSname" id="AppSname" >
							</div>
						</div>
						<div class="row">
							<div class="medium-4 columns">
								Email address
							</div>
							<div class="medium-8 columns">
								<input type="text" value="" name="AppEaddress" id="AppEaddress" >
							</div>
						</div>
						<div class="row">
							<div class="medium-12 columns">
								<h2>Privileges</h2>
							</div>
						</div>
						<div class="row">
							<div class="medium-6 columns">
								Eligible
							</div>
							<div class="small-3 medium-3 columns">
								YES &nbsp; <input type="radio" value="1" name="eligible" id="eligible1" checked>
							</div>
							<div class="small-3 medium-3 columns">
								NO &nbsp; <input type="radio" value="0" name="eligible" id="eligible2" >
							</div>
						</div>
						<div class="row">
							<div class="small-6 medium-6 columns">
								Activated
							</div>
							<div class="small-3 medium-3 columns">
								YES &nbsp; <input type="radio" value="1" name="activated" id="activated1" >
							</div>
							<div class="small-3 medium-3 columns">
								NO &nbsp; <input type="radio" value="0" name="activated" id="activated2" checked>
							</div>
						</div>
						<div class="row">
							<div class="small-6 medium-6 columns">
								Super User
							</div>
							<div class="small-3 medium-3 columns">
								YES &nbsp; <input type="radio" value="Y" name="SuperUser" id="SuperUser1" >
							</div>
							<div class="small-3 medium-3 columns">
								NO &nbsp; <input type="radio" value="N" name="SuperUser" id="SuperUser2" checked>
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
