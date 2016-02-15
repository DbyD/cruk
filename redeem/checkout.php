<?php 
include_once '../inc/config.php';
include_once '../inc/header.php';
include "lib.php";
$menu = new MenuGenerator;

$menu_id = $_GET["menu_id"];
$checkout = $_GET["checkout"];


if(isset($_POST) && !empty($_POST)){
	// var_dump($_POST);die;
	
	if(isset($_SESSION['cardForm'])){
		$insert_data = $_SESSION['cardForm'];
	}
	
	if(!empty($insert_data) && isset($insert_data['amount'])){
		$insert_data['amount'] = intval(substr( $_POST['amount'] ,-strlen($_POST['amount']),strlen($_POST['amount'])-2 ));
	}
	
	
}



 
$key = 'Cheer11Inside19Credit';


function createSignature(array $data, $key) {
	// echo $key;
	// Sort by field name 
	ksort($data);

	//  Create the URL encoded signature string 
	$ret = http_build_query($data, '', '&');
	//  Normalise all line endings (CRNL|NLCR|NL|CR) to just NL (%0A) 
	$ret = str_replace(array('%0D%0A', '%0A%0D', '%0D'), '%0A', $ret);
	//  Hash the signature string and the key together 
	return hash('SHA512', $ret . $key);
 }




function SendMail($args = array()){
					
	$sendEmail->Content = $content;
	
	$email = sendEmail($sendEmail,'');
}













$arr = array();
		$i = $total_price = 0;
		$basket = getBasket( $_SESSION["user"]->EmpNum );
		

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


		$i = 1;
		$table_body = '';
		foreach( $arr as $b ){
			$table_body .= '<tr>
								<td>' . $b['QTY'] .'</td>
								<td class="textLeft">' . $b['aTitle'] . '</td>
								<td></td>
								<td>&pound;' . $b['aPrice'] . '</td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td class="textRight">Total</td>
								<td>&pound;' . $total_price . '</td>
							</tr>';

			$i++;
		}
	
	// this is what has already been setup with some styling to it. All you need to do is the shopping basket and order details. The rest is done.
	$sendEmail = new StdClass();
	$sendEmail->emailTo = $_SESSION['user']->Eaddress;
	$sendEmail->subject = 'CRUK Order';
	$sendEmail->Bcc = 'alec@iceimages.co.za';
	
	// you need to add content here.
	$content =	'Dear '.$_SESSION['user']->Fname.
				'<p>Thank you for your recent purchase.</p>
				<p><b>Items Purchased</b></p>';

	$content .= '<table id="table_basket">
					<thead>
						<tr>
							<th width="100">QTY</th>
							<th class="textLeft">PRODUCT NAME</th>
							<th></th>
							<th width="125">PRICE</th>
						</tr>
					</thead>
					<tbody>
						' . $table_body . '
					</tbody>
				</table>';
				
	//add shopping basket here in a table
	$content .= '';
	
	//add order details here in a table
	$content .= '';
	
	$content .='<p>If you have any questions regarding your order, please email <ahref="mailto:concierge@xexec.com">concierge@xexec.com</a> or call +44 20 8201 6483 quoting your unique order code.</p>';
	




















// echo '<pre>';var_dump( $_SESSION["user"]->Eaddress );echo '</pre>';


if(isset($_POST['redirectURL'])){
	$res = $_POST;
 	
 	// updateCreditCardAmount( $res['amount'] ,  $resultCardRequest);
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
			
			$last_id = insertCreditCard( $insert_data );

			$basket = getBasket( $_SESSION["user"]->EmpNum );
			
			if(is_array($basket)){
				foreach ($basket as $pr_b){	
					$total_price += $pr_b['aPrice'];
				}

				$insert_data["date"] = date("Y-m-d h:i:s");
				$insert_data["totalPrice"] = $total_price;
				$insert_data["postcode"] = intval( $_SESSION['cardForm']["postcode"] );
				
				$order_insert_id = addBasketOrders( $insert_data );

				updateBasketStatus( $_SESSION['user']->EmpNum, $order_insert_id );
				
				if( $order_insert_id > 0){
					$credit_save = true;
					SendMail();
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
	
		if( isset( $_POST[ "address1" ] ) && isset($_POST[ "town" ] ) && isset( $_POST[ "postcode" ] ) && isset( $_POST[ "read" ] ) ){
			
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
						
?>





<?php 

echo $content;


?>
<table>
  <thead>
    <tr>
      <th width="200">Table Header</th>
      <th>Table Header</th>
      <th width="150">Table Header</th>
      <th width="150">Table Header</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Content Goes Here</td>
      <td>This is longer content Donec id elit non mi porta gravida at eget metus.</td>
      <td>Content Goes Here</td>
      <td>Content Goes Here</td>
    </tr>
    <tr>
      <td>Content Goes Here</td>
      <td>This is longer Content Goes Here Donec id elit non mi porta gravida at eget metus.</td>
      <td>Content Goes Here</td>
      <td>Content Goes Here</td>
    </tr>
    <tr>
      <td>Content Goes Here</td>
      <td>This is longer Content Goes Here Donec id elit non mi porta gravida at eget metus.</td>
      <td>Content Goes Here</td>
      <td>Content Goes Here</td>
    </tr>
  </tbody>
</table>








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

			<div class="row callout panel creditCardView mCustomScrollbar height410" data-mcs-theme="dark-2">
				<div  id="formDiv" >
					<div class="row">
						<div class="medium-12 withPadding columns">
							If your order includes an e-voucher code,this will be delivered by email using your work email adress,if you have also made a charity donation, this will automatically be made on your behalf.
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
													echo ( $value == '' )?'<i>(Empty)</i>':$value;
												}
											?>
							</label>
						</div>
					</div>
					<?php endforeach; ?>
					<div class="row">
						<div class="medium-8 columns textRight">
							<form action="" method="post">
								<input type="hidden" name="post" value="<?php echo htmlentities(serialize($post));  ?>">
								<input type="hidden" name="save" value="false">
								<button class="purpleButton">EDIT DETAILS</button>
							</form>
						</div>
						<div class="medium-4 columns textRight">
							<form action="" method="post">
								<input type="hidden" name="post" value="<?php echo htmlentities(serialize($post));  ?>">
								<input type="hidden" name="save" value="true">
								<button class="pinkButton">Complete Checkout</button>
							</form>
						</div>
					</div>
					<div class="row">
						<div class="medium-12 withPadding columns">
							If you require any assistance completing this transaction please contact the Xexec Helpdesk by email at <a href="info@xexec.com">info@xexec.com</a> or by telephone on 0845 230 9393
						</div>
					</div>
				</div>
			</div>
			<?php elseif( isset( $postForUpload ) ):?>
			<?php if( $last_id > 0 || $_SESSION["thank_you"] === false):?>

				<div class="row callout panel creditCardView mCustomScrollbar height410" data-mcs-theme="dark-2">
					<div  id="formDiv" >
						<div class="row">
							<div class="medium-12 withPadding columns">
								<h2>Thank you</h2>
								<p>Thank you for your purchase. Your voucher will be delivered within the next 5-7 working days 
									(Additional delay may be experienced over the official holidays). Your Reference for this order is: <?php echo $last_id?></p>
								<p> Confirmation of this order has been sent to your email address.</p>
							</div>
						</div>
					</div>
				</div>

				<?php else: ?>
					Products for order not!.
				<?php endif; ?>
			<?php else:?>
			<?php $_SESSION["thank_you"] = true; ?>
			<div class="row callout panel creditCardView mCustomScrollbar height410" data-mcs-theme="dark-2">
				<div  id="formDiv" >
					<form action="<?php echo HTTP_PATH . 'redeem/checkout.php?menu_id=' . $menu_id . "&checkout=true" ?>" method="post">
						<div class="row">
							<div class="medium-12 withPadding columns">
								If your order includes an e-voucher code,this will be delivered by email using your work email adress,if you have also made a charity donation, this will automatically be made on your behalf.
								</p>
							</div>
						</div>
						<div class="row">
							<div class="medium-3 columns textRight">
								<label for="right-label" class="right inline">Telephone Number: <span class="required">&nbsp;</span>
								</label>
							</div>
							<div class="medium-9 columns">
								<input type="text" id="right-label" name="telephone" value="<?php echo (isset($form["telephone"]))?$form["telephone"]:"";?>">
							</div>
						</div>
						<div class="row">
							<div class="medium-3 columns textRight">
								<label for="right-label" class="right inline">Address Line 1: <span class="required">*</span>
									<br />
									<small>(or company name)</small></label>
							</div>
							<div class="medium-9 columns">
								<input type="text" id="right-label" name="address1" value="<?php echo (isset($form["address1"]))?$form["address1"]:"";?>" required>
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
						<div class="row withPadding">
							<div class="medium-3 columns textRight">
								<span class="right inline required small">* Required Fields</span>
							</div>
							<div class="medium-9 columns">
								<p>Please supply a fully inclusive delivery address as this will be the address we will be delivering your products to.</p>
								I have read the Terms & Conditions <span class="required">*</span>
								<input type="checkbox" name="read" <?php echo ( isset( $form ) )?'checked':"";?> >
							</div>
						</div>
						<div class="row">
							<div class="medium-12 columns textRight">
								<button class="purpleButton">CONTINUE SHOPPING</button>
								<button class="pinkButton proceedButton">PROCEED TO NEXT STEP</button>
							</div>
						</div>
						<div class="row">
							<div class="medium-12 withPadding columns">
								If you require any assistance completing this transaction please contact the Xexec Helpdesk by email at <a href="info@xexec.com">info@xexec.com</a> or by telephone on 0845 230 9393
							</div>
						</div>
					</form>
				</div>
			</div>
			<?php endif;?>
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
