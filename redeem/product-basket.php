<?php 
include_once '../inc/config.php';
include_once '../inc/header.php';
include "lib.php";
$menu = new MenuGenerator;
if(isset($_POST["baIDdel"])){
	deleteBasketItem( $_POST["baIDdel"] );
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
 
$basket = getBasket( $_SESSION["user"]->id );
?>

<?php 
	if( isset( $_GET["menu_id"] ) ) {
		$menu_id = $_GET["menu_id"];
	}
	if( isset($_GET['basket'])){
		$basket_isset = true;
	} else {
		$basket_isset = false;
	}
	$val = $_SESSION['user']->SuperUser;
	if( $val == "YES" ){
		include('../admin/products.php');
	} else {
?>

<div id="content" class="large-8 large-push-2 columns">
	<div class="title withStar">
		Redeem
	</div>
	<div class="row contentFill">
		<div class="medium-12 columns leftnp rightnp fillHeight">
			<div class="row">

			
			<a id="viewBasket" class='<?php if($basket_isset) echo 'view-basket';?>' href="<?php echo HTTP_PATH . "redeem/product-basket.php?basket=true&menu_id=" . $menu_id; ?>">
				<p><i class="fi-shopping-bag medium left"></i>&nbsp;&nbsp;View basket</p>
			</a>

			<?php if( $basket_isset ) : ;?>
				<span id="item-count"><?php echo count( $basket ); ?> Items</span>
			<?php endif;?>

			</div>
			
				<?php 
					if( isset( $_GET['prID'] ) ) {
						$product = getProductByID( $_GET['prID'] ); 
						$prices = explode(',',$product["aPrice"]);
						if( isset( $_POST[ "prID" ] ) && isset( $_POST[ "aPrice" ] ) && isset( $_POST[ "employeID" ] ) ){
							$res = addBasket($_POST);
						}
				?>

					

			<div class="row product">
				<?php if($res):?>
					<div data-alert class="alert-box success radius">
					  Added in basket!
					  <a href="#" class="close">&times;</a>
					</div>
				<?php endif; ?>
				<div class="small-4 large-4 columns">
					<img src="<?php echo HTTP_PATH . $product["Image_name"]; ?>" class="product-img">
				</div>
				<div class="small-8 large-8 columns">
					<h3><?php echo $product["aTitle"]; ?></h3>
					<p><?php echo $product["aContent"]; ?></p>
				</div>
				<div class="small-12 large-12 columns">
					<div class="row">
						

						<div class="small-4 large-4 large-offset-4 columns">
							<div id="price">
								<div><p>Price<i class="fi-arrow-down right"></i></p></div>
								<div>
									<ul class="price-list hide">
										<?php foreach($prices as $price):?>
											<li><?php echo $price; ?></li>
										<?php endforeach;?>
									</ul>
								</div>
							</div>
						</div>

						<div class="small-4 large-4 columns">
							<form action="" method="post">
								<input type="hidden" name="prID" value="<?php echo $product["prID"]; ?>" id="prID">
								<input type="hidden" name="aPrice" value="<?php echo $product["aPrice"]; ?>" id="aPrice">
								<input type="hidden" name="employeID" value="<?php echo $_SESSION['user']->id; ?>" id="employeID">
								<button id="addBasket"><p>Add to Basket</p></button>
							</form>
						</div>
					</div>
				</div>
				

			</div>

			<?php } else { 
				if( isset( $_GET['basket'] ) ) {
				$total_price = 0;
				 ?>
				<!-- <pre><?php var_dump($basket); ?></pre> -->
					<div class="row" id="basket-table">

						<div class="small-12 large-12 columns">

							<div id="box-basket">
								<table>
								  <thead>
								    <tr>
								      <th width="200">QTY</th>
								      <th>PRODUCT NAME</th>
								      <th width="150">PRICE</th>
								      <th width="150">REMOVE</th>
								    </tr>
								  </thead>
								  <tbody>
								  	
							  	<?php foreach ($basket as $pr_b):
							  		$pr_info = getProductByID( $pr_b["prID"] );
							  		$total_price += $pr_b['aPrice']
							  	?>
							  		<tr>
							  			<td><span>1<span></td>
							  			<td><?php echo $pr_info['aTitle'];?></td>
							  			<td>$<?php echo $pr_b['aPrice'];?></td>
							  			<td>
							  				<i class="fi-trash basket-item-remove"></i>
							  				<input type="hidden" value="<?php echo $pr_b["baID"]; ?>">
							  			</td>
							  		</tr>
							  	<?php endforeach;?>
								    <tr>
							  			<td></td>
							  			<td></td>
							  			<td>Total $<?php echo $total_price;?></td>
							  			<td></td>
							  		</tr>
								  </tbody>
								</table>
							</div>

							<a href="#" data-reveal-id="myModalbasket" id="modalButton" class="hide">Click Me For A Modal</a>

							<div id="myModalbasket" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
							  <h2 id="modalTitle">Yow want delete this item?</h2>

								<form action="" method="post">
									  <input type="hidden" name="baIDdel" id="baIDdel">		
									  <button>
										YES
									  </button>
								</form>		

								<button id="close-basket-del">
									NO
								</button>
							
							  <a class="close-reveal-modal" aria-label="Close">&#215;</a>
							</div>

						</div>
						<div class="small-12 large-offset-2 large-10 columns">
							<button class="button-basket">
								CONTINUE SHOPING
							</button>
							<button class="button-basket">
								UPDATE QUANTITY
							</button>
							<button class="button-basket">
								CHECK OUT
							</button>
						</div>

					</div>
					
			<? } else { echo "error 404"; } } ?>
		</div>	
	</div>
</div>

		
			<div id="left-column" class="large-2 large-pull-8 columns">
				<div id="payoff" class="callout panel">
					<span class="helper"></span>
					<img src="<?=HTTP_PATH?>images/our-heroes.svg" alt="Cancer Research UK" />
				</div>
				<div id="awards" class="callout panel">
					<div class="title">
						<!-- <i class="icon-icons_trophy"></i> -->
						Avable to spend
					</div>
					<div class="price-panel">
						<!-- <i class="icon-icons_trophy"></i> -->
						$300
					</div>
					<div class="unlaimed-panel">
						<!-- <i class="icon-icons_trophy"></i> -->
						+2 Unclaimed
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


</body>
</html>

<?php } ?>