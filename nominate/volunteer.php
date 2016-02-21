<?php include '../inc/config.php'; ?>
<div id="alertTitle" class="title smallPopupTitle">
	<div class="row withPadding">
		<div class="medium-12 columns">
			Nominating on behalf of a Volunteer?
		</div>
	</div>
</div>
<div id="alertBody" class="alertBody">
	<form action="#" method="post" name="volunteerForm" id="volunteerForm">
		<div class="row withPadding">
			<div class="medium-12 columns">
				Please tell us if a volunteer has asked you to complete a nomination on their behalf.
			</div>
		</div>
		<div class="row valign-middle">
			<div class="medium-4 columns">
				Name:
			</div>
			<div class="medium-8 columns">
				<input type="text" name="Volunteer" id="Volunteer" value="<?=$_SESSION['nominee']->Volunteer?>" />
			</div>
		</div>
		<div class="row valign-middle">
			<div class="medium-4 columns">
				Department or Shop:
			</div>
			<div class="medium-8 columns">
				<input type="text" name="VolunteerDepartment" id="VolunteerDepartment" value="<?=$_SESSION['nominee']->VolunteerDepartment?>" />
			</div>
		</div>
		<div class="row withPadding">
			<!--<div class="medium-5 columns">
				<a href="#" class="blueButton clickAble" data-type="cancelPopup" data-id="Volunteer">Cancel</a>
			</div>-->
			<div class="medium-8 columns textRight">
				<?php if ($_SESSION['nominee']->Volunteer !='') { ?>
				<a id="test" href="#" class="blueButton clickAble" data-type="clear" data-id="v">Delete Volunteer</a>
				<?php } ?>
			</div>
			<div class="medium-4 columns textRight ">
				<a href="#" class="pinkButton clickAble" data-type="submit" data-url="volunteerForm">Confirm</a>
			</div>
		</div>
	</form>
</div>
<script src="../js/cruk.js"></script>
