<?php
	include '../inc/config.php';
?>

<div id="alertTitle" class="title smallPopupTitle">
	<div class="row withPadding">
		<div class="medium-12 columns">
			Find/Ceate Team
			<div class="small">
				Search for an existing team (e.g. 'Payroll') or for individual colleagues
			</div>
		</div>
		<div class="medium-12 columns">
			<div class="searchTeamInput">
				<form action="team-details.php" method="POST" name="searchTeam" id="searchTeam">
					<div class="medium-9 columns noPadding">
						<input type="text" name="searchTeamAuto" id="searchTeamAuto" value="" class="search" />
					</div>
					<div class="medium-3 columns noPadding">
						<div class="purpleButton clickAble" data-type="submit" data-id="letsub" data-url="searchTeam">
							Search
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div id="alertBody" class="alertBody">
	<div class="row mCustomScrollbar height175 scrollBar" data-mcs-theme="dark-2">
		<form action="team-details.php" method="post" name="addTeamMember" id="addTeamMember">
			<input type="hidden" name="ssTeamMember" id="ssTeamMember" value="test">
				<?php
					if ($_GET['searchTeamAuto']){
						$search = $_GET['searchTeamAuto'];
						$searchUsers = new searchUsers($db);
						$searchList = $searchUsers->getAllSearch($search);
						$x = 0 ;
						if ($searchList){
							foreach ($searchList as $list){
								$x = $x + 1 ;
				?>
					<div class="row searchResult valign-middle">
						<div class="medium-1 columns noPadding">
							<img src="<?=HTTP_PATH.$list->Photo?>" alt="" onerror="this.src='<?=HTTP_PATH?>images/no-photo.png'"/>
						</div>
						<div class="medium-4 columns">
							<?php echo $list->Fname.' '.$list->Sname; ?>
						</div>
						<div class="medium-5 columns">
							<?php echo $list->Team; ?>
						</div>
						<div class="medium-1 columns textRight">
							<div id="teamTick" class="circleTick inline smallTick clickAble" data-type="addTeam" data-id="<?php echo $list->id; ?>" data-url="team-details.php">
								<label for="teamTick"></label>
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
		</form>
	</div>
</div>
<div id="teamMembers" class="greyBox">
	<div class="row mCustomScrollbar height120 scrollBar" data-mcs-theme="dark-2">
		<div class="row withPadding">
			<div class="medium-12 columns noPadding">
				<div class="small">
					This team currently includes
				</div>
			</div>
			<div class="medium-12 columns noPadding">
				<div class="row valign-middle withTopPadding">
					<div class="medium-5 columns noPadding">
						EmployeeA A
					</div>
					<div class="medium-1 columns">
						<i class="icon-icons_close clickAble" data-type="clear" data-id="v"></i>
					</div>
					<div class="medium-5 columns noPadding">
						EmployeeB B
					</div>
					<div class="medium-1 columns">
						<i class="icon-icons_close clickAble" data-type="clear" data-id="v"></i>
					</div>
				</div>
				<?php
					// add in current team members
					if ($_GET['TeamMember']){
						 $teamMember = $_GET['TeamMember'];
						 echo $teamMember;
						 $addTeamMember = addTeamMember($_GET['TeamMember']);
					}
				?>
			</div>
		</div>
	</div>
</div>
<div id="alertTitle" class="row title smallPopupTitle">
	<div class="medium-12 columns">
		<div class="small">
			Choose an appropriate team name, then add colleagues. The team name will be visible on the Wall of Fame
		</div>
	</div>
	<div class="medium-12 columns">
		<div class="TeamInputName">
			<form action="team-details.php" method="POST" name="formMYTeamName" id="formMYTeamName">
				<input type="text" name="id" id="id" value="" class="" />
				<input type="text" name="myTeamName" id="myTeamName" value="" class="" />
			</form>
		</div>
	</div>
</div>
<div id="buttonRow" class="row buttonRow">
	<div class="row searchResult noBorder valign-middle">
		<div class="medium-12 columns textRight ">
			<a href="#" class="pinkButton clickAble" data-type="submit" data-url="confirmTeam">Confirm</a>
		</div>
	</div>
</div>
<script src="../js/cruk.js"></script>