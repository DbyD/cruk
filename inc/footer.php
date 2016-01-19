		
			<div id="left-column" class="large-2 large-pull-8 columns">
				<div id="payoff" class="callout panel">
					<span class="helper"></span>
					<img src="<?=HTTP_PATH?>images/our-heroes.svg" alt="Cancer Research UK" />
				</div>
				<div id="messages" class="callout panel">
					<div class="title">
						<i class="icon-icons_mail"></i>
					</div>
					<div>
						messages
					</div>
				</div>
				<div id="awards" class="callout panel">
					<div class="title">
						<i class="icon-icons_trophy"></i>
					</div>
					<div>
						awards
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