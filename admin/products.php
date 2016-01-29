<?php 
	$res = 0;
	if( isset( $_GET["menu_id"] ) ) {
		$menu_id = $_GET["menu_id"];

		if( isset( $_POST['submit'] ) && isset( $_POST["sub_id"] ) ) {
			if( $_FILES['imageSub'] != null ){

				$res = insertImageSub( $_FILES['imageSub'], $_POST["sub_id"], $menu_id );
				if( $res ){
					updateSubImage( $res, $_POST["sub_id"] );
				}

			}
		}


		if( isset( $_GET["sub_id"] ) ){
			$sub_id = $_GET["sub_id"];
			$res = getMenuProducts( $menu_id, $sub_id);
		} else {
			$sub_id = null;
			$subs = getMenuSubs( $menu_id );
			$res = 0;
		}
		

	} else if(isset( $_GET["prID"] )){
		// $res = getProductByID( $_GET["prID"] );
		$res = getTotalProducts();
	}



	
	if( $res != 0){
		$products = $res;
	}




	

?>

<div id="content" class="large-8 large-push-2 columns">
	<div class="title withStar">
		Redeem
	</div>
	<div class="row contentFill">
		<div class="medium-12 columns leftnp rightnp fillHeight">

				<?php if(isset($subs) && count($subs) > 0 ): ?>

					<div class="row subs">
						<div class="small-12 large-12 columns" id="subsTitle">
							Subs
						</div>
						<?php foreach($subs as $sub): ?>

							<?php if( is_array( $sub ) ):?>
								
									<div class="small-4 large-6 columns">
										<div class="sub-menu">
											<p>
								  				<?php echo $sub['label']; ?>
											</p>
											<?php if($sub["sub_image"] == ""):?>
												<span>Not Image.</span>
											<?php else:?>
												<img src="<?php echo HTTP_PATH . $sub["sub_image"]; ?>">
											<?php endif;?>

											<form action="" method="post" enctype="multipart/form-data">

											  <div class="row">
											    <div class="large-12 columns">
											      <label>Image choose.
											        <input type="file" name="imageSub" />
											      </label>
											    </div>
											  </div>

											  <input type="hidden" name="sub_id" value="<?php echo $sub["id"]; ?>"/>

											  <div class="row">
											    <div class="large-12 columns">
											      <label>
											        <input type="submit" name="submit" value="update" class="right"/>
											      </label>
											    </div>
											  </div>

											</form>
										</div>
									</div>
		
								
							<?php endif; ?>

						<?php endforeach;?>
					</div>	
				<?php endif; ?>










				
				<?php if( isset( $products ) ):?>
				<div class="row products">
					<?php foreach( $products as $product ):?>
						
							<div class="small-2 large-4 columns">
						  		<div class="product">

						  			<p>
						  				<?php echo $product['aTitle']; ?>
									</p>

						  			<a href="<?php echo HTTP_PATH . 'redeem/products.php?prID=' . $product['prID']; ?>"><img src="<?php echo HTTP_PATH . $product["Image_name"]; ?>" class="product-img"></a>
						  		</div>
						    </div>
						
					<?php endforeach;?>
					</div>
				<?php endif;?>














			</div>
		
	</div>
	<?php if(isset($sub_id)):?>
	<div class="row">
		<div class="small-12 large-12 columns form-prduct">
			
			<form method="post" action="" enctype="multipart/form-data">
				<?php if(isset($error_message)) echo $error_message;?>
		      <h2>Add / Edit Products</h2>
			  <div class="row">
			    <div class="large-3 columns">
			      <label>Title: </label></div>
			        <div class="large-9 columns"><input type="text" placeholder="" name="title"/>
			    </div>
			  </div>
			  <div class="row">
			    <div class="large-3 columns">
			      <label>Image name: </label></div>
			        <div class="large-9 columns"><input type="file" placeholder=""  name="fileImage"/>
			    </div>
			  </div>
			  <div class="row">
			    <div class="large-3 columns">
			      <label>Value Options Points: </label></div>
			        <div class="large-9 columns"><input type="text" placeholder="" name="point"/>
			    </div>
			  </div>	
			  
			  <div class="row">
			    <div class="large-3 columns">
			      <label>Delivery: </label></div>
			     <div class="large-9 columns"> <input type="radio" name="Delivery" value="no" id="pokemonRed" checked><label for="pokemonRed">No</label>
			      <input type="radio" name="Delivery" value="yes" id="pokemonBlue"><label for="pokemonBlue">Yes</label>
			    </div>
			  </div>
			  <script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script> <script type="text/javascript">
			    bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
			  </script>
			  <div class="row">
			  		<div class="large-3 columns">
			  			<label>Main Content: </label>
			  		</div>
			 	 	<div class="large-9 columns">
			 	 	 	<textarea name="content" cols="40"></textarea>
			  		</div>
			  </div>
			  
			  	<input type="hidden" value="<?php echo $menu_id; ?>" name="menu_id"/>
			  		
			  	<input type="hidden" value="<?php echo $sub_id; ?>" name="sub_id"/>
			  		
			  
			  <div class="row">
			 	 	<div class="large-12 columns">
			 	 	 	<input type="submit" value="Save" name="submit"/>
			  		</div>
			  </div>

			</form>
			<hr />



		</div>
	</div>
	<?php endif;?>

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
					
	
				<?php
				$menu->db = $db;
				echo  $menu->Menu();
				?>


					
					
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