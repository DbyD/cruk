<?php
	include_once('../inc/config.php');
	include_once('../inc/header.php');
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
					<div class="tableColumn-3">
						Nominated by
					</div>
					<div class="tableColumn-3">
						Date
					</div>
					<div class="tableColumn-3">
						Certificate
					</div>
					<div class="tableColumn-2">
						A Little Extra
					</div>
					<div class="tableColumn-0">
						<!--<i class="icon-icons_person"></i>/--><i class="icon-icons_group"></i>
					</div>
				</div>
				<div class="row mCustomScrollbar height555" data-mcs-theme="dark-2">
					<?php 
					// Get List for My Awards
					$nomList = getAllMyNominationsList($_SESSION['user']->EmpNum);
					foreach ($nomList as $list){
					?>
					<div class="tableRow">
						<div class="tableColumn-3">
						<?php
							if ($list->Volunteer != '') {
								echo $list->Volunteer;
							} else {
								echo getName($list->NominatorEmpNum);
							}
						?>
						</div>
						<div class="tableColumn-3">
							<?=getConvertedDate($list->AprDate)?>
						</div>
						<div class="tableColumn-3">
						<?php if($list->nomination_teamID != ''){ ?>
							<div class="viewButton inlineDiv clickAble lightBlue" data-type="ecard" data-url="<?=HTTP_PATH?>alerts/view-team-ecard.php" data-id="<?=$list->nomination_teamID?>">View</div>
						<?php } else { ?>
							<div class="viewButton inlineDiv clickAble lightBlue" data-type="ecard" data-url="<?=HTTP_PATH?>alerts/view-ecard.php" data-id="<?=$list->ID?>">View</div>
						<?php } ?>
						</div>
						<div class="tableColumn-2">
							<?php
							if($list->littleExtra == 'Yes'){
								if($list->AwardClaimed == 'No'){
								?>
									<a href="#" data-type="popup" data-id="<?=$list->ID?>" class="clickAble pinkButton" data-url="<?=HTTP_PATH?>my-account/claim-award.php">Claim</a>
								<?php
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
						<div class="tableColumn-0">
						<?php if($list->nomination_teamID != ''){ ?>
							<i class="icon-icons_group"></i>
						<?php } else { ?>
							<!--<i class="icon-icons_person"></i>-->
						<?php } ?>
						</div>
					</div>
					<?php	} ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include_once('../inc/footer.php'); ?>
