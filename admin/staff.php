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
		<div class="medium-12 columns leftnp rightnp fillHeight">
			<div class="callout panel fillHeight white">
				<div class="row mCustomScrollbar height555" data-mcs-theme="dark-2">
					<div class="row searchResult valign-middle">
						<div class="medium-12 columns">
							<h3>Upload New Data File</h3>
							<p>Click below to upload a new staff data file. The file must be in a .csv format.</p>
							<form method="post" action="upload-staff.php" enctype="multipart/form-data" name="uploadStaff" id="uploadStaff">
								<div class="custom-upload">
									<input type="file" name="staffFile" id="staffFile">
									<div class="fake-file">
										<input disabled="disabled" name="thisStaff" this="thisStaff" value="">
									</div>
								</div>
								<div class="row valign-middle textRight">
									<a href="#" class="blueButton clickAble" data-type="submit" data-url="uploadStaff">Upload File</a>
								</div>
							</form>
							<p>&nbsp;</p>
						</div>
					</div>
					<div class="row searchResult valign-middle">
						<div class="medium-12 columns">
							<h3>Find/Amend Colleague profile</h3>
							<p>&nbsp;</p>
							<a href="#" class="blueButton clickAble" data-type="gourl" data-url="staff-search.php">Find/Amend <i class="icon-icons_person"></i></a>
							<p>&nbsp;</p>
						</div>
					</div>
					<div class="row searchResult valign-middle">
						<div class="medium-12 columns">
							<h3>Create New Profile</h3>
							<p>&nbsp;</p>
							<a href="#" class="blueButton clickAble" data-type="gourl" data-url="staff-new.php">New Profile <i class="icon-icons_person"></i></a>
							<p>&nbsp;</p>
						</div>
					</div>
				<!--	<div class="row">
						<div class="medium-12 columns textRight">
							<p>&nbsp;</p>
							<p><a href="#" class="blueButton clickAble" data-type="gourl" data-url="index.php">Back to Admin</a></p>
						</div>
					</div>
				</div> -->
			</div>
		</div>
	</div>
</div>
<?php include_once('../inc/footer.php'); ?>
