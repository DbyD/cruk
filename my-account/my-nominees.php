<?php
	include_once('../inc/config.php');
	include_once('../inc/header.php');
?>

<div id="content" class="large-8 large-push-2 columns MyAccount">
	<div class="title withStar">
		<div class="inlineDiv clickAble" data-type="gourl" data-url="index.php">My Account</div> <i class="icon-icons_thickrightarrow smalli"></i> <span class="subSubTitle">My Nominees</span>
		<div class="awardStar">
			<i class="icon-icons_star"></i><span><?php echo getTotalNominations($_SESSION['user']->EmpNum) ?></span>
		</div>
	</div>
	<div class="row contentFill">
		<div class="medium-12 columns leftnp rightnp fillHeight">
			<div class="callout panel fillHeight white">
				<div class="tableTitle">
					<div class="tableColumn-3">
						My Nominees
					</div>
					<div class="tableColumn-3">
						Date
					</div>
					<div class="tableColumn-2">
						Award
					</div>
					<div class="tableColumn-4">
						Status
					</div>
				</div>
				<div class="row mCustomScrollbar height555" data-mcs-theme="dark-2">
				<?php 
					// Get List for My nominations
					$nomUsers = new NominationsList($db);
					$nomList = $nomUsers->getAllNominationsList($_SESSION['user']->EmpNum);
					foreach ($nomList as $list){
					?>
					<div class="tableRow">
						<div class="tableColumn-3">
							<?=getName($list->NominatedEmpNum)?>
						</div>
						<div class="tableColumn-3">
							<?=getConvertedDate($list->NomDate)?>
						</div>
						<div class="tableColumn-2">
							<div class="viewButton inlineDiv clickAble" data-type="ecard" data-url="<?=HTTP_PATH?>alerts/view-ecard.php" data-id="<?=$list->ID?>">View</div>
						</div>
						<div class="tableColumn-4">
							<?php
							if($list->AprStatus == 0){
								echo '<div class="lightBlue">Pending <span class="smaller">('.getName($list->ApproverEmpNum).'</span>)</div>';
							} else {
								if($list->amount != 0){
									echo "Approved (".getName($list->ApproverEmpNum).")";
								} else {
									echo '-';
								}
							}
						?>
						</div>
					</div>
				<?php	} ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include_once('../inc/footer.php'); ?>
