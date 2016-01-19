<?php
	$path="../";
	include_once($path.'inc/header.php');
?>

<div id="content" class="large-8 large-push-2 columns MyAccount">
	<div class="title withStar">
		<div class="inlineDiv clickAble purpleButton right" data-type="popup" data-url="<?=HTTP_PATH?>my-account/my-award-details.php" data-id="3">View Details</div>
		<div class="inlineDiv clickAble" data-type="gourl" data-url="index.php">My Account</div> <i class="icon-icons_thickrightarrow smalli"></i> <span class="subSubTitle">My Awards</span>
		<div class="awardStar">
			<i class="icon-icons_star"></i><span><?php echo getTotalAwards($_SESSION['user']->EmpNum) ?></span>
		</div>
	</div>
	<div class="row contentFill">
		<div class="medium-12 columns leftnp rightnp fillHeight">
			<div class="callout panel fillHeight white">
				<div class="tableTitle">
					<div class="tableColumn-4">
						Nominated by
					</div>
					<div class="tableColumn-4">
						Date
					</div>
					<div class="tableColumn-4">
						Certificate
					</div>
					<div class="tableColumn-4">
						A Little Extra
					</div>
				</div>
				<div class="row mCustomScrollbar height555" data-mcs-theme="dark-2">
					<?php 
					// Get List for My Awards
					$nomUsers = new MyNominationsList($db);
					$nomList = $nomUsers->getAllMyNominationsList($_SESSION['user']->EmpNum);
					foreach ($nomList as $list){
					?>
					<div class="tableRow">
						<div class="tableColumn-4">
							<?=getName($list->NominatorEmpNum)?>
						</div>
						<div class="tableColumn-4">
							<?=getConvertedDate($list->NomDate)?>
						</div>
						<div class="tableColumn-4">
							<a href="#" data-url="view.php" data-id="<?=$list->ID?>">View</a>
						</div>
						<div class="tableColumn-4">
							<?php
							if($list->littleExtra == 'Yes'){
								if($list->AwardClaimed == 'No'){
									echo '<a href="#" data-type="popup" data-id="'.$list->ID.'" class="clickAble pinkButton">Claim</a>';
								} else {
									if($list->amount == '20'){
										echo '£20 voucher';
									} else {
										echo $list->amount;
									}
								}
							} else {
								echo "-";
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
