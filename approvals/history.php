<?php
	include_once('../inc/config.php');
	include_once('../inc/header.php');
	unset($_SESSION['alreadydone']);
?>

<div id="content" class="large-8 large-push-2 columns MyAccount">
	<div class="title withStar">
		<div class="inlineDiv clickAble" data-type="gourl" data-url="index.php">Approvals</div> <i class="icon-icons_thickrightarrow smalli"></i> <span class="subSubTitle">History</span>
	</div>
	<div class="row contentFill">
		<div id="approvalHistory" class="medium-12 columns leftnp rightnp fillHeight">
			<div class="callout panel fillHeight white">
				<div class="tableTitle doubleHeader">
					<div class="tableColumn-2">
						Nominee
					</div>
					<div class="tableColumn-2">
						Nominated by
					</div>
					<div class="tableColumn-2">
						Nomination Date
					</div>
					<div class="tableColumn-1 twoLines">
						Reason/ Message
					</div>
					<div class="tableColumn-2">
						Status
					</div>
					<div class="tableColumn-2 twoLines">
						Approval/ Decline  Date
					</div>
				</div>
				<div class="row mCustomScrollbar height555" data-mcs-theme="dark-2">
					<?php 
					// Get List for My Awards
					$nomList = getAllMyApprovalsHistory($_SESSION['user']->EmpNum);
					foreach ($nomList as $list){
					?>
					<div class="tableRow">
						<div class="tableColumn-2">
						<?php if($list->Team == ''){ 
							echo getName($list->NominatedEmpNum);
						} else {
							echo $list->Team;
						}?>
						</div>
						<div class="tableColumn-2">
						<?php
						if ($list->Volunteer != '') {
							echo $list->Volunteer;
						} else {
							echo getName($list->NominatorEmpNum);
						}
						?>
						</div>
						<div class="tableColumn-2">
							<?=getConvertedShortDate($list->NomDate)?>
						</div>
						<div class="tableColumn-1">
						<?php if($list->teamID == ''){ ?>
								<div class="viewButton inlineDiv clickAble lightBlue" data-type="popup" data-url="<?=HTTP_PATH?>approvals/view-reason-message.php" data-id="<?=$list->ID?>">View</div>
						<?php } else { ?>
								<div class="viewButton inlineDiv clickAble lightBlue" data-type="popup" data-url="<?=HTTP_PATH?>approvals/view-team-reason-message.php" data-id="<?=$list->ID?>">View</div>
						<?php } ?>
						</div>
						<div class="tableColumn-2">
						<?php	if($list->AprStatus == 1){
									echo "Approved";
								} else {
									echo "Declined";
								} ?>
						</div>
						<div class="tableColumn-2">
							<?=getConvertedShortDate($list->AprDate)?>
						</div>
					</div>
					<?php	} ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include_once('../inc/footer.php'); ?>
