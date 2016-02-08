<?php
	include '../inc/config.php';
	if ($_GET['id']){
		if ($_GET['id'] == 'newteam'){
			unset($_SESSION['TeamMembers']);
			unset($_SESSION['teamid']);
		} else {
			$teamid = $_GET['id'];
			$_SESSION['TeamMembers'] =  getThisTeamMembers($teamid);
			$_SESSION['teamid'] = $teamid;
		}
	}
	//print_r($_SESSION['TeamMembers']);
	if ($_GET['removeMember']){
		//echo $_GET['removeMember'];
		removeTeamMember($_GET['removeMember']);
	}
?>

<div id="alertTitle" class="title smallPopupTitle">
	<div class="row withPadding">
		<div class="medium-12 columns">
			Find/Create Team
			<div class="small">
				Search for an existing team (e.g. 'Payroll') or for individual colleagues
			</div>
		</div>
		<div class="medium-12 columns">
			<div class="searchTeamInput">
				<form action="team-details.php" method="POST" name="searchTeam" id="searchTeam">
					<div class="small-9 medium-9 columns noPadding">
						<input type="text" name="searchTeamAuto" id="searchTeamAuto" value="" class="search" />
					</div>
					<div class="small-3 medium-3 columns noPadding">
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
			<input type="hidden" name="TeamMember" id="TeamMember" value="<?=$teamid?>">
				<?php
					if ($_GET['searchTeamAuto']){
						$search = $_GET['searchTeamAuto'];
						$searchUsers = new searchUsers($db);
						$searchList = $searchUsers->getAllTeamSearch($search);
						if (!$searchList){
							// if no team then do individual
							$searchList = $searchUsers->getAllSearch($search);
							if ($searchList){
								foreach ($searchList as $list){
				?>
					<div class="row searchResult valign-middle">
						<div class="small-1 medium-1 columns noPadding">
							<img src="<?=HTTP_PATH.$list->Photo?>" alt="" onerror="this.src='<?=HTTP_PATH?>images/no-photo.png'"/>
						</div>
						<div class="small-4 medium-4 columns">
							<?php echo $list->Fname.' '.$list->Sname; ?>
						</div>
						<div class="small-5 medium-5 columns">
							<?php echo $list->Team; ?>
						</div>
						<div class="small-1 medium-1 columns textRight">
							<div id="teamTick" class="circleTick inline smallTick clickAble" data-type="addTeam" data-id="<?php echo $list->EmpNum; ?>" data-url="team-details.php">
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
						} else {
							// do team
							if ($searchList){
								foreach ($searchList as $list){
				?>
					<div class="row searchResult valign-middle">
						<div class="small-10 medium-10 columns">
							<?php echo $list->Team; ?>
						</div>
						<div class="small-2 medium-2 columns textRight">
							<div id="teamTick" class="circleTick inline smallTick clickAble" data-type="addFullTeam" data-id="<?php echo $list->Team; ?>" data-url="team-details.php">
								<label for="teamTick"></label>
							</div>
						</div>
					</div>
				<?php
								}
							}
						}
					} else { ?>
					<div class="row searchResult valign-middle">
						<div class="medium-12 columns">
							<p>Use the search box above to find an existing team or add individuals to create a new team.</p>
						</div>
					</div>
				<?php } ?>
		</form>
	</div>
</div>
<div id="teamMembers" class="greyBox">
	<div class="row mCustomScrollbar height120 scrollBar" data-mcs-theme="dark-2">
		<div class="row withSidePadding">
			<div class="medium-12 columns noPadding">
				<div class="small">
					This team currently includes the following individuals. You can remove individuals using the <i class="icon-icons_close"></i>.
				</div>
			</div>
			<div class="medium-12 columns noPadding">
			<?php
			// add in current team members
			if ($_GET['TeamMember']){
				addTeamMember($_GET['TeamMember']);
			}
				//print_r($_SESSION['TeamMembers']);
			$x = 0 ;
			// add in current team members
			if ($_SESSION['TeamMembers']){
				foreach ($_SESSION['TeamMembers'] as $list){
					$x ++ ;
					if($x == 1){
			?>
				<div class="row withTopPadding">
					<div class="medium-5 columns noPadding">
						<?php echo getName($list['EmpNum']); ?>
					</div>
					<div class="medium-1 columns">
						<i class="icon-icons_close clickAble" data-type="removeTeamMember" data-id="<?php echo $list['EmpNum'] ?>" data-url="team-details.php"></i>
					</div>
			<?php	} else {?>
					<div class="medium-5 columns noPadding">
						<?php echo getName($list['EmpNum']); ?>
					</div>
					<div class="medium-1 columns">
						<i class="icon-icons_close clickAble" data-type="removeTeamMember" data-id="<?php echo $list['EmpNum'] ?>" data-url="team-details.php"></i>
					</div>
				</div>
			<?php	
						$x = 0 ; 
					}
				}
			}
			if($x == 1){
			?>
					<div class="medium-5 columns noPadding"></div>
					<div class="medium-1 columns"></div>
				</div>
			<?php
			}
			$count = count($_SESSION['TeamMembers']);
			?>
			</div>
		</div>
	</div>
</div>
<div id="alertTitle" class="row title smallPopupTitle">
	<div class="medium-12 columns">
		<div class="small">
			Enter an appropriate name for this team below. The team name will be visible on the Wall of Fame.
		</div>
	</div>
	<div class="medium-12 columns">
		<div class="TeamInputName">
			<form action="edit-team.php" method="POST" name="confirmTeam" id="confirmTeam">
				<input type="hidden" name="teamNO" id="teamNO" value="<?=$count?>" />
				<input type="hidden" name="teamid" id="teamid" value="<?=$_SESSION['teamid']?>" class="" />
				<input type="text" name="myTeamName" id="myTeamName" value="<?php echo getmyTeamName($_SESSION['teamid']) ?>" class="" />
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