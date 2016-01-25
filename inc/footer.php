		
			<div id="left-column" class="large-2 large-pull-8 columns">
				<div id="payoff" class="callout panel clickAble" data-type="gourl" data-url="<?=HTTP_PATH?>home.php">
					<span class="helper"></span>
					<img src="<?=HTTP_PATH?>images/our-heroes.svg" alt="Cancer Research UK" />
				</div>
				<div id="messages" class="callout panel">
					<div class="title">
						<i class="icon-icons_mail large"></i>
					</div>
					<?php 
						if( $_SESSION['user']->approver() =='YES'){
							$enpnum = $_SESSION['user'];
							if( function_exists( 'getTotalPendingNominations' ) ) {
								$count_awwards = getTotalPendingNominations($enpnum->EmpNum);
							}
							if(isset($count_awwards)):?>
								<div id='messageEmployee'>
									<i class="icon-icons_tickinbox"></i> <span class="right"><?=date("l m/d")?></span>
									<div class="clickAble" data-type="gourl" data-url="<?=HTTP_PATH?>approvals">You have a <? echo $count_awwards; ?> awards to aprove</div>
								</div>
						<?php endif ;
							?>
					<div id="messageList" class="row mCustomScrollbar height217" data-mcs-theme="dark-2">
					<?php
						} else { ?>
					<div id="messageList" class="row mCustomScrollbar height306" data-mcs-theme="dark-2">
					<?php }
								$query = getMyMessages($_SESSION['user']->EmpNum );
								if($query != 0):?>
							<?php foreach($query as $mess):?>
								<div class="row">
									<i class="icon-icons_bubble"></i><span class="right"><?=date("l m/d", strtotime($mess["date"]))?></span>
									<p class="text"> <?php echo  $mess["text"]?></p>
								</div>
							<?php endforeach; ?>
							<?php endif;
					?>
					</div>
				</div>
				<div id="awards" class="callout panel">
					<div class="title">
						<!-- <i class="icon-icons_trophy"></i> -->
						Most Recent Awards
					</div>
					<div id="awardList" class="mCustomScrollbar height163" data-mcs-theme="dark-2">
					<?php
						$res = getEmployeFnameAndSname();
						if( $res != 0 ){
							foreach ($res as $key => $value){
						?>
						<div class="row">
							<div class="medium-2 columns">
								<i class="icon-icons_person"></i>
							</div>
							<div class="medium-10 columns">
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