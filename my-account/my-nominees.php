<?php
	$path="../";
	include_once($path.'inc/header.php');
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
					<div class="tableColumn-4">
						My Nominees
					</div>
					<div class="tableColumn-4">
						Date
					</div>
					<div class="tableColumn-4">
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
						<div class="tableColumn-4">
							<?=getName($list->NominatedEmpNum)?>
						</div>
						<div class="tableColumn-4">
							<?=getConvertedDate($list->NomDate)?>
						</div>
						<div class="tableColumn-6">
							<a href="#" data-url="view.php" data-id="<?=$list->ID?>">View</a>
						</div>
						<div class="tableColumn-3">
							<?php
							if($list->AprStatus == 0){
								echo '<div class="lightBlue">Pending <span class="smaller">('.getName($list->ApproverEmpNum).'</span>)</div>';
							} else {
								echo "Approved";
								if($list->amount != 0){
									echo " (".getName($list->ApproverEmpNum).")";
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
<?php include_once($path.'inc/footer.php'); ?>
