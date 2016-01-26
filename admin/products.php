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
						Most Recent Awards
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