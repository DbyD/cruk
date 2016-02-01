<?php include '../inc/config.php'; ?>
<div id="alertTitle" class="title smallPopupTitle">
	<div class="row withPadding">
		<div class="medium-12 columns">
			Find/Ceate Team
			<div class="small">Search for an existing team (e.g. ‘Payroll’) or for individual colleagues</div>
		</div>
		<div class="medium-12 columns">
			<div class="">
				<form action="colleague.php" method="GET" name="searchTeam" id="searchTeam">
					<div class="medium-10 columns noPadding">
						<input type="text" name="searchAuto" id="searchAuto" value="" class="search" />
					</div>
					<div class="medium-2 columns noPadding">
						<div class="purpleButton clickAble" data-type="submit" data-url="searchTeam">Search</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div id="alertBody" class="alertBody">
	<form action="team-details.php" method="post" name="nominateTeamMember" id="nominateTeamMember">
				<input type="hidden" name="formName" value="nominateTeamMember">
				<div class="row mCustomScrollbar height515" data-mcs-theme="dark-2">
				<?php
					if ($_GET['searchAuto']){
						$search = $_GET['searchAuto'];
						$searchUsers = new searchUsers($db);
						$searchList = $searchUsers->getAllSearch($search);
						$x = 0 ;
						if ($searchList){
							foreach ($searchList as $list){
								$x = $x + 1 ;
				?>
					<div class="row searchResult valign-middle">
						<div class="medium-2 columns">
							<img src="<?=HTTP_PATH.$list->Photo?>" alt="" onerror="this.src='<?=HTTP_PATH?>images/no-photo.png'"/>
						</div>
						<div class="medium-4 columns">
							<?php echo $list->Fname.' '.$list->Sname; ?>
						</div>
						<div class="medium-5 columns">
							<?php echo $list->Team; ?>
						</div>
						<div class="medium-1 columns textRight">
							<div class="hiddenTick">
								<input type="radio" value="<?=$list->EmpNum?>" name="EmpNum" id="EmpNum<?=$x?>" required>
								<label for="EmpNum<?=$x?>"></label>
							</div>
						</div>
					</div>
				<?php
							}
						} else {
						?>
					<div class="row searchResult valign-middle">
						<div class="medium-12 columns">
							<p>Sorry no results matching your search. Please try again.</p>
						</div>
					</div>
						<?php
						}
					} else { ?>
					<div class="row searchResult valign-middle">
						<div class="medium-12 columns">
							<p>Please enter the name of the colleague you would like to nominate in the Search box above.</p>
						</div>
					</div>
				<?php } ?>
				</div>
				<div id="buttonRow" class="row buttonRow hidden">
					<div class="row searchResult noBorder valign-middle">
						<div class="medium-12 columns textRight ">
							<a href="#" class="pinkButton clickAble" data-type="submit" data-url="nominateTeamMember">Nominate Individual</a>
						</div>
					</div>
				</div>
			</form>
</div>
<script src="../js/cruk.js"></script>
