<?php
	$path="../";
	include_once($path.'inc/header.php');
?>

<div id="content" class="large-8 large-push-2 columns">
	<div class="title">
		Nominate <i class="icon-icons_thickrightarrow smalli"></i> <span class="subSubTitle">Colleague</span>
	</div>
	<div class="row">
		<div class="callout panel white contentFill">
			<div class="row ">
				<div class="title searchInput">
					<form action="colleague.php" method="GET" name="searchColleague" id="searchColleague">
						<div class="medium-5 columns">&nbsp;</div>
						<div class="medium-5 columns">
							<input type="text" name="search" id="searchAuto" value="" class="search" />
						</div>
						<div class="medium-2 columns">
							<a href="#" class="purpleButton clickAble" data-type="submit" data-url="searchColleague">Search</a>
						</div>
					</form>
				</div>
			</div>
			<form action="nominate-colleague.php" method="post" name="nominateColleague" id="nominateColleague">
				<div class="row mCustomScrollbar height515" data-mcs-theme="dark-2">
				<?php
					if ($_GET['search']){
						$search = $_GET['search'];
						$searchUsers = new searchUsers($db);
						$searchList = $searchUsers->getAllSearch($search);
						$x = 0 ;
						if ($searchList->rowCount()>0){
							foreach ($searchList as $list){
								$x = $x + 1 ;
				?>
					<div class="row searchResult valign-middle">
						<div class="medium-2 columns">
							<img src="<?=$list['Photo']?>" alt="" onerror="this.src='<?=$path?>images/no-photo.png'"/>
						</div>
						<div class="medium-4 columns">
							<?php echo $list['Fname'].' '.$list['Sname']; ?>
						</div>
						<div class="medium-5 columns">
							<?php echo $list['Team']; ?>
						</div>
						<div class="medium-1 columns">
							<div class="hiddenTick">
								<input type="radio" value="<?=$list['EmpNum']?>" name="EmpNum" id="EmpNum<?=$x?>" required>
								<label for="EmpNum<?=$x?>"></label>
							</div>
						</div>
					</div>
				<?php
							}
						} else {
							echo "sorry no results";
						}
					}
					?>
				</div>
				<div class="row buttonRow">
					<div class="row searchResult noBorder valign-middle">
						<div class="medium-12 columns textRight ">
							<a href="#" class="pinkButton clickAble" data-type="submit" data-url="nominateColleague">Nominate Individual</a>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
	include_once($path.'inc/footer.php');
?>
