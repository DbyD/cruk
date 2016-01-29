<?php include_once('../inc/header.php'); ?>

<div id="content" class="large-8 large-push-2 columns">
	<div class="title">
		<div class="inlineDiv clickAble" data-type="gourl" data-url="index.php">
			Admin
		</div>
		<i class="icon-icons_thickrightarrow smalli"></i> <span class="subSubTitle">Staff Data</span>
	</div>
	<div class="row contentFill">
		<div class="callout panel white contentFill">
			<div class="row ">
				<div class="title searchInput">
					<form action="staff-search.php" method="GET" name="searchColleague" id="searchColleague">
						<div class="medium-10 columns">
							<input type="text" name="searchAuto" id="searchAuto" value="" class="search" />
						</div>
						<div class="medium-2 columns">
							<a href="#" class="purpleButton clickAble" data-type="submit" data-url="searchColleague">Search</a>
						</div>
					</form>
				</div>
			</div>
			<form action="staff-edit.php" method="post" name="editStaff" id="editStaff">
				<input type="hidden" name="formName" value="editStaff">
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
							<img src="<?=$list->Photo?>" alt="" onerror="this.src='<?=HTTP_PATH?>images/no-photo.png'"/>
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
					}
					?>
				</div>
				<div id="buttonRow" class="row buttonRow hidden">
					<div class="row searchResult noBorder valign-middle">
						<div class="medium-12 columns textRight ">
							<a href="#" class="pinkButton clickAble" data-type="submit" data-url="editStaff">Select Employee</a>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
	include_once('../inc/footer.php');
	if ($_GET['searchAuto']){
?>
<script>$('#buttonRow').removeClass('hidden'); </script>
<?php } ?>