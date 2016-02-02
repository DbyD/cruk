<?php
	include_once('../inc/config.php');
	include_once('../inc/header.php');
	$myteam = $_GET['team'];
?>

<div id="content" class="large-8 large-push-2 columns">
	<div class="title">
		<div class="inlineDiv clickAble" data-type="gourl" data-url="index.php">
			Nominate
		</div>
		<i class="icon-icons_thickrightarrow smalli"></i> <span class="subSubTitle">Team</span>
	</div>
	<div class="row contentFill">
		<div class="medium-12 columns leftnp rightnp">
			<div class="callout panel white">
				<div class="tableReports">
					<form action="team.php" method="post" name="myTeam" id="myTeam" >
						<div class="tableReportsHeadButton tableColumn-4">
							<div class="inlineDiv clickAble purpleButton " data-type="popup" data-url="<?=HTTP_PATH?>nominate/team-details.php" data-id="3">
								Find/Create Team
							</div>
						</div>
						<?php // get list of work related
								$i= 0;
								$myTeams = getmyTeams($_SESSION['user']->EmpNum);
								foreach($myTeams as $list){ 
								$i ++;
							?>
						<div class="tableReportsHead tableColumn-2 clickAble <?php if ($myteam==$list->id) echo "white" ?>" data-type="gourl" data-url="<?=HTTP_PATH?>nominate/team.php?team=<?=$list->id;?>">
							<?=$list->TeamName;?>
						</div>
						<?php  }
						// fix header. 
							echo fixMenuSpace($i);
						?>
					</form>
				</div>
				<?php
					if ($myteam){ ?>
				<form action="nominate-team.php" method="post" name="nominateTeam" id="nominateTeam">
					<input type="hidden" name="formName" value="nominateTeam">
					<div class="row mCustomScrollbar height515" data-mcs-theme="dark-2">
					<?php	$searchList = getAllTeamsMembers($myteam);
						if ($searchList){
							foreach ($searchList as $list){
				?>
					<div class="row searchResult valign-middle">
						<div class="medium-2 columns">
							<img src="<?=HTTP_PATH.$list->Photo?>" alt="" onerror="this.src='<?=HTTP_PATH?>images/no-photo.png'"/>
						</div>
						<div class="medium-4 columns">
							<?php echo $list->Fname.' '.$list->Sname; ?>
						</div>
						<div class="medium-6 columns">
							<?php echo $list->Team; ?>
						</div>
					</div>
				<?php
							}
						} ?>
					</div>
					<div id="buttonRow" class="row buttonRow">
						<div class="row searchResult noBorder valign-middle">
							<div class="medium-3 columns">
								<a href="#" class="blueButton clickAble" data-type="submit" data-url="nominateTeam">Delete Team</a>
							</div>
							<div class="medium-3 columns">
								<a href="#" class="blueButton clickAble" data-type="popup" data-url="nominateTeam">Edit Team</a>
							</div>
							<div class="medium-6 columns textRight ">
								<a href="#" class="pinkButton clickAble" data-type="submit" data-url="nominateTeam">Nominate Team</a>
							</div>
						</div>
					</div>
				</form>
				<?php	} else { ?>
					<div class="row searchResult height555">
						<div class="medium-12 columns">
							<p>Please select the team you would like to nominate. If you have not created a team yet, then click the Find/Create Team button to create your team.</p>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php include_once('../inc/footer.php'); ?>
