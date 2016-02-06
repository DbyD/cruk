<?php 
include_once '../inc/config.php';
include_once '../inc/header.php';
include "lib.php";
$menu = new MenuGenerator;

$basket = getBasket( $_SESSION["user"]->id );

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
					Checkout
				</div>
				<div class="row contentFill">
					<div class="medium-12 columns leftnp rightnp fillHeight">
						<p>Please enter your Billing details below.</p>
						<form action="<?php echo HTTP_PATH . 'redeem/credit-card.php?menu_id=' . $menu_id ?>" method="post">
						  
						  <div class="row">
						    <div class="small-8 columns">
						      <div class="row">
						        <div class="small-3 columns">
						          <label for="right-label" class="right inline">First Name(s):</label>
						        </div>
						        <div class="small-9 columns">
						          <input type="text" id="right-label" placeholder="Inline Text Input">
						        </div>
						      </div>
						    </div>
						  </div>	

						  <div class="row">
						    <div class="small-8 columns">
						      <div class="row">
						        <div class="small-3 columns">
						          <label for="right-label" class="right inline">Surname:</label>
						        </div>
						        <div class="small-9 columns">
						          <input type="text" id="right-label" placeholder="Inline Text Input">
						        </div>
						      </div>
						    </div>
						  </div>	

						  <div class="row">
						    <div class="small-8 columns">
						      <div class="row">
						        <div class="small-3 columns">
						          <label for="right-label" class="right inline">Adress Line 1:<br/><small>(or company name)</small></label>

						        </div>
						        <div class="small-9 columns">
						          <input type="text" id="right-label" placeholder="Inline Text Input">
						          <small>House name/number and street, P.O. box,company name, c/o</small>
						        </div>
						        
						      </div>
						    </div>
						  </div>

						  <div class="row">
						    <div class="small-8 columns">
						      <div class="row">
						        <div class="small-3 columns">
						          <label for="right-label" class="right inline">Adress Line 2:<br/><small>(optional)</small></label>

						        </div>
						        <div class="small-9 columns">
						          <input type="text" id="right-label" placeholder="Inline Text Input">
						          <small>Apartment, suite, unit, building,floor,etc</small>
						        </div>
						        
						      </div>
						    </div>
						  </div>

						  <div class="row">
						    <div class="small-8 columns">
						      <div class="row">
						        <div class="small-3 columns">
						          <label for="right-label" class="right inline">Town/City:</label>
						        </div>
						        <div class="small-9 columns">
						          <input type="text" id="right-label" placeholder="Inline Text Input">
						        </div>
						      </div>
						    </div>
						  </div>

						  <div class="row">
						    <div class="small-8 columns">
						      <div class="row">
						        <div class="small-3 columns">
						          <label for="right-label" class="right inline">Postcode:</label>
						        </div>
						        <div class="small-9 columns">
						          <input type="text" id="right-label" placeholder="Inline Text Input">
						        </div>
						      </div>
						    </div>
						  </div>

						  <div class="row">
						    <div class="small-8 columns">
						      <div class="row">
						        <div class="small-3 columns">
						          <label for="right-label" class="right inline">Telephone Number:</label>
						        </div>
						        <div class="small-9 columns">
						          <input type="text" id="right-label" placeholder="Inline Text Input">
						        </div>
						      </div>
						    </div>
						  </div>

						  <div class="row">
						    <div class="small-8 columns">
						      <div class="row">
						        <div class="small-3 columns">
						          <label for="right-label" class="right inline">E-Mail Adress:</label>
						        </div>
						        <div class="small-9 columns">
						          <input type="email" id="right-label" placeholder="Inline Text Input">
						        </div>
						      </div>
						    </div>
						  </div>

						  	  
						   
						   <button>PROCEED TO NEXT STEP</button>
						   <button>CONTINUE SHOPPING</button>
						</form>
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
