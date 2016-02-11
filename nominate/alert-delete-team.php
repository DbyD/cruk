<div id="alertTitle" class="title smallPopupTitle">
	<div class="row withPadding">
		<div class="medium-12 columns">
			Delete Team
		</div>
	</div>
</div>
<div id="alertBody" class="alertBody">
	<div class="row withPadding">
		<div class="medium-12 columns">
			<p>Are you sure you would like to Delete this team.</p>
		</div>
	</div>
	<div class="row withPadding">
		<div class="medium-6 columns textRight">
			<a id="test" href="#" class="blueButton clickAble" data-type="cancelPopup" data-id="">Cancel</a>
		</div>
		<div class="medium-6 columns textRight ">
			<form action="edit-team.php" method="POST" name="deleteTeam" id="deleteTeam">
				<input type="hidden" name="deleteTeamID" id="deleteTeamID" value="<?=$_GET['id']?>" class="" />
			</form>
			<p><a href="#" class="pinkButton clickAble" data-type="submit" data-url="deleteTeam">Confirm</a></p>
		</div>
	</div>
</div>
<script src="../js/cruk.js"></script>
