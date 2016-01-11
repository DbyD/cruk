<?php
	$path="../";
	include_once($path.'inc/header.php');
?>
			<div id="content" class="large-8 large-push-2 columns MyAccount">
				<div class="title withStar">
					<a href="#" data-type="popup" data-url="<?=$path?>alerts/my-award-details.php" data-id="3" class="clickAble purpleButton right">View Details</a>
					My Account <i class="icon-icons_thickrightarrow smalli"></i> <span class="subTitle">My Awards</span> 
					<div class="awardStar"><i class="icon-icons_star"></i><span>3</span></div>
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
							<?php // Get List for My Awards ?>
							<div class="tableRow">
								<div class="tableColumn-4">
									Jamie King
								</div>
								<div class="tableColumn-4">
									23 November 2015
								</div>
								<div class="tableColumn-4">
									<a href="#" data-url="view.php">View</a>
								</div>
								<div class="tableColumn-4">
									&pound;20 Voucher
								</div>
							</div>
							<div class="tableRow">
								<div class="tableColumn-4">
									Robert Jones
								</div>
								<div class="tableColumn-4">
									29 November 2015
								</div>
								<div class="tableColumn-4">
									<a href="#" data-url="view.php">View</a>
								</div>
								<div class="tableColumn-4">
									Go home early
								</div>
							</div>
							<div class="tableRow">
								<div class="tableColumn-4">
									Graham Fortune
								</div>
								<div class="tableColumn-4">
									3 December 2015
								</div>
								<div class="tableColumn-4">
									<a href="#" data-type="popup" data-id="3" data-url="view.php">View</a>
								</div>
								<div class="tableColumn-4">
									<a href="#" data-type="popup" data-id="3" class="clickAble pinkButton">Claim</a>
								</div>
							</div>
							<?php // end List for My Awards ?>
						</div>
					</div>
				</div>
			</div>
<?php include_once($path.'inc/footer.php'); ?>