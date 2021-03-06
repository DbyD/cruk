			<div id="left-column" class="large-2 large-pull-8 columns">
				<div id="payoff" class="callout panel clickAble" data-type="gourl" data-url="<?=HTTP_PATH?>home.php">
					<span class="helper"></span>
					<img src="<?=HTTP_PATH?>images/our-heroes.svg" alt="Cancer Research UK" />
				</div>
				<div id="messages" class="callout panel">
					<div class="title">
						Messages
					</div>
					<?php 
							
							if( function_exists( 'getTotalPendingNominations' ) ) {
								$count_nomination = getTotalPendingNominations($_SESSION['user']->EmpNum);
							}
							
							if( function_exists( 'getTotalNewNominations' ) ) {
								$count_newAwards = getTotalNewNominations($_SESSION['user']->EmpNum);
							}

							if($count_nomination > 0 || $count_newAwards > 0){
					?>
						<div id='messageEmployee'>
							<i class="icon-icons_tickinbox"></i> <span class="right"><?=date("l d/m/y")?></span>
							<?php if($count_nomination > 0){?>
								<div class="clickAble" data-type="gourl" data-url="<?=HTTP_PATH?>approvals/pending.php">You have a <? echo $count_nomination; ?> award<?php if($count_nomination>1) echo "s"; ?> to approve</div>
							<?php } ?>
							<?php if($count_newAwards > 0){?>
								<div class="clickAble" data-type="gourl" data-url="<?=HTTP_PATH?>my-account/my-awards.php">You have <? echo $count_newAwards; ?> new award<?php if($count_newAwards>1) echo "s"; ?></div>
							<?php } ?>
						</div>
					<?php if($count_nomination > 0 && $count_newAwards > 0){ ?>
					<div id="messageList" class="row mCustomScrollbar height233" data-mcs-theme="dark-2">
					<?php } else { ?>
					<div id="messageList" class="row mCustomScrollbar height252" data-mcs-theme="dark-2">
					<?php }
							} else { ?>
							
					<div id="messageList" class="row mCustomScrollbar height306" data-mcs-theme="dark-2">
					<?php	}
							$query = getMyMessages($_SESSION['user']->EmpNum);
							if($query != 0){
								foreach($query as $mess){?>
								<div class="row">
									<?php if($mess["award"]=='m'){ ?>
									<i class="icon-icons_mail"></i>
									<?php } else { ?>
									<i class="icon-icons_star"></i>
									<?php } ?>
									<span class="right"><?=date("l d/m/y", strtotime($mess["date"]))?></span>
									<p class="text"> <?php echo fixText($mess["text"]); ?></p>
								</div>
						<?php }
							}?>
							<div class="row">
								<i class="icon-icons_mail"></i><span class="right"><?=date("l d/m/y")?></span>
								<p class="text">Welcome to the Our Heroes portal where you can nominate colleagues in recognition of their contribution to Cancer Research.</p>
							</div>
							<div class="row">
								<i class="icon-icons_mail"></i><span class="right"><?=date("l d/m/y")?></span>
								<p class="text">Click on the FAQs link to the right to find out more about using this site.</p>
							</div>
					</div>
				</div>
				<div id="awards" class="callout panel">
					<div class="title">
						<!-- <i class="icon-icons_trophy"></i> -->
						Most Recent <?=$_SESSION['user']->DirectorateInitials?> Awards
					</div>
					<div id="awardList" class="mCustomScrollbar height158" data-mcs-theme="dark-2">
					<?php
						$res = getMostRecentAwards();
						if( $res != 0 ){
							foreach ($res as $key => $value){
								if($value['Type'] == 'Team'){
						?>
						<div class="row">
							<div class="small-2 medium-2 columns">
								<i class="icon-icons_group"></i>
							</div>
							<div class="small-10 medium-10 columns">
									<?php  
									$TeamMembers = getThisTeamMembers($value['ID']);
									//print_r($TeamMembers);
									foreach ($TeamMembers as $list){
										echo getName($list['EmpNum']).'<br>';
									}
								?>
								<p><?php echo $value['BeliefID']; ?></p>
							</div>
						</div>
						<?php 	} else { ?>
						<div class="row">
							<div class="small-2 medium-2 columns">
								<i class="icon-icons_person"></i>
							</div>
							<div class="small-10 medium-10 columns">
								<?php echo $value['name'].' '.$value['sname']; ?>
								<p><?php echo $value['BeliefID']; ?></p>
							</div>
						</div>
					<?php		}	
							}
						}
					?>
					</div>
				</div>
			</div>
			<div id="right-column"  class="large-2 columns">
				<div id="portfolio" class="callout panel">
					<?php include 'portfolio.php'; ?>
				</div>
				<div id="mainmenu" class="callout panel">
					<ul>
						<?php include 'menu.php'; ?>
					</ul>
				</div>
			</div>
		</section>
		<a class="exit-off-canvas"></a>
		<section class="copyright">
			&copy; Xexec 2016
		</section>
	</div>
</div>
<script src="<?=HTTP_PATH?>js/vendor/jquery.js"></script>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="<?=HTTP_PATH?>js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?=HTTP_PATH?>js/jquery.validate.min.js"></script>
<script src="<?=HTTP_PATH?>js/foundation.min.js"></script>
<script src="<?=HTTP_PATH?>js/cruk.js"></script>
<script src="<?=HTTP_PATH?>js/redeem.js"></script>
<script>
  $(function() {
    $( "#datepickerfrom" ).datepicker({
      showOn: "button",
      buttonImage: "../images/calendar.gif",
      buttonImageOnly: true,
      buttonText: "Select date"
    });
    $( "#datepickerto" ).datepicker({
      showOn: "button",
      buttonImage: "../images/calendar.gif",
      buttonImageOnly: true,
      buttonText: "Select date"
    });
  });
</script>
</body>
</html>