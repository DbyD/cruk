<?php 
include_once '../inc/config.php';
include_once '../inc/header.php';
include "lib.php";
$menu = new MenuGenerator;

$menu_id = $_GET["menu_id"];
$checkout = $_GET["checkout"];



$basket = getBasket( $_SESSION["user"]->id );
	if( isset( $_GET["menu_id"] ) ) {
		$menu_id = $_GET["menu_id"];
	}

	$val = $_SESSION['user']->administrator;

	if( $val == "YES" ){
		include('../admin/products.php');
	} else {


	// Post request from credit card form

	if( isset( $_POST ) ){

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
	}
						
?>

<div id="content" class="large-8 large-push-2 columns">
	<div class="title withStar">
		<div class="inlineDiv clickAble" data-type="gourl" data-url="<?php echo HTTP_PATH . 'redeem/'; ?>">
			Redeem
		</div>
		<i class="icon-icons_thickrightarrow smalli"></i> <span class="subSubTitle">Checkout</span>
	</div>
	<div class="row contentFill">
		<div class="medium-12 columns leftnp rightnp fillHeight">
			<?php if( $checkout == "false"):?>
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
					<form action="<?php echo HTTP_PATH . 'redeem/checkout.php?menu_id=' . $menu_id ?>" method="post">
						<div class="row">
							<div class="medium-3 columns textRight">
								<label for="right-label" class="right inline">First Name(s): <span class="required">*</span></label>
							</div>
							<div class="medium-9 columns">
								<input type="text" id="right-label" name="firstname" required>
							</div>
						</div>
						<div class="row">
							<div class="row">
								<div class="medium-3 columns textRight">
									<label for="right-label" class="right inline">Surname: <span class="required">*</span></label>
								</div>
								<div class="medium-9 columns">
									<input type="text" id="right-label" name="surname" required>
								</div>
							</div>
						</div>
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
									<label for="right-label" class="right inline">Town/City: <span class="required">*</span></label>
								</div>
								<div class="medium-9 columns">
									<input type="text" id="right-label" name="town" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="row">
								<div class="medium-3 columns textRight">
									<label for="right-label" class="right inline">Postcode: <span class="required">*</span></label>
								</div>
								<div class="medium-9 columns">
									<input type="text" id="right-label" name="postcode" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="row">
								<div class="medium-3 columns textRight">
									<label for="right-label" class="right inline">Telephone Number: <span class="required">&nbsp;</span></label>
								</div>
								<div class="medium-9 columns">
									<input type="text" id="right-label" name="telephone">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="row">
								<div class="medium-3 columns textRight">
									<label for="right-label" class="right inline">E-Mail Address: <span class="required">&nbsp;</span></label>
								</div>
								<div class="medium-9 columns">
									<input type="email" id="right-label" name="email">
								</div>
							</div>
						</div>
						<div class="row buttonRow">
								<div class="medium-3 columns buttonRow textRight">
									<div class="required small">* Required Fields</div>
								</div>
							<div class="medium-9 columns textRight buttonRow">
								<button class="purpleButton">CONTINUE SHOPPING</button>
								<button class="pinkButton">PROCEED TO NEXT STEP</button>
							</div>
						</div>
					</form>
				</div>
			<?php else:?>

				
				<div class="row callout panel " id="basket-table">
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
											$i = 0;
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
													<td>
														<?php echo $b['QTY']; ?>
													</td>
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
							
							<div class="row">
								<div class="large-12 columns">
									<label> NOTE: if your Basket includes several gift cards from the same retailer...
										<textarea placeholder=""></textarea>
									</label>
								</div>
							</div>
						</div>

						<?php if( isset( $post ) && !$error ):?>

							<div id="formDiv">
								<p>If your order includes an e-voucher code, this will be delivered by email using the email address you provide below. Please note, for security reasons, all gift cards are delivered unloaded. They will typically be loaded within 3 working days from receipt of your card.</p>
								<div class="row viewForm">
								<?php foreach ($post as $key => $value):?>

										<div class="medium-3 columns">
											<?php
												if( $key == 'telephone' ){
													echo "Telephone:";
												} else if( $key == 'address1' ){
													echo "Adress1:";
												} else if( $key == 'address2' ){
													echo "Adress2:";
												} else if( $key == 'town' ){
													echo "Town:";
												} else if( $key == 'postcode' ){
													echo "Postcode:";
												}
											?>
										</div>

										<div class="medium-9 columns">
											<?php 
												if( $key != 'read' ){ 
													echo ( $value == '' )?'<i>(Empty)</i>':$value;
												}
											?>
										</div>

									

									
								<?php endforeach; ?>
									<div class="medium-6  columns">

										<form action="" method="post">
											<input type="hidden" name="post" value="<?php echo htmlentities(serialize($post));  ?>">
											<input type="hidden" name="save" value="false">
											<button>EDIT DETAILS</button>
											
										</form>
										
									</div>
									<div class="medium-6 columns">

										<form action="" method="post">
											<input type="hidden" name="post" value="<?php echo htmlentities(serialize($post));  ?>">
											<input type="hidden" name="save" value="true">
											<button>PROCEED TO NEXT STEP</button>
										</form>
	
									</div>
									<div class="medium-12 columns">
										<p>If you require any assistance completing this transaction please contact the Xexec Helpdesk by email at info@xexec.com or by telephone on 0845 230 9393</p>
									</div>
								</div>
								
							</div>

						<?php elseif( isset( $postForUpload ) ):?>
							
								<?php 
									
									$last_id = 0;

									if( $total_price != null ){
										$postForUpload["date"] = date("Y-m-d h:i:s");
										$postForUpload["empID"] = $_SESSION['user']->id;
										$postForUpload["totalPrice"] = $total_price;
										$last_id = addBasketOrders( $postForUpload ); 
									}
									
									if( $last_id > 0 ):
										updateBasketStatus( $_SESSION['user']->id, $last_id );
								?>
								<h2>Thank you</h2>
								<p> 
									Thank you for your purchase. Your voucher will be delivered 
									within the next 5-7 working days (Additional delay may be
									experienced over the official holidays). Your reference 
									number for this order is your unique prize code.
								</p>

								<p> Confirmation of this order has been sent to your email address.</p>
								<?php else: ?>
									Products for order not!.
								<?php endif; ?>
							

							
						<?php else:?>

						<div id="formDiv">
							<p>If your order includes an e-voucher code,this will be delivered by email using your work email adress,if you have also made a charity donation, this will automatically be made on your behalf. </p>

							<form action="<?php echo HTTP_PATH . 'redeem/checkout.php?menu_id=' . $menu_id ?>" method="post">
								
								<div class="row">
									<div class="row">
										<div class="medium-3 columns textRight">
											<label for="right-label" class="right inline">Telephone Number: <span class="required">&nbsp;</span></label>
										</div>
										<div class="medium-9 columns">
											<input type="text" id="right-label" name="telephone" value="<?php echo (isset($form["telephone"]))?$form["telephone"]:"";?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="row">
										<div class="medium-3 columns textRight">
											<label for="right-label" class="right inline">Address Line 1: <span class="required">*</span>
												<br /><small>(or company name)</small></label>
										</div>
										<div class="medium-9 columns">
											<input type="text" id="right-label" name="address1" value="<?php echo (isset($form["address1"]))?$form["address1"]:"";?>" required>
											<small>House name/number and street, P.O. box,company name, c/o</small>
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="row">
										<div class="medium-3 columns textRight">
											<label for="right-label" class="right inline">Address Line 2: <span class="required">&nbsp;</span>
												<br /><small>(optional)</small></label>
										</div>
										<div class="medium-9 columns">
											<input type="text" id="right-label" name="address2" value="<?php echo (isset($form["address2"]))?$form["address2"]:"";?>">
											<small>Apartment, suite, unit, building,floor,etc</small>
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="row">
										<div class="medium-3 columns textRight">
											<label for="right-label" class="right inline">Town/City: <span class="required">*</span></label>
										</div>
										<div class="medium-9 columns">
											<input type="text" id="right-label" name="town" value="<?php echo (isset($form["town"]))?$form["town"]:"";?>" required>
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="row">
										<div class="medium-3 columns textRight">
											<label for="right-label" class="right inline">Postcode: <span class="required">*</span></label>
										</div>
										<div class="medium-9 columns">
											<input type="text" id="right-label" name="postcode" value="<?php echo (isset($form["postcode"]))?$form["postcode"]:"";?>" required>
											
										</div>
									</div>
								</div>                  



								<div class="row">
									<div class="row">
										<div class="medium-3 columns textRight">
											<label for="right-label" class="right inline required small">*Required Fields<span class="required">&nbsp;</span></label>
										</div>
										<div class="medium-9 columns">
											
											<p>Please supply a fully inclusive delivery address as this will be the adress we will be delivering your products to.</p>
											<p>I have read the Terms & Conditions <span class="required">*</span> 
												<input type="checkbox" name="read" <?php echo ( isset( $form ) )?'checked':"";?> ></p>
												
										</div>
									</div>
								</div>

								<div class="row">
									<div class="medium-9 columns textRight buttonRow">
										<button class="purpleButton">CONTINUE SHOPPING</button>
										<button class="pinkButton proceedButton">PROCEED TO NEXT STEP</button>
									</div>
								</div>
							</form>
							<hr />
							<p>If you require any assistance completing this transaction please contact the Xexec Helpdesk by email at info@xexec.com or by telephone on 0845 230 9393</p>
						</div>
						<?php endif;?>

						



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
			<?php echo '&pound;'.getAvailable($_SESSION['user']->EmpNum); ?>
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
