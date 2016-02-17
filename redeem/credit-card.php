<?PHP 
include_once '../inc/config.php';
include_once '../inc/header.php';
include "lib.php";
?>
<div id="content" class="large-8 large-push-2 columns">
	<div id="formDiv" class="callout panel white">
		<div class="row">
			<div class="medium-12 withPadding columns">
				<p>Please wait while your order is being processed.</p>
				<p>You will be redirected to the credit card payment gateway.</p>
			</div>
		</div>
	</div>
</div>
<?php
$key = 'Cheer11Inside19Credit';
$url = 'https://gateway.fidelipay.co.uk/paymentform/';

if(isset($_POST)){	
	if(isset($_POST["firstname"]) && isset($_POST["surname"]) && isset($_POST["address1"]) && isset($_POST["address2"]) && isset($_POST["town"]) && isset($_POST["postcode"]) && isset($_POST["telephone"]) && isset($_POST["email"])){
		$_SESSION['cardForm'] = array(
									"firstname" => $_POST["firstname"],
									"surname" => $_POST["surname"],
									"address1" => $_POST["address1"],
									"address2" => $_POST["address2"],
									"town" => $_POST["town"],
									"postcode" => $_POST["postcode"],
									"telephone" => $_POST["telephone"],
									"email" => $_POST["email"]
								);
	}
}

$basket = getBasket( $_SESSION["user"]->EmpNum );
$total_price = 0;
foreach ($basket as $pr_b) {
	$total_price += $pr_b['aPrice'];
}
$sum_all = getAvailable( $_SESSION['user']->EmpNum ); 
$sum_credit_card = getCreditCard( $_SESSION['user']->EmpNum );
$sum_orders = getEmpBasketOrdersSum( $_SESSION['user']->EmpNum );
$remaining_amount = $sum_all + $sum_credit_card - $sum_orders;
$currect_amount = $total_price - $remaining_amount;

// set the correct amount. You only use the amount short. so if basket = £25 and you have £20 then amount is £5
if (!isset($_POST['responseCode'])) {
	$req = array( 'merchantID' => '102290', 'action' => 'SALE', 'type' => 1, 'amount' => intval($currect_amount . '00'), 'countryCode' => 826, 'currencyCode' => 826, 'transactionUnique' => md5(uniqid(rand(), true)), 'redirectURL' => HTTP_PATH . 'redeem/checkout.php?menu_id=&checkout=true');
	// print_r($req);
	 
	$req['signature'] = createSignature($req, $key);
}

if( isset( $_GET["menu_id"] ) ) {
	$menu_id = $_GET["menu_id"];
}

$val = $_SESSION['user']->administrator;
?>

<?php echo '<form action="' . htmlentities($url) . '" method="post" name="ccresponse">' . PHP_EOL; ?>
<?php foreach ($req as $field => $value) :?>
		<input type="hidden" name="<?php echo $field; ?>" value="<?php echo htmlentities($value); ?>">
		<?php echo PHP_EOL; ?><br>
<?php endforeach; ?>
<?php echo PHP_EOL; ?>
</form>
<?php echo PHP_EOL; ?>

<script type="text/javascript">
	document.ccresponse.submit();
</script>
