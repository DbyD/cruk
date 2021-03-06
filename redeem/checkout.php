<?php 
include_once '../inc/config.php';
include_once '../inc/header.php';
include "lib.php";
$menu = new MenuGenerator;

$menu_id = $_GET["menu_id"];
$checkout = $_GET["checkout"];
$delivery = $_GET['delivery'] == 'yes' ? true : false;

if(isset($_POST) && !empty($_POST)){
	// var_dump($_POST);die;
	if(isset($_SESSION['cardForm'])){
		$insert_data = $_SESSION['cardForm'];
	}
	
	if(!empty($insert_data) && isset($insert_data['amount'])){
		$insert_data['amount'] = intval(substr( $_POST['amount'] ,-strlen($_POST['amount']),strlen($_POST['amount'])-2 ));
	}
}
 
$key = 'Broken38Output22Corner';

if(isset($_POST['redirectURL'])){
	$res = $_POST;
 	
 	// updateCreditCardAmount( $res['amount'] ,  $resultCardRequest);
	
	$ccobj = $res;

	$insert_data['resultCardRequest'] = json_encode($res);
	$insert_data['EmpNum'] = $_SESSION["user"]->EmpNum;
	$insert_data['amount'] = intval(substr( $res["amount"] ,-strlen($res["amount"]),strlen($res["amount"])-2 ));
	
	$signature = null;
	if (isset($res['signature'])) { 
		$signature = $res['signature'];
		unset($res['signature']);
	}
 
	if (!$signature || $signature !== createSignature($res, $key)) {
		die('Sorry, the signature check failed');
	}

	if($_SESSION["thank_you"] === true){
		if ($res['responseCode'] === "0") { 
			$card_message = "<p>Thank you for your payment.</p>";
			$total_price = 0;

			$basket = getBasket( $_SESSION["user"]->EmpNum );
			
			if(is_array($basket)){
				foreach ($basket as $pr_b){	
					$total_price += $pr_b['aPrice'];
				}

				$insert_data["date"] = date("Y-m-d h:i:s");
				$insert_data["totalPrice"] = $total_price;
				$insert_data["postcode"] = intval( $_SESSION['cardForm']["postcode"] );
				
				$order_insert_id = addBasketOrders( $insert_data );
				$insert_data["orderID"] = $order_insert_id;
				insertCreditCard( $insert_data );
				$last_order_id = 'CR'.$order_insert_id;
				$email_order_code = $order_insert_id;
				updateBasketStatus( $_SESSION['user']->EmpNum, $order_insert_id );
				
				$args = array();
				
				$post_email = $insert_data;
				$args["tel_number"] = $post_email['telephone'];
				if (isset($post_email['address1'])){
					$delivery_address = $post_email['address1'].', ';
					if ($post_email['address2'] !=''){ 
						$delivery_address .= $post_email['address2'].', ';
					}
					$delivery_address .= $post_email['town'].', '.$post_email['postcode'];
					$args["delivery_address"] = $delivery_address;
				}
				$args["email_order_code"] = $email_order_code;
				SendMail( $args );

				
				if( $order_insert_id > 0){
					$credit_save = true;
					$_SESSION["thank_you"] = false;
				}
			}
			
		} else { 
			$card_message = "<p>Failed to take payment: " . htmlentities($res['responseMessage']) . "</p>";
		}
	}
} else {
	$credit_save = true;
}


$basket = getBasket( $_SESSION["user"]->EmpNum );

	if( isset( $_GET["menu_id"] ) ) {
		$menu_id = $_GET["menu_id"];
	}

	$val = $_SESSION['user']->administrator;

	$sum_all = getAvailable( $_SESSION['user']->EmpNum ); 
	$sum_credit_card = getCreditCard( $_SESSION['user']->EmpNum );
	$sum_orders = getEmpBasketOrdersSum( $_SESSION['user']->EmpNum );
	$remaining_amount = $sum_all + $sum_credit_card - $sum_orders;

	// Post request from credit card form

	if( isset( $_POST ) && !isset($_POST['redirectURL']) ){

		if( isset( $_POST['post'] ) ){
			if($_POST["save"] == 'false'){
				$form = unserialize( $_POST[ 'post' ] );
			} else {
				$postForUpload = unserialize( $_POST[ 'post' ]);
			}
		}
	
		if( !isset($_POST['no_delivery']) && isset( $_POST[ "address1" ] ) && isset($_POST[ "town" ] ) && isset( $_POST[ "postcode" ] ) && isset( $_POST[ "read" ] ) )
		{			
			$error = false;
			$post = $_POST;

			if( empty( $_POST["address1"] ) ){
				$error = true;
			}

			if( empty( $_POST["town"] ) ){
				$error = true;
			}

			if( empty( $_POST["postcode"] ) ){
				$error = true;
			}

			if( $_POST["read"] != "on" ){
				$error = true;
			}
		}
		else
		if(isset($_POST['no_delivery']) && isset($_POST['telephone']))
		{
			$error = false;
			$post = $_POST;

			if( empty( $_POST["telephone"] ) )
			{
				$error = true;
			}
		}

	} else if( isset($_POST['redirectURL'])  ){
		$postForUpload = array();
	}

if(isset($postForUpload)){
 	$last_id = 1;
 	$basket = getBasket( $_SESSION["user"]->EmpNum );
 	$total_price = 0;

 	if(is_array($basket)){
 		foreach ($basket as $pr_b){	
			$total_price += $pr_b['aPrice'];
		}

		if( count($postForUpload) > 0 && $_SESSION["thank_you"] === true ){
			if( $total_price <= $remaining_amount){
				$postForUpload["date"] = date("Y-m-d h:i:s");
				$postForUpload["EmpNum"] = $_SESSION['user']->EmpNum;
				$postForUpload["totalPrice"] = $total_price;
				$last_id = addBasketOrders( $postForUpload ); 
				$email_order_code = $last_id;

				$sum_all = getAvailable( $_SESSION['user']->EmpNum ); 
				$sum_credit_card = getCreditCard( $_SESSION['user']->EmpNum );
				$sum_orders = getEmpBasketOrdersSum( $_SESSION['user']->EmpNum );
				$remaining_amount = $sum_all + $sum_credit_card - $sum_orders;

			}
		} else if( $_SESSION["thank_you"] === true ){
			$last_id = $order_insert_id;
		}
		if( $last_id > 0 || $_SESSION["thank_you"] === false){
			if( $_SESSION["thank_you"] === true ){
				updateBasketStatus( $_SESSION['user']->EmpNum, $last_id );
			}
			
			$_SESSION["thank_you"] = false;
		}
 	}
 }

if(count($basket) > 0 && is_array($basket)){
	$basket_isset = true;
} else {
	$basket = array();
	$basket_isset = false;
}

if( isset( $email_order_code ) && $_SESSION["thank_you"] == false){
	if(isset($_POST['post'])){
		$args = array();
		$args["email_order_code"] = $email_order_code;
		
		$post_email = unserialize($_POST['post']);
		$args["tel_number"] = $post_email['telephone'];
		if (isset($post_email['address1'])){
			$delivery_address = $post_email['address1'].', ';
			if ($post_email['address2'] !=''){ 
				$delivery_address .= $post_email['address2'].', ';
			}
			$delivery_address .= $post_email['town'].', '.$post_email['postcode'];
			$args["delivery_address"] = $delivery_address;
		}
		$email_order_code = $args["email_order_code"];
		$last_order_id = 'CR'.$email_order_code;
		SendMail( $args );
	}
}

?>

<div id="content" class="large-8 large-push-2 columns">
	<div class="title withStar">
		<div class="inlineDiv clickAble" data-type="gourl" data-url="<?php echo HTTP_PATH . 'redeem/'; ?>">
			Shop
		</div>

		<?php if(isset($post) && !$error):?>
			<i class="icon-icons_thickrightarrow smalli"></i> <span class="subTitle"> Checkout </span>
			<i class="icon-icons_thickrightarrow smalli"></i> <span class="subSubTitle"> Order Confirmation </span>
		<?php else: ?>
		
		<?php if(isset($_SESSION["thank_you"]) && $_SESSION["thank_you"] === false):?>
				<i class="icon-icons_thickrightarrow smalli"></i> <span class="subTitle"> Thank you </span>
			<?php else:?>
				<i class="icon-icons_thickrightarrow smalli"></i> <span class="subSubTitle"> Checkout </span>
			<?php endif;?>
			<!--<i class="icon-icons_thickrightarrow smalli"></i> <span class="subSubTitle"> Order Confirmed </span>-->
		<?php endif; ?>
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
			
			<div class="row mCustomScrollbar height563" data-mcs-theme="dark-2">
			<div class="row callout panel <?php if(isset($postForUpload)) echo 'hidden'; ?>" id="basket-table">
				
				<div class="small-12 large-12 columns">
					<div id="box-basket">
						<table id="table_basket">
							<thead>
								<tr>
									<th width="100">QTY</th>
									<th class="textLeft">PRODUCT NAME</th>
									<th></th>
									<th width="125">PRICE</th>
								</tr>
							</thead>
							<tbody>
								<?php 
												
												$arr = array();
												$i = $total_price = 0;
												
	
												foreach ($basket as $pr_b){	
	
													$pr_info = getProductByID( $pr_b["prID"] );
													$total_price += $pr_b['aPrice'];
													
	
													if( $i == 0 ){
														$arr[ $i ]['baID'] = $pr_b['baID'];
														$arr[ $i ]['aPrice'] = $pr_b['aPrice'];
														$arr[ $i ]['aTitle'] = $pr_info['aTitle'];
														$arr[ $i ]['prID'] = $pr_b["prID"];
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
															$arr[ $i ]['QTY'] = 1;
															$i++;
														}
													}
	
													
												}
													
												?>
								<?php 
												$i = 1;
												foreach( $arr as $b ):?>
								<tr>
									<td> <?php echo $b['QTY']; ?> </td>
									<td class="textLeft"><?php echo $b['aTitle'];?></td>
									<td></td>
									<td>&pound;<?php echo $b['aPrice'];?></td>
								</tr>
								<?php $i++; ?>
								<?php endforeach;?>
								<tr>
									<td></td>
									<td></td>
									<td class="textRight">Total</td>
									<td>&pound;<?php echo $total_price;?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<!--
				<div class="row">
					<div class="large-12 columns">
						<label> NOTE: if your Basket includes several gift cards from the same retailer...
							<textarea placeholder=""></textarea>
						</label>
					</div>
				</div> -->
			</div>

			<?php if( isset( $post ) && !$error ):?>

			<div class="row callout panel creditCardView">
				<div id="formDiv" >
					<div class="row">
						<div class="medium-12 withPadding columns">
							If your order includes an e-voucher code, this will be delivered by email.
						</div>
					</div>
					<?php foreach ($post as $key => $value):?>
					<div class="row">
						<div class="medium-3 columns textRight">
							<label class="right inline">
								<?php
												if( $key == 'telephone' ){
													echo "Telephone Number:";
												} else if( $key == 'address1' ){
													echo "Address Line 1:";
												} else if( $key == 'address2' ){
													echo "Address Line 2:";
												} else if( $key == 'town' ){
													echo "Town/City:";
												} else if( $key == 'postcode' ){
													echo "Postcode:";
												}
											?>
							</label>
						</div>
						<div class="medium-9 columns">
							<label class="inline">
								<?php 
												if( $key != 'read' ){ 
													echo ( $value == '' )?'<i></i>':$value;
												}
											?>
							</label>
						</div>
					</div>
					<?php endforeach; ?>
					<div class="row">
						<div class="medium-12 columns textRight">
							<form action="" method="post" class="checkoutform">
								<input type="hidden" name="post" value="<?php echo htmlentities(serialize($post));  ?>">
								<input type="hidden" name="save" value="false">
								<button class="purpleButton">EDIT DETAILS</button>
							</form>
							<form action="" method="post" class="checkoutform">
								<input type="hidden" name="post" value="<?php echo htmlentities(serialize($post));  ?>">
								<input type="hidden" name="save" value="true">
								<button class="pinkButton">Complete Checkout</button>
							</form>
						</div>
					</div>
					<div class="row">
						<div class="medium-12 withPadding columns">
							If you require any assistance completing this transaction please contact the Xexec Helpdesk by email at <a href="mailto:info@xexec.com">info@xexec.com</a> or by telephone on 0845 230 9393
						</div>
					</div>
				</div>
			</div>
			<?php elseif( isset( $postForUpload ) ):?>
			<?php if( $last_id > 0 || $_SESSION["thank_you"] === false):?>

				<div id="formDiv" class="callout panel white">
					<div class="row">
						<div class="medium-12 withPadding columns">
							<h2>Thank you</h2>
							<p>Thank you for your purchase. Your voucher will be delivered within the next 5-7 working days. (Additional delay may be experienced over a public holiday period.)</p>
							<p>Your Reference for this order is: <?php echo $last_order_id?></p>
							<p>Confirmation of this order has been sent to your email address.</p>
						</div>
					</div>
				</div>

				<?php else: ?>
				<div id="formDiv" class="callout panel white">
					<div class="row">
						<div class="medium-12 withPadding columns">
							<h2>Sorry Your Order failed</h2>
							<p>The transaction process failed with the following error:<b> <?php echo $ccobj['responseMessage'] ?></b></p>
							<p>Please try again or contact Xexec on <a href="mailto:info@xexec.com">info@xexec.com</a>.</p>
						</div>
					</div>
				</div>
				<?php endif; ?>
			<?php else:?>
			<?php $_SESSION["thank_you"] = true; ?>
				<div id="formDiv" class="callout panel creditCardView">
					<form action="<?php echo HTTP_PATH . 'redeem/checkout.php?menu_id=' . $menu_id . "&checkout=true" ?>" method="post">
						<div class="row">
							<div class="medium-12 withPadding columns">
								If your order includes an e-voucher code, this will be delivered by email
							</div>
						</div>
						<div class="row">
							<div class="medium-3 columns textRight">
								<label for="right-label" class="right inline">Telephone Number: <span class="required">*</span>
								</label>
							</div>
							<div class="medium-9 columns">
								<input type="text" id="right-label" name="telephone" value="<?php echo (isset($form["telephone"]))?$form["telephone"]:"";?>" required>
							</div>
						</div>
						<?php
						if($delivery) //start delivery check
						{ 
						?>
						<div class="row">
							<div class="medium-3 columns textRight">
							<p>&nbsp;</p>
								<label for="right-label" class="right inline smallTopMargin">Address Line 1: <span class="required">*</span>
									<br />
									<small>(or company name)</small></label>
							</div>
							<div class="medium-9 columns">
								<div class="smallTopMargin">Please supply a fully inclusive delivery address as this will be the<br>address we will be delivering your products to.</div>
								<input type="text" class="smallTopMargin" id="right-label" name="address1" value="<?php echo (isset($form["address1"]))?$form["address1"]:"";?>" required>
								<small>House name/number and street, P.O. box,company name, c/o</small>
							</div>
						</div>
						<div class="row">
							<div class="medium-3 columns textRight">
								<label for="right-label" class="right inline">Address Line 2: <span class="required">&nbsp;</span>
									<br />
									<small>(optional)</small></label>
							</div>
							<div class="medium-9 columns">
								<input type="text" id="right-label" name="address2" value="<?php echo (isset($form["address2"]))?$form["address2"]:"";?>">
								<small>Apartment, suite, unit, building,floor,etc</small>
							</div>
						</div>
						<div class="row">
							<div class="medium-3 columns textRight">
								<label for="right-label" class="right inline">Town/City: <span class="required">*</span>
								</label>
							</div>
							<div class="medium-9 columns">
								<input type="text" id="right-label" name="town" value="<?php echo (isset($form["town"]))?$form["town"]:"";?>" required>
							</div>
						</div>
						<div class="row">
							<div class="medium-3 columns textRight">
								<label for="right-label" class="right inline">Postcode: <span class="required">*</span>
								</label>
							</div>
							<div class="medium-9 columns">
								<input type="text" id="right-label" name="postcode" value="<?php echo (isset($form["postcode"]))?$form["postcode"]:"";?>" required>
							</div>
						</div>
						<?php 
						} //end delivery check
						else
						echo '<input type="hidden" name="no_delivery" value="" />'; ?> 

						<div class="row withPadding">
							<div class="medium-3 columns textRight">
								<span class="right inline required small">* Required Fields</span>
							</div>
							<div class="medium-9 columns">
								I have read the <a href="<?=HTTP_PATH?>terms.php" target="_blank">Terms & Conditions</a> <span class="required">*</span>
								<input type="checkbox" name="read" <?php echo ( isset( $form ) )?'checked':"";?> >
							</div>
						</div>
						<div class="row">
							<div class="medium-12 columns textRight">
								<a href="index.php" class="purpleButton">CONTINUE SHOPPING</a> &nbsp;
								<button class="pinkButton proceedButton">PROCEED TO NEXT STEP</button>
							</div>
						</div>
						<div class="row">
							<div class="medium-12 withPadding columns">
								If you require any assistance completing this transaction please contact the Xexec Helpdesk by email at <a href="mailto:info@xexec.com">info@xexec.com</a> or by telephone on 0845 230 9393
							</div>
						</div>
					</form>
				</div>
			<?php endif;?>
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
			<?php echo '&pound;' . $remaining_amount;?>
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
</body></html>
