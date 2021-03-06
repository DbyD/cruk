<?php 
include_once '../inc/config.php';
include_once '../inc/header.php';
include "lib.php";
$menu = new MenuGenerator;

if(isset($_POST['submitUpdate'])){
	
	$arr = array();

	foreach($_POST as $key => $post){
		if( $key != "submitUpdate" ){
			$item = explode('_',$key);
			$arr[ $item[1] ][ $item[0] ] = $post; 
		}
	}
	foreach($arr as $val){
			
			$current_count = count( explode(',',$val['busketIDS']) );
			$quantity = $val["quantity"];

			if( $current_count != $quantity ) {
				if( $current_count < $quantity ){
					$addCount = $quantity - $current_count;
					

					$ex_basket_id = explode(',', $val['busketIDS']);
    				$basket_id = isset($ex_basket_id[0]) ? $ex_basket_id[0] : '';

    				$basket = getBasketByID( $basket_id );
					for( $i = 0; $i < $addCount; $i++ ){
						addBasket( $basket[0] );
					}
				} else {
					$minusCount = $current_count - $quantity;
					$b_ids = explode( ',', $val['busketIDS'] );
					rsort( $b_ids );

					for( $i = 0; $i < $minusCount; $i++ ){
						deleteBasketItem( $b_ids[ $i ] );
					}
				}
				
			}
	}
}

if(isset($_POST["baIDdel"]) && isset( $_POST['count'] ) ){
	
	$explode = explode(',', $_POST["baIDdel"]);
	$count = intval($_POST['count']);
	
	
	for($i = 0;$i < $count; $i++){
		deleteBasketItem( $explode[ $i ] );
	}
}

if( isset( $_POST[ "prID" ] ) && isset( $_POST[ "aPrice" ] ) && isset( $_POST[ "EmpNum" ] ) ){
	$res = addBasket($_POST);
}

if(isset( $_POST["submit"] ) ){
	if( empty( $_POST["title"] ) || empty( $_POST["point"] ) || empty( $_POST["Delivery"] ) || empty( $_POST["content"] ) || empty( $_FILES ) ){
		$error_message = "<div class='error'>Please fill in all fields</div>";
	} else {

		
		$file_path = insertFile( $_FILES , $_POST["menu_id"], $_POST["sub_id"]);

		if($file_path != 'error'){

			$data = array(
				'aTitle' => $_POST["title"],
				'aPrice' => $_POST["point"],
				'delivery' => $_POST["Delivery"],
				'aContent' => $_POST["content"],
				'menuID' => $_POST["menu_id"],
				'subID' => $_POST["sub_id"],
				'Image_name' => $file_path
			);

			insertProduct( $data );
		}

	}
}

$basket = getBasket( $_SESSION["user"]->EmpNum );

if(count($basket) > 0 && is_array($basket)){
	$basket_isset = true;
} else {
	$basket_isset = false;
}

if( isset( $_GET["menu_id"] ) ) {
	$menu_id = $_GET["menu_id"];

    $menu = getMenuRows( $menu_id );
}

if( isset( $_GET['prID'] ) ) {
	$product = getProductByID( $_GET['prID'] );
	$sub = getMenuSub($product["subID"]);
}

$val = $_SESSION['user']->administrator;

?>

			<div id="content" class="large-8 large-push-2 columns">
				<div class="title withStar">
					<div class="inlineDiv clickAble" data-type="gourl" data-url="<?php echo HTTP_PATH . 'redeem/'; ?>">Shop</div> <i class="icon-icons_thickrightarrow smalli"></i>
					<?php	if (isset($_GET['prID'])) {
							echo '<div class="inlineDiv clickAble submenu" data-type="gourl" data-url="' . HTTP_PATH . 'redeem/products.php?menu_id=' . $menu_id . '">'. $menu[0]["label"] . '</div> ';
							echo '<i class="icon-icons_thickrightarrow smalli"></i> <div class="inlineDiv clickAble submenu" data-type="gourl" data-url="' . HTTP_PATH . 'redeem/products.php?menu_id=' . $menu_id . '&sub_id=' . $sub[0]["id"] . '">'. $sub[0]["label"] . '</div> ';
							echo '<i class="icon-icons_thickrightarrow smalli"></i> <span class="subSubTitle">' . $product["aTitle"] . '</span>';
						} else {
							echo '<span class="subSubTitle">Basket</span>';
						}
				?>
				</div>
				<div class="row contentFill">
					<div class="medium-12 columns leftnp rightnp fillHeight">
						
						<?php if(isset($basket)):?>

						<div class="row">
							<a id="viewBasket" class='<?php if($basket_isset) echo 'view-basket';?>' href="<?php echo HTTP_PATH . "redeem/product-basket.php?basket=true&menu_id=" . $menu_id; ?>"> <i class="fi-shopping-bag"></i>View basket </a>
							<?php if( $basket_isset ) : ;?>

							<span id="item-count"><?php echo ($basket != 0)?count( $basket ):0; ?> Items</span>
							<?php endif;?>
						</div>
						<?php endif; ?>

						<div class="row mCustomScrollbar height563" data-mcs-theme="dark-2">
						<?php 
								if( isset( $_GET['prID'] ) ) {
									$product = getProductByID( $_GET['prID'] ); 
									$prices = explode(',',$product["aPrice"]);
							?>
						<div class="row callout panel productView">
							<div class="small-4 medium-4 columns">
								<img src="<?php echo HTTP_PATH . $product["Image_name"]; ?>" class="product-img">
							</div>
							<div class="small-8 medium-8 columns">
								<div class="small-12 large-12 columns productText">
									<h3><?php echo $product["aTitle"]; ?></h3>
									<p><?php echo $product["aContent"]; ?></p>
								</div>
								<div class="small-12 large-12 columns">
									<div class="row">
										<div class="small-6 large-6 columns">
											<div id="price">
												<div>
													<p>Price<i class="icon-icons_thinrightarrow right"></i></p>
												</div>
												<div>
													<ul class="price-list hide">
														<?php foreach($prices as $price):?>
														<li><?php echo "&pound;".$price; ?></li>
														<?php endforeach;?>
													</ul>
												</div>
											</div>
										</div>
										<div class="small-6 large-6 columns">
											<form action="<?php echo HTTP_PATH . "redeem/product-basket.php?basket=true&menu_id=" . $menu_id; ?>" method="post">
												<input type="hidden" name="prID" value="<?php echo $product["prID"]; ?>" id="prID">
												<input type="hidden" name="aPrice" value="<?php echo $product["aPrice"]; ?>" id="aPrice">
												<input type="hidden" name="EmpNum" value="<?php echo $_SESSION['user']->EmpNum; ?>" id="EmpNum">
												<button id="addBasket" class="pinkButton">Add to Basket</button>
											</form>
										</div>
										<a href="#" data-reveal-id="myModalPrice" class="hidden" id="emptyPriceButton"></a>
										<div id="myModalPrice" class="reveal-modal hidden" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
										  <h2 id="modalTitle">Price</h2>
										  <div class="withPadding">
												<div class="row">
													<div class="large-12 columns">
														<p>Please select an amount by clicking on Price.</p>
														<p>&nbsp;</p>
													</div>
												</div>
											</div>
										 	<a class="close-reveal-modal" aria-label="Close"><i class="icon-icons_close"></i></a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php } else {
							$total_price = 0;
						?>

						<div class="row callout panel " id="basket-table">
							<div class="small-12 large-12 columns">
								<div id="box-basket">
									
									<table id="table_basket">
										<thead>
											<tr>
												<th width="100">QTY</th>
												<th class="textLeft">PRODUCT NAME</th>
												<th width="125">PRICE</th>
												<th width="125">REMOVE</th>
											</tr>
										</thead>
										<tbody>
											
											<?php 
											
											$arr = array();
											$i = 0;
											$delivery = 'no';

											if(!empty($basket)){
												foreach ($basket as $pr_b){		
													$pr_info = getProductByID( $pr_b["prID"] );
													$total_price += $pr_b['aPrice'];
													
													if($pr_info['delivery'] == 'yes')
														$delivery = 'yes';

													if( $i == 0 ){
														$arr[ $i ]['baID'] = $pr_b['baID'];
														$arr[ $i ]['aPrice'] = $pr_b['aPrice'];
														$arr[ $i ]['aTitle'] = $pr_info['aTitle'];
														$arr[ $i ]['prID'] = $pr_b["prID"];
														$arr[ $i ]['delivery'] = $pr_info["delivery"];
														$arr[ $i ]['QTY'] = 1;
														$i++;
													} else {
														$isProduct = false;
														for( $j = 0; $j < count($arr); $j++ ){
															if( $pr_b["prID"] == $arr[ $j ]['prID'] && $pr_b["aPrice"] == $arr[ $j ]['aPrice']){
																$arr[ $j ]['QTY']++;
																$arr[ $j ]['baID'] .= ',' . $pr_b['baID'] ;
																$isProduct = true;
															} 
														}

														if( !$isProduct ){
															$arr[ $i ]['baID'] = $pr_b['baID'];
															$arr[ $i ]['aPrice'] = $pr_b['aPrice'];
															$arr[ $i ]['aTitle'] = $pr_info['aTitle'];
															$arr[ $i ]['prID'] = $pr_b["prID"];
															$arr[ $i ]['delivery'] = $pr_info["delivery"];
															$arr[ $i ]['QTY'] = 1;
															$i++;
														}
													}

												}
											}
												
											?>

											<?php 
											$i = 1;
											foreach( $arr as $b ):?>
												<tr>
													<td>
														<input type="number" class="quantityPr" value="<?php echo $b['QTY']; ?>" min="1">
													</td>
													<td class="textLeft"><?php echo $b['aTitle'];?></td>
													<td>&pound;<?php echo $b['aPrice'];?></td>
													<td> <i class="fi-trash basket-item-remove"></i>
														<input type="hidden" value="<?php echo $b["baID"]; ?>">
													</td>
												</tr>
												<?php $i++; ?>
											<?php endforeach;?>

										
											<tr>
												<td></td>
												<td class="textRight">Total</td>
												<td>&pound;<?php echo $total_price;?></td>
												<td></td>
											</tr>
										</tbody>
									</table>

									<form action="" method="post" id="formUpdate">
										<input type="submit" class="hidden" name="submitUpdate" value="submit">
									</form>
								</div>

								<a href="#" data-reveal-id="myModalbasket" id="modalButton" class="hide"></a>

								<div id="myModalbasket" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
									<h2 id="modalTitle">Delete Item</h2>
									<div class="row">
										<div class="large-12 columns">
											<p>Are you sure you want to remove this item from your basket?</p><p>This action is irreversible!</p>
										</div>
									</div>
									<div class="row">
										<div class="large-4 columns">
										</div>
										<div class="large-8 columns">
											<form action="" method="post">
												<input type="hidden" name="baIDdel" id="baIDdel">
												<input type="hidden" name="count" id="countPr">
												<button class="blueButton"> YES </button>
											</form>
											<button id="close-basket-del" class="blueButton"> NO </button>
										</div>
									</div>
									<a class="close-reveal-modal" aria-label="Close"><i class="icon-icons_close"></i></a>
								</div>

								<a href="#" data-reveal-id="myModalcheck" id="modalCheckButton" class="hidden"></a>

								<div id="myModalcheck" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
									<h2 id="modalTitle">Credit or Debit Card</h2>
									<div class="row">
										<div class="large-12 columns">
											<p>Your award balance does not cover the total value of your order.</p>
											<p>Would you like to pay the excess by credit or debit card?</p>
										</div>
									</div>
									<div class="row">
										<div class="large-4 columns">
										</div>
										<div class="large-8 columns">
											<button class="blueButton" onClick="location.href='<?php echo HTTP_PATH . "redeem/credit-card-page.php?menu_id=" . $menu_id . "&checkout=false"; ?>'">Yes</button> &nbsp; 
											<button id="closeCheckOut" class="blueButton">NO</button>
										</div>
										
									</div>
									
									
									<a class="close-reveal-modal" aria-label="Close"><i class="icon-icons_close"></i></a>
								</div>


							</div>
							<div class="row">
								<div class="small-12 medium-12 columns textRight">
								<a href="<?php echo HTTP_PATH . "redeem"?>"><button class="purpleButton">CONTINUE SHOPPING</button></a>
								<button class="blueButton" id="updateButton">UPDATE QUANTITY</button>
								<button class="pinkButton" id="checkOutButton" linkGo="<?php echo HTTP_PATH . "redeem/checkout.php?menu_id=" . $menu_id . "&checkout=true&delivery=".$delivery; ?>">CHECK OUT</button>
								</div>
							</div>


							


						</div>
						<?php } ?>
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
						Available to spend
					</div>
					<div class="price-panel">

						<?php 
							$sum_all = getAvailable( $_SESSION['user']->EmpNum ); 
							$sum_credit_card = getCreditCard( $_SESSION['user']->EmpNum );
							$sum_orders = getEmpBasketOrdersSum( $_SESSION['user']->EmpNum );

							$remaining_amount = $sum_all + $sum_credit_card - $sum_orders;
							echo '&pound;' . ' ' .  $remaining_amount;
						?> 

					</div>
					<div class="unclaimed-panel">
						<div class="clickAble" data-type="gourl" data-url="<?=HTTP_PATH?>my-account/my-awards.php">
							+<?php echo getTotalNewNominations($_SESSION['user']->EmpNum); ?> Unclaimed
						</div>
					</div>
				</div>
				<div  class="callout panel" id="menu_container">
					<div id="awardList" class="mCustomScrollbar height385" data-mcs-theme="dark-2">
						<?php $menus = getMenuAllRows(); ?>
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
</body>
</html>
