
<?php
include_once '../inc/config.php';
include_once '../inc/header.php';
include "lib.php";
$menu = new MenuGenerator;

$val = $_SESSION['user']->administrator;

if( $val == "YES" ){

    include('../admin/products.php');
} else {
    $res = 0;
    if( isset( $_GET["menu_id"] ) ) {
        $menu_id = $_GET["menu_id"];
        $menu = getMenuRows( $menu_id );


        if( isset( $_GET["sub_id"] ) ){
            $sub_id = $_GET["sub_id"];
            $sub = getMenuSub( $sub_id );
            $res = getMenuProducts( $menu_id, $sub_id);
        } else {
            $sub_id = null;
        }

        $subs = getMenuSubs( $menu_id );
    }

    if( $res != 0){
        $products = $res;
    }
?>



<div id="content" class="large-8 large-push-2 columns">
	<div class="title withStar">
		<a href="<?php echo HTTP_PATH . 'redeem/'; ?>">Redeem</a>
        <?php echo (isset($menu[0]["label"])) ? "<a href=" . HTTP_PATH . 'redeem/products.php?menu_id=' . $menu_id . ">" . '/' . $menu[0]["label"]:'';?></a>
        <?php echo (isset($sub[0]["label"])) ? "<a href=" . HTTP_PATH . 'redeem/products.php?menu_id=' . $menu_id . "&sub_id=" . $sub_id . ">" . '/' . $sub[0]["label"]:'';?></a>

	</div>
	<div class="row contentFill">
		<div class="medium-12 columns leftnp rightnp fillHeight">

			<div class="row">
				<a id="viewBasket" class='<?php if($basket_isset) echo 'view-basket';?>' href="<?php echo HTTP_PATH . "redeem/product-basket.php?basket=true&menu_id=" . $menu_id; ?>">
				    <i class="fi-shopping-bag"></i>View basket
			    </a>
			</div>



				
				<?php if( isset( $products ) ):?>
                    <div class="row products">
                        <?php foreach( $products as $product ):?>

                                <div class="small-2 large-4 columns">
                                    <div class="callout panel product">

                                        <p><?php echo $product['aTitle']; ?></p>

                                        <a href="<?php echo HTTP_PATH . "redeem/product-basket.php?prID=" . $product["prID"] . "&menu_id=" . $menu_id; ?>">
                                            <img src="<?php echo HTTP_PATH . $product["Image_name"]; ?>" class="product-img">
                                        </a>
                                    </div>
                                </div>

                        <?php endforeach;?>
                    </div>
				<?php else:?>
                    <?php if( (isset($subs) && count($subs) > 0) && (!isset($sub_id))): ?>

                        <div class="row subs">

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
                                                <a href="<?php echo HTTP_PATH . "redeem/products.php?menu_id=" . $menu_id . "&sub_id=" . $sub["id"];?>"><img src="<?php echo HTTP_PATH . $sub["sub_image"]; ?>"></a>
                                            <?php endif;?>
                                        </div>
                                    </div>


                                <?php endif; ?>

                            <?php endforeach;?>
                        </div>
                    <?php endif; ?>
                <?php endif;?>
			  


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
									<li><a href="<?php echo "?menu_id=" . $v['id'] ; ?>"><?php echo $v["label"]; ?></a></li>
										<ul class="sub-menu <?php if( ( isset($menu_id) && $menu_id != $v["id"]) || (!isset($menu_id)) ) echo 'hide';?>">
											<?php foreach ($menus as $val): ?>
												<?php if ($v["id"] == $val["parent"]): ?>
													<li><a href="<?php echo "?menu_id=" . $v['id'] . "&sub_id=" . $val['id'] ; ?>"><?php echo $val["label"]; ?></a></li>
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
