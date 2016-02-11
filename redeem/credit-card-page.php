<?php 
include_once '../inc/config.php';
include_once '../inc/header.php';
include "lib.php";
$menu = new MenuGenerator;

$menu_id = $_GET["menu_id"];
$checkout = $_GET["checkout"];


$basket = getBasket( $_SESSION["user"]->EmpNum );

	if( isset( $_GET["menu_id"] ) ) {
		$menu_id = $_GET["menu_id"];
	}

	$val = $_SESSION['user']->administrator;

	if( $val == "YES" ){
		include('../admin/products.php');
	} else {					
?>

<div id="content" class="large-8 large-push-2 columns">
	<div class="title withStar">
		<div class="inlineDiv clickAble" data-type="gourl" data-url="<?php echo HTTP_PATH . 'redeem/'; ?>">
			Redeem
		</div>
		<i class="icon-icons_thickrightarrow smalli"></i> <span class="subSubTitle">Credit Card</span>
	</div>
	<div class="row contentFill">
		<div class="medium-12 columns leftnp rightnp fillHeight">
			<div class="row">
				<a id="viewBasket" class='<?php if($basket_isset) echo 'view-basket';?>' href="<?php echo HTTP_PATH . "redeem/product-basket.php?basket=true&menu_id=" . $menu_id; ?>"> <i class="fi-shopping-bag"></i>View basket </a>
				<?php if( $basket_isset ) : ;?>
				<span id="item-count"><?php echo ($basket != 0)?count( $basket ):0; ?> Items</span>
				<?php endif;?>
			</div>
			<div class="row callout panel creditCardView height555">
				<div class="row">
					<div class="medium-12 withPadding columns">
						Please enter your Billing details below.
					</div>
				</div>
				<form action="<?php echo HTTP_PATH . 'redeem/credit-card.php?menu_id='?>" method="post">
					<input type="hidden" name="firstname" value="<?php echo $_SESSION['user']->Fname; ?>" required>
					<input type="hidden" name="surname" value="<?php echo $_SESSION['user']->Sname; ?>" required>
					<?php if($_SESSION['user']->Eaddress !=''){?>
					<input type="hidden" name="email" value="<?php echo $_SESSION['user']->Eaddress; ?>" required>
					<?php } else { ?>
					<div class="row">
						<div class="row">
							<div class="medium-3 columns textRight">
								<label for="right-label" class="right inline">E-Mail Address: <span class="required">&nbsp;</span>
								</label>
							</div>
							<div class="medium-9 columns">
								<input type="email" id="right-label" name="email">
							</div>
						</div>
					</div>
					<?php } ?>
					<div class="row">
						<div class="row">
							<div class="medium-3 columns textRight">
								<label for="right-label" class="right inline">Address Line 1: <span class="required">*</span>
									<small>(or company name)</small></label>
							</div>
							<div class="medium-9 columns">
								<input type="text" id="right-label" name="address1" required>
								<small>House name/number and street, P.O. box,company name, c/o</small>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="row">
							<div class="medium-3 columns textRight">
								<label for="right-label" class="right inline">Address Line 2: <span class="required">&nbsp;</span>
									<small>(optional)</small></label>
							</div>
							<div class="medium-9 columns">
								<input type="text" id="right-label" name="address2">
								<small>Apartment, suite, unit, building,floor,etc</small>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="row">
							<div class="medium-3 columns textRight">
								<label for="right-label" class="right inline">Town/City: <span class="required">*</span>
								</label>
							</div>
							<div class="medium-9 columns">
								<input type="text" id="right-label" name="town" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="row">
							<div class="medium-3 columns textRight">
								<label for="right-label" class="right inline">Postcode: <span class="required">*</span>
								</label>
							</div>
							<div class="medium-9 columns">
								<input type="text" id="right-label" name="postcode" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="row">
							<div class="medium-3 columns textRight">
								<label for="right-label" class="right inline">Telephone Number: <span class="required">&nbsp;</span>
								</label>
							</div>
							<div class="medium-9 columns">
								<input type="text" id="right-label" name="telephone">
							</div>
						</div>
					</div>
					<div class="row buttonRow">
						<div class="medium-3 columns buttonRow textRight">
							<div class="required small">
								* Required Fields
							</div>
						</div>
						<div class="medium-9 columns textRight buttonRow">
							<button class="purpleButton">CONTINUE SHOPPING</button>
							<button class="pinkButton">PROCEED TO NEXT STEP</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div id="left-column" class="large-2 large-pull-8 columns">
	<div id="payoff" class="callout panel">
		<span class="helper"></span>
		<img src="<?=HTTP_PATH?>images/our-heroes.svg" alt="Cancer Research UK" />
	</div>
	<div id="redeempanel" class="callout panel">
		<div class="title">
			Avable to spend
		</div>
		<div class="price-panel">
			<?php echo '&pound;';
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
				<ul class="sub-menu <?php if(isset($menu_id) && $menu_id != $v["id"]) echo 'hide';?>">
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
<script src="<?=HTTP_PATH?>js/redeem.js"></script>
</body></html><?php } ?>
