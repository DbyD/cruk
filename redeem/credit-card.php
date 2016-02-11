<?PHP 
include_once '../inc/config.php';
include_once '../inc/header.php';
include "lib.php";

$key = 'Cheer11Inside19Credit';
$url = 'https://gateway.fidelipay.co.uk/paymentform/';

if(isset($_POST["firstname"]) && isset($_POST["surname"]) && isset($_POST["address1"]) && isset($_POST["address2"]) && isset($_POST["town"]) && isset($_POST["postcode"]) && isset($_POST["telephone"]) && isset($_POST["email"])){
	$last_id = insertCreditCard( $_POST );
}
// set the correct amount. You only use the amount short. so if basket = £25 and you have £20 then amount is £5
if (!isset($_POST['responseCode'])) {
	$req = array( 'merchantID' => '102290', 'action' => 'SALE', 'type' => 1, 'amount' => 2000, 'countryCode' => 826, 'currencyCode' => 826, 'transactionUnique' => '12345', 'redirectURL' => HTTP_PATH . 'redeem/product-basket.php?basket=true&menu_id=', );
	// print_r($req);
	 
	$req['signature'] = createSignature($req, $key);
} 


function createSignature(array $data, $key) {
	// echo $key;
	ksort($data);
	$ret = http_build_query($data, '', '&');
	$ret = str_replace(array('%0D%0A', '%0A%0D', '%0D'), '%0A', $ret);
	return hash('SHA512', $ret . $key);
 }


$menu = new MenuGenerator;
$menu_id = $_GET["menu_id"];
$checkout = $_GET["checkout"];


$basket = getBasket( $_SESSION["user"]->EmpNum );

	if( isset( $_GET["menu_id"] ) ) {
		$menu_id = $_GET["menu_id"];
	}

	$val = $_SESSION['user']->administrator;

	if( $val == "YES" ){
		include('../admin/products.php');
	} else {					
?>
<?php echo '<form action="' . htmlentities($url) . '" method="post" name="ccresponse">' . PHP_EOL; ?>
<?php foreach ($req as $field => $value) :?>
		<input type="hidden" name="<?php echo $field; ?>" value="<?php echo htmlentities($value); ?>">
		<?php echo PHP_EOL; ?><br>
<?php endforeach; ?>
<?php echo PHP_EOL; ?>
</form>
<?php echo PHP_EOL; ?>
<?php } ?>
<script type="text/javascript">
	document.ccresponse.submit();
</script>
