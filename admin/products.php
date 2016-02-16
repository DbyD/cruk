<?php 
	

	$res = 0;
	if( isset( $_GET["menu_id"] ) ) {

		$menu_id = $_GET["menu_id"];
		
		
		if( isset( $_POST['submit_sub_change'] )  && isset( $_POST["sub_id"] ) ) {
			$res = array();


			
			
			if( !empty($_FILES['imageSub']['name']) ){
				$path = insertImageSub( $_FILES['imageSub'], $_POST["sub_id"], $menu_id );
				$res["sub_image"] = $path;
			}

		

			

			$res["id"] = $_POST["sub_id"];
			$res["label"] = $_POST["nameSub"];


			updateSubImageAndName( $res );
				
		}



		if( isset( $_POST["submit"] ) ){
			$content = trim($_POST["content"]);

			if( empty( $_POST["title"] ) || empty( $_POST["point"] ) || empty( $_POST["Delivery"] ) || empty( $content ) ){
				$error_message = "<div class='error'>Please fill in all fields</div>";
			} else {

				if( isset($_POST["sub_id"] ) ){
					$sub_id_insert = $_POST["sub_id"];
				} else {
					$sub_id_insert = NULL;
				}
				
				
				
				$data = array(
					'aTitle' => $_POST["title"],
					'aPrice' => $_POST["point"],
					'delivery' => $_POST["Delivery"],
					'aContent' => $_POST["content"],
					'menuID' => $_POST["menu_id"],
					'subID' => $sub_id_insert
				);

				
				if( !empty( $_FILES["fileImage"]['name'] ) ){
					$file_path = insertFile(  $_POST["menu_id"], $sub_id_insert );
					$data['Image_name'] = $file_path;
				}


				if( isset( $_POST["prID"] ) ) {
					$data['prID'] = $_POST["prID"];

					if( $sub_id_insert == 'other'){
						$data['subID'] = NULL;
					}

					updateProduct( $data );
				} else {
					insertProduct( $data );
				}
					
				

				
			}
		}


		if( isset( $_GET["sub_id"] ) ){
			$sub_id = $_GET["sub_id"];
		} else {
			$sub_id = null;
			$subs = getMenuSubs( $menu_id );
		}
		
		
		$res = getMenuProducts( $menu_id, $sub_id);
		
		if( isset( $_GET["prID"] ) ){
			$pr = getProductByID( $_GET["prID"] );
		}


	} else {
		$res = getTotalProducts();
	}

	if( $res != 0){
		$products = $res;
	}


?>

<div id="content" class="large-8 large-push-2 columns">
	<div class="title withStar">
		<div class="title">
			<div class="inlineDiv clickAble" data-type="gourl" data-url="<?php echo HTTP_PATH . 'redeem/'; ?>">Shop</div>
			<i class="icon-icons_thickrightarrow smalli"></i>
			
			
			<?php
				$menuInfo = getMenuRows( $menu_id );
				if ( isset( $sub_id ) ) {
					$subInfo = getMenuSub( $sub_id );
					echo '<div class="inlineDiv clickAble submenu" data-type="gourl" data-url="' . HTTP_PATH . 'redeem/products.php?menu_id=' . $menu_id . '">'. $menuInfo[0]["label"] . '</div> ';
					echo '<i class="icon-icons_thickrightarrow smalli"></i> <span class="subSubTitle">' . $subInfo[0]["label"] . '</span>';
				} else {
					echo '<span class="subSubTitle">' . $menuInfo[0]["label"] . '</span>';
				} 

				$time = time();
			?>
		</div>
	</div>
	<div class="row contentFill mCustomScrollbar height605 " data-mcs-theme="dark-2">
		<div class="medium-12 columns leftnp rightnp fillHeight productCats">

				<?php if( isset($subs) && count($subs) > 0 ): ?>

					<div class="row subs">
						<div class="small-12 large-12 columns" id="subsTitle">
							Subs
						</div>

						<?php foreach($subs as $sub): ?>

							<?php if( is_array( $sub ) ):?>
								
									<div class="small-2 large-4 columns">
										<div class="callout panel product">
											<p>
								  				<?php echo $sub['label']; ?>
											</p>
											<?php if($sub["sub_image"] == ""):?>
												<span>Not Image.</span>
											<?php else:?>
												<img src="<?php echo HTTP_PATH . $sub["sub_image"]; ?>?<?=$time?>">
											<?php endif;?>

											<form action="" method="post" enctype="multipart/form-data">

											  <div class="row">
											    <div class="large-12 columns">
											      <label>Sub name.
											        <input type="text" name="nameSub" value="<?php echo $sub['label']; ?>"/>
											      </label>
											    </div>
											  </div>
												

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
											        <input type="submit" name="submit_sub_change" value="update" class="right"/>
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
					<div class="small-12 large-12 columns" id="subsTitle">
						Products
					</div>
					<?php foreach( $products as $product ):?>
						
							<div class="small-2 large-4 columns">
						  		<div class="product">

						  			<p>
						  				<?php echo $product['aTitle']; ?>
									</p>

									<?php if(isset($sub_id)):?>
						  				<a href="<?php echo HTTP_PATH . 'redeem/products.php?menu_id=' . $menu_id . '&sub_id=' . $sub_id . '&prID=' . $product['prID']; ?>"><img src="<?php echo HTTP_PATH . $product["Image_name"]; ?>" class="product-img"></a>
						  				<a href="http://cruk.loc/redeem/product-basket.php?prID=<?php echo $product['prID'];?>&menu_id=<?php echo $menu_id;?>">Add basket</a>
						  			<?php else:?>
						  				<a href="<?php echo HTTP_PATH . 'redeem/products.php?menu_id=' . $menu_id . '&prID=' . $product['prID']; ?>"><img src="<?php echo HTTP_PATH . $product["Image_name"]; ?>" class="product-img"></a>
						  			<?php endif;?>
						  			
						  		</div>
						    </div>
						
					<?php endforeach;?>
					</div>
				<?php endif;?>

			</div>
		
	
	<div class="row">
		<div class="small-12 large-12 columns form-prduct">

			<form method="post" action="" enctype="multipart/form-data">
				<?php if(isset($error_message)) echo $error_message;?>
		      <h2>Add / Edit Products</h2>
			  <div class="row">
			    <div class="large-3 columns">
			      <label>Title: </label></div>
			        <div class="large-9 columns"><input type="text" placeholder="" name="title" value="<?php echo isset( $pr['aTitle'] ) ? $pr['aTitle'] : ''; ?>"/>
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
			        <div class="large-9 columns">
			        	<input type="text" placeholder="" name="point" value="<?php echo isset( $pr['aPrice'] ) ? $pr['aPrice'] : ''; ?>" />
			    </div>
			  </div>
			  <?php if(isset($subs) && !is_null($subs)):?>
				  <div class="row">
				    <div class="large-3 columns">
				      <label>CHoose Sub menu</label></div>
				      <div class="large-9 columns">
				        <select name="sub_id">
				        	<option value="other">--Select--</option>
				        	<?php foreach($subs as $sub): ?>
								<?php if( is_array( $sub ) ):?>
									<option value="<?php echo $sub["id"]; ?>"><?php echo $sub['label']; ?></option>
								<?php endif; ?>
							<?php endforeach;?>
				        </select>
				    </div>
				  </div>
			  <?php endif;?>
			  
			  <div class="row">
			    <div class="large-3 columns">
			     <label>Delivery: </label></div>
			     <div class="large-9 columns"> 
			     	<input type="radio" name="Delivery" value="no" id="pokemonRed" <?php echo ( isset( $pr['delivery'] ) && $pr['delivery'] == 'no') ? 'checked' : ''; ?> >
			     <label for="pokemonRed">No</label>
			      	<input type="radio" name="Delivery" value="yes" id="pokemonBlue" <?php echo ( isset( $pr['delivery'] ) && $pr['delivery'] == 'yes') ? 'checked' : ''; ?> >
			      	<label for="pokemonBlue">Yes</label>
			    </div>
			  </div>
			  <script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script>
			  <script type="text/javascript">
			    bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
			  </script>
			  <div class="row">
			  		<div class="large-3 columns">
			  			<label>Main Content: </label>
			  		</div>
			 	 	<div class="large-9 columns">
			 	 	 	<textarea name="content" cols="40">
			 	 	 		<?php echo isset( $pr['aContent'] ) ? $pr['aContent'] : ''; ?>
			 	 	 	</textarea>
			  		</div>
			  </div>

			  	<?php if( isset( $pr['prID']) ):?>
			  		<input type="hidden" value="<?php echo $pr['prID']; ?>" name="prID"/>
			  	<?php endif;?>
			  
			  	<input type="hidden" value="<?php echo $menu_id; ?>" name="menu_id"/>

			  	<?php if(isset($sub_id)):?>	
			  		<input type="hidden" value="<?php echo $sub_id; ?>" name="sub_id"/>
			  	<?php endif;?>	
			  
			  <div class="row">
			 	 	<div class="large-12 columns">
			 	 	 	<input type="submit" value="Save" name="submit"/>
			  		</div>
			  </div>

			</form>

			<hr />



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
					<div class="price-panel">
						<!-- <i class="icon-icons_trophy"></i> -->
						<?php 
						$sum_all = getAvailable( $_SESSION['user']->EmpNum ); 
						$sum_credit_card = getCreditCard( $_SESSION['user']->EmpNum );
						$sum_orders = getEmpBasketOrdersSum( $_SESSION['user']->EmpNum );


						$remaining_amount = $sum_all + $sum_credit_card - $sum_orders;
						echo '&pound;' . ' ' . $remaining_amount;
						?> 
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
<script src="<?=HTTP_PATH?>js/redeem.js"></script>



</body>
</html>