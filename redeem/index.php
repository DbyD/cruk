<?php 
include_once '../inc/config.php';
include_once('../inc/header.php'); 

$val = $_SESSION['user']->administrator;
$basket = getBasket( $_SESSION["user"]->EmpNum );
if(count($basket) > 0 && is_array($basket)){
	$basket_isset = true;
} else {
	$basket = array();
	$basket_isset = false;
}
?>
	
			<div id="content" class="large-8 large-push-2 columns">
				<div class="title withStar">
					Shop
				</div>
				<div class="row contentFill">
					<div class="medium-12 columns leftnp rightnp fillHeight">
						<?php if(is_array($basket)):?>
						<div class="row">
							<a id="viewBasket" class='<?php if($basket_isset) echo 'view-basket';?>' href="<?php echo HTTP_PATH . "redeem/product-basket.php?basket=true&menu_id=" . $menu_id; ?>"> <i class="fi-shopping-bag"></i>View basket </a>
							<?php if( $basket_isset ) : ;?>
							<span id="item-count"><?php echo ($basket != 0)?count( $basket ):0; ?> Items</span>
							<?php endif;?>
						</div>
						<?php endif; ?>
						<div class="row height563" data-mcs-theme="dark-2">
							<div class="row static-redeem" id="redeemHome">
								<div class="small-6 large-6 columns leftnp">
									<div class="callout panel clickAble" data-type="gourl" data-url="<?=HTTP_PATH?>redeem/products.php?menu_id=1">
										<div class="prodTitle">
											Shop
										</div>
										<img src="img/vouchers.jpg" alt="Shop">
									</div>
								</div>
								<div class="small-6 large-6 columns rightnp">
									<div class="callout panel clickAble" data-type="gourl" data-url="<?=HTTP_PATH?>redeem/products.php?menu_id=4">
										<div class="prodTitle">
											Experience
										</div>
										<img src="img/experience.jpg" alt="Experience">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="left-column" class="large-2 large-pull-8 columns">
				<div id="payoff" class="callout panel clickAble" data-type="gourl" data-url="<?=HTTP_PATH?>home.php">
					<span class="helper"></span>
					<img src="<?=HTTP_PATH?>images/our-heroes.svg" alt="Cancer Research UK" />
				</div>
				<div id="redeempanel" class="callout panel">
					<div class="title">
						Avable to spend
					</div>
					<div class="price-panel">
						<?php echo '&pound;'; ?>
						<?php 
									$sum_all = getAvailable( $_SESSION['user']->EmpNum ); 
									$sum_credit_card = getCreditCard( $_SESSION['user']->EmpNum );
									$sum_orders = getEmpBasketOrdersSum( $_SESSION['user']->EmpNum );
			
									$remaining_amount = $sum_all + $sum_credit_card - $sum_orders;
									echo $remaining_amount;
									?>
					</div>
					<div class="unclaimed-panel">
						<div class="clickAble" data-type="gourl" data-url="<?=HTTP_PATH?>my-account/my-awards.php">
							+<?php echo getTotalNewNominations($_SESSION['user']->EmpNum); ?> Unclaimed
						</div>
					</div>
				</div>
				<div  class="callout panel" id="menu_container">
					<?php $menus = getMenuAllRows(); ?>
					<!-- <pre><?php var_dump($menus); ?></pre> -->
					
					<section class="block-list">
						<ul class="left-bar-nav">
							<?php foreach ($menus as $v): ?>
							<?php if ($v["parent"] == 0): ?>
							<li><a href="<?php echo HTTP_PATH . "redeem/products.php?menu_id=" . $v['id'] ; ?>"><?php echo $v["label"]; ?></a></li>
							<ul class="sub-menu <?php if( ( isset($menu_id) && $menu_id != $v["id"]) || (!isset($menu_id)) ) echo 'hide';?>">
								<?php foreach ($menus as $val): ?>
								<?php if ($v["id"] == $val["parent"]): ?>
								<li><a href="<?php echo HTTP_PATH . "redeem/products.php?menu_id=" . $v['id'] . "&sub_id=" . $val['id'] ; ?>"><?php echo $val["label"]; ?></a></li>
								<?php endif; ?>
								<?php endforeach; ?>
							</ul>
							<?php endif; ?>
							<?php endforeach; ?>
						</ul>
					</section>
				</div>
			</div>
			<div id="right-column"  class="large-2 columns">
				<div id="portfolio" class="callout panel">
					<?php include '../inc/portfolio.php'; ?>
				</div>
				<div id="mainmenu" class="callout panel">
					<ul>
						<?php include '../inc/menu.php'; ?>
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