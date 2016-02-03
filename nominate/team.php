<?php
	include_once('../inc/config.php');
	include_once('../inc/header.php');
	$myteam = $_GET['team'];
	if($myteam == ''){
		$myteam = 'myteam';
	}
?>

<div id="content" class="large-8 large-push-2 columns">
	<div class="title">
		<div class="inlineDiv clickAble" data-type="gourl" data-url="index.php">
			Nominate
		</div>
		<i class="icon-icons_thickrightarrow smalli"></i> <span class="subSubTitle">Team</span>
	</div>
	<div class="row">
		<div class="medium-12 columns leftnp rightnp">
			<div class="callout panel white contentFill">
				<div class="tableReports">
					<form action="team.php" method="post" name="myTeam" id="myTeam" >
						<div class="tableReportsHeadButton tableColumn-4">
							<div class="inlineDiv clickAble purpleButton " data-type="popup" data-url="team-details.php" data-id="newteam">
								Find/Create Team
							</div>
						</div>
						<div class="tableReportsHead tableColumn-2 clickAble <?php if ($myteam=='myteam') echo "white" ?>" data-type="gourl" data-url="<?=HTTP_PATH?>nominate/team.php?team=myteam">
							My Team
						</div>
						<?php // get list of work related
								$i= 0;
								$myTeams = getmyTeams($_SESSION['user']->EmpNum);
								foreach($myTeams as $list){ 
								$i ++;
							?>
						<div class="tableReportsHead tableColumn-2 clickAble <?php if ($myteam==$list->id) echo "white" ?>" data-type="gourl" data-url="<?=HTTP_PATH?>nominate/team.php?team=<?=$list->id;?>">
							<?=$list->myTeamName;?>
						</div>
						<?php  }
						// fix header. 
							echo fixMenuSpace($i);
						?>
					</form>
				</div>
				<form action="nominate-team.php" method="post" name="nominateTeam" id="nominateTeam">
					<input type="hidden" name="myTeamName" id="myTeamName" value="<?=$myteam?>">
					<div class="row mCustomScrollbar height490" data-mcs-theme="dark-2">
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
						<div class="medium-6 columns lightBlue italics">
							<?php echo $list->Team; ?>
						</div>
					</div>
				<?php
							}
						} ?>
					</div>
					<div id="buttonRow" class="row">
						<div class="medium-11 columns small paddingLeft">
							<?php if ($myteam == 'myteam'){ ?>
							This Team cannot be deleted.
							<?php } ?> 
							If you would like to remove anyone you may do so by selecting Edit Team and removing them.
						</div>
					</div>
					<div id="buttonRow" class="row buttonRow">
						<div class="row searchResult noBorder valign-middle">
							<div class="medium-3 columns">
							<?php if ($myteam != 'myteam'){ ?>
								<a href="#" class="blueButton clickAble" data-type="deleteTeam" data-url="nominateTeam">Delete Team</a>
							<?php } ?>
							</div>
							<div class="medium-3 columns">
								<a href="#" class="blueButton clickAble" data-type="popup" data-url="team-details.php" data-id="<?=$myteam?>">Edit Team</a>
							</div>
							<div class="medium-6 columns textRight ">
								<a href="#" class="pinkButton clickAble" data-type="submit" data-url="nominateTeam">Nominate Team</a>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php include_once('../inc/footer.php'); ?>
