<?php 
include_once '../inc/config.php';
include_once '../inc/header.php';
include "lib.php";
$menu = new MenuGenerator;

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
?>

<?php 
	$val = $_SESSION['user']->SuperUser;
<<<<<<< HEAD
	if( $val == "NO" ){
=======
	if( $val == "YES" ){
>>>>>>> 583563fd21099138ae54b7c9dc990c4a9378fd31
		include('../admin/products.php');
	} else {
?>

<div id="content" class="large-8 large-push-2 columns">
	<div class="title withStar">
		Redeem
	</div>
	<div class="row contentFill">
		<div class="medium-12 columns leftnp rightnp fillHeight">
			<div class="row products">
				<?php 
					$res = 0;
					if( isset( $_GET["menu_id"] ) ) {
						$menu_id = $_GET["menu_id"];

						if( isset( $_GET["sub_id"] ) ){
							$sub_id = $_GET["sub_id"];
						} else {
							$sub_id = null;
						}

						$res = getMenuProducts( $menu_id, $sub_id);
					} else {
						$res = getTotalProducts();
					}

					if( $res != 0){
						$products = $res;
					}
					
				?>
				
				<?php if( isset( $products ) ):?>
					<?php foreach( $products as $product ):?>
						<div class="small-2 large-4 columns">
					  		<div class="product">

					  			<p><?php echo $product['aTitle']; ?></p>

					  			<img src="<?php echo HTTP_PATH . $product["Image_name"]; ?>" class="product-img">
					  		</div>
					    </div>
					<?php endforeach;?>
				<?php endif;?>
			  

			</div>
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
					<div>
						<?php
							if(isset($enpnum)){
								if(function_exists( 'getEmployeFnameAndSname' )){
									$res = getEmployeFnameAndSname();

									if( $res != 0 ):?>
									<ul id="listNominators">
										<?php 
										foreach ($res as $key => $value):?>
											<li>
												<i class="fi-torso-business size-24"></i>
												<i>Individual</i>
												<p><?php echo $value['name']; ?></p>
											</li>

								  <?php endforeach; ?>
									</ul>
									<?php endif;
								}
							} 
						?>
					</div>
				</div>
				<div  class="callout panel" id="menu_container">
					<?php $menus = getMenuAllRows(); ?>
					<!-- <pre><?php var_dump($menus); ?></pre> -->
<<<<<<< HEAD
					
					<section class="block-list">
						<ul class="left-bar-nav">
							<?php foreach ($menus as $v): ?>
								<?php if ($v["parent"] == 0): ?>
									<li><a href="<?php echo "?menu_id=" . $v['id'] ; ?>"><?php echo $v["label"]; ?></a></li>
										<ul class="hide">
											<?php foreach ($menus as $val): ?>
												<?php if ($v["id"] == $val["parent"]): ?>
													<li><?php echo $val["label"]; ?></li>
												<?php endif; ?>
											<?php endforeach; ?>
										</ul>
								<?php endif; ?>
							<?php endforeach; ?>
						</ul>
					</section>
=======
					<ul class="left-bar-nav">
						<?php foreach ($menus as $v): ?>
							<?php if ($v["parent"] == 0): ?>
								<li><?php echo $v["label"]; ?></li>
									<ul>
										<?php foreach ($menus as $val): ?>
											<?php if ($v["id"] == $val["parent"]): ?>
												<li><?php echo $val["label"]; ?></li>
											<?php endif; ?>
										<?php endforeach; ?>
									</ul>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
>>>>>>> 583563fd21099138ae54b7c9dc990c4a9378fd31
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
