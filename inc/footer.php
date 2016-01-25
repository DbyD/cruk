		
			<div id="left-column" class="large-2 large-pull-8 columns">
				<div id="payoff" class="callout panel">
					<span class="helper"></span>
					<img src="<?=HTTP_PATH?>images/our-heroes.svg" alt="Cancer Research UK" />
				</div>
				<div id="messages" class="callout panel">
					<div class="title">
						<i class="icon-icons_mail large"></i>

					</div>
					<?php 

							if( isset( $_SESSION['user'] ) ){

								$enpnum = $_SESSION['user'];

								if( function_exists( 'getTotalPendingNominations' ) ) {
									$count_awwards = getTotalPendingNominations($enpnum->EmpNum );
								}

								if(isset($count_awwards)):?>
									<div id='messageEmploye'>
										<p><i class="fi-checkbox size-24"></i> <span class="right">Monday 09/11</span></span>
										<p>You have a <? echo $count_awwards; ?> awwards to aprove</p>
									</div>
								<?php endif ;
							}

						?>
					<div id="messages"> 
						
						<?php
							if(isset($enpnum)){
								if( function_exists( 'getTotalPendingNominations' ) ) {
									$query = getMyMessages( $enpnum->EmpNum );
									if(count($query) > 0):?>
									<ul>
										<?php foreach($query as $mess):?>
											<li>
												<p><i class="fi-comment"></i></p>
												<p class="text"> <?php echo  $mess["text"]?></p>
											</li>
										<?php endforeach; ?>
									<ul>
									<?php endif;
								}
							}
						?>
					</div>
				</div>
				<div id="awards" class="callout panel">
					<div class="title">
						<!-- <i class="icon-icons_trophy"></i> -->
						Most Recent Awards
					</div>
					<div>
						<?php
							if(isset($enpnum)){
								if(function_exists( 'getEmployeFnameAndSname' )){
									$res = getEmployeFnameAndSname();

									if( $res != 0 ):?>
									<ul id="listNominators">
										<?php 
										foreach ($res as $key => $value):?>
											<li>
												<i class="fi-torso-business size-24"></i>
												<i>Individual</i>
												<p><?php echo $value['name']; ?></p>
											</li>

								  <?php endforeach; ?>
									</ul>
									<?php endif;
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