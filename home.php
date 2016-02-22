<?php 
	include_once('inc/config.php');

	include_once('inc/header.php');
?>
			<div id="content" class="large-8 large-push-2 columns homeoverlay">
				<div class="callout panel" id="home1">
					<div class="image">
						<p>Our Beliefs</p>
						<div class="ourbeliefhome overlay hide clickAble" data-type="gourl" data-url="our-beliefs.php"><p>Find out about our beliefs here</p></div>
					</div>
				</div>
				<div class="medium-6 columns leftnp">
					<div class="callout panel" id="home2">
						<div class="image">
							<p>Nominate</p>
							<div class="nominatehome overlay hide clickAble" data-type="gourl" data-url="nominate"><p>Send an Our Heroes award</p></div>
						</div>
					</div>
				</div>
				<div class="medium-6 columns rightnp">
					<div class="callout panel" id="home3">
						<div class="image">
							<p>Wall of Fame</p>
							<div class="wofhome overlay hide clickAble" data-type="gourl" data-url="winners-wall"><p>Read all the recent Our Heroes awards</p></div>
						</div>
					</div>
				</div>
				<div class="medium-6 columns leftnp">
					<div>
						<div class="callout panel" id="home4">
							<div class="image">
								<p>Shop</p>
								<div class="shophome overlay hide clickAble" data-type="gourl" data-url="redeem"><p>If you've claimed a voucher, here's where you can use it!</p></div>
							</div>
						</div>
						<div class="callout panel" id="faq">
							<div class="image">
								<p>FAQs <i class="icon-icons_question"></i></p>
								<div class="faqhome overlay hide clickAble" data-type="gourl" data-url="faq.php"><p>Read all about the scheme here</p></div>
							</div>
						</div>
					</div>
				</div>
				<div class="medium-6 columns rightnp" id="home5">
					<div class="callout panel">
						<div class="image">
							<p>Passion Talks</p>
							<div class="passionhome overlay hide clickAble" data-type="gourl" data-url="https://crukip.cancerresearchuk.org/portal/server.pt/community/passion_talks/2530"><p>Watch the most recent Passion Talks here</p></div>
						</div>
					</div>
				</div>
			</div>
			<?php // print_r($_SESSION['user']); ?>
<?php
	include_once('inc/footer.php');
?>