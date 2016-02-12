<?php 
	include_once('inc/config.php');

	include_once('inc/header.php');
?>
			<div id="content" class="large-8 large-push-2 columns">
				<div class="callout panel" id="home1">
					<div class="image">
						<p>Our Beliefs</p>
						<div class="ourbelief hide clickAble" data-type="gourl" data-url="our-beliefs.php">Click here to read all out the Cancer Research Beliefs.</div>
					</div>
				</div>
				<div class="medium-6 columns leftnp">
					<div class="callout panel clickAble" id="home2" data-type="gourl" data-url="nominate">
						<div class="image">
							<p>Nominate</p>
						</div>
					</div>
				</div>
				<div class="medium-6 columns rightnp">
					<div class="callout panel clickAble" id="home3" data-type="gourl" data-url="winners-wall">
						<div class="image">
							<p>Wall of Fame</p>
						</div>
					</div>
				</div>
				<div class="medium-6 columns leftnp">
					<div>
						<div class="callout panel clickAble" data-type="gourl" data-url="redeem" id="home4">
							<div class="image">
								<p>Redeem</p>
							</div>
						</div>
						<div class="callout panel faq clickAble" data-type="gourl" data-url="faq.php">
							<p>FAQs <i class="icon-icons_question"></i></p>
						</div>
					</div>
				</div>
				<div class="medium-6 columns rightnp">
					<div class="callout panel clickAble" id="home5" data-type="gourl" data-url="https://crukip.cancerresearchuk.org/portal/server.pt/community/passion_talks/2530">
						<div class="image">
							<p>Passion Talks</p>
						</div>
					</div>
				</div>
			</div>
			<?php // print_r($_SESSION['user']); ?>
<?php
	include_once('inc/footer.php');
?>