		
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
							$enpnum = $_SESSION['user'];
							if( function_exists( 'getTotalPendingNominations' ) ) {
								$count_nomination = getTotalPendingNominations($enpnum->EmpNum);
							}
							if( function_exists( 'getTotalNewNominations' ) ) {
								$count_newAwards = getTotalNewNominations($enpnum->EmpNum);
							}
							if($count_nomination > 0 || $count_newAwards > 0){
					?>
						<div id='messageEmployee'>
							<i class="icon-icons_tickinbox"></i> <span class="right"><?=date("l d/m/y")?></span>
							<?php if($count_nomination > 0){?>
								<div class="clickAble" data-type="gourl" data-url="<?=HTTP_PATH?>approvals/pending.php">You have a <? echo $count_nomination; ?> award<?php if($count_nomination>1) echo "s"; ?> to aprove</div>
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
							$query = getMyMessages($_SESSION['user']->EmpNum,$_SESSION['user']->Department);
							if($query != 0){
								foreach($query as $mess){?>
								<div class="row">
									<?php if($mess["award"]=='m'){ ?>
									<i class="icon-icons_mail"></i>
									<?php } else { ?>
									<i class="icon-icons_star"></i>
									<?php } ?>
									<span class="right"><?=date("l d/m/y", strtotime($mess["date"]))?></span>
									<p class="text"> <?php echo $mess["text"]; ?></p>
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
						Most Recent Awards
					</div>
					<div id="awardList" class="mCustomScrollbar height158" data-mcs-theme="dark-2">
					<?php
						$res = getEmployeFnameAndSname();
						if( $res != 0 ){
							foreach ($res as $key => $value){
						?>
						<div class="row">
							<div class="small-2 medium-2 columns">
								<i class="icon-icons_person"></i>
							</div>
							<div class="small-2 medium-10 columns">
								Individual
								<p><?php echo $value['name'].' '.$value['sname']; ?></p>
							</div>
						</div>
					<?php	}
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
	</div>
</div>
<script src="<?=HTTP_PATH?>js/vendor/jquery.js"></script>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="<?=HTTP_PATH?>js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?=HTTP_PATH?>js/jquery.validate.min.js"></script>
<script src="<?=HTTP_PATH?>js/foundation.min.js"></script>
<script src="<?=HTTP_PATH?>js/cruk.js"></script>
</body>
</html>