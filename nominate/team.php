<?php
	include_once('../inc/config.php');
	include_once('../inc/header.php');
	$myteam = $_GET['team'];
	if($myteam == ''){
		$myteam = 'myteam';
	}
	unset($_SESSION['teamnominee']);
	unset($_SESSION['TeamMembers']);
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
							<div id="newTeamButton" class="inlineDiv clickAble purpleButton " data-type="popup" data-url="team-details.php" data-id="newteam" data-count="1">
								Find/Create Team
							</div>
						</div>
						<div class="tableReportsHead tableColumn-2 clickAble <?php if ($myteam=='myteam') echo "white" ?>" data-type="gourl" data-url="<?=HTTP_PATH?>nominate/team.php?team=myteam">
							My Team
						</div>
						<?php // get list of work related
								$i= 1;
								$myTeams = getmyTeams($_SESSION['user']->EmpNum);
								foreach($myTeams as $list){ 
								$i ++;
							?>
						<div class="tableReportsHead tableColumn-2 clickAble <?php if ($myteam==$list->id) echo "white" ?>" data-type="gourl" data-url="<?=HTTP_PATH?>nominate/team.php?team=<?=$list->id;?>">
							<?php echo shortenName($list->myTeamName);?>
						</div>
						<?php  }
						// fix header. 
							echo fixMenuSpace($i);
						?>
					</form>
				</div>
				<form action="nominate-team.php" method="post" name="nominateTeam" id="nominateTeam">
					<input type="hidden" name="myTeamName" id="myTeamName" value="<?=$myteam?>">
					<div class="row mCustomScrollbar height480" data-mcs-theme="dark-2">
					<?php
						$searchList = getAllTeamsMembers($myteam);
						//echo count($searchList);
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
						<div class="medium-6 columns italics">
						<?php 
							if($list->Shop != ''){
								echo $list->Shop; 
							} else {
								if($list->RetailArea != ''){
									echo $list->RetailArea; 
								} else {
									if($list->Team != ''){
										echo $list->Team; 
									} else {
										if($list->Section != ''){
											echo $list->Section; 
										} else {
											if($list->Department != ''){
												echo $list->Department; 
											}
										}
									}
								}
							}
						?>
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
							If you would like to add or remove anyone you may do so by selecting Edit Team. Once you modify this team you will have to save it with a new name.
						</div>
					</div>
					<div id="buttonRow" class="row buttonRow">
						<div class="row searchResult noBorder valign-middle">
							<div class="medium-3 columns">
							<?php if ($myteam != 'myteam'){ ?>
								<a href="#" class="blueButton clickAble" data-type="popup" data-url="alert-delete-team.php" data-id="<?=$myteam?>">Delete Team</a>
							<?php } ?>
							</div>
							<div class="medium-3 columns">
								<a href="#" class="blueButton clickAble" data-type="popup" data-url="team-details.php" data-id="<?=$myteam?>">Edit Team</a>
							</div>
							<div class="medium-6 columns textRight mobileButtonFix">
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
<script>
$("#newTeamButton" ).attr( 'data-count', '<?=$i?>' );
</script>
