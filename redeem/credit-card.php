<?PHP 
// Signature key entered on MMS. The demo accounts is fixed to this value, 
$key = 'Cheer11Inside19Credit';
 
//  Gateway URL 
$url = 'https://gateway.fidelipay.co.uk/paymentform/';


echo '<pre>';
// var_dump($_POST);
echo '</pre>';

 
if (!isset($_POST['responseCode'])) {
//  Send request to gateway
//  Request 
	$req = array( 'merchantID' => '102290', 'action' => 'SALE', 'type' => 1, 'amount' => 2000, 'countryCode' => 826, 'currencyCode' => 826, 'transactionUnique' => '12345', 'redirectURL' => 'http://alec_win7/visavouchers/credit-card-response.asp', );
	print_r($req);
	
//  Create the signature using the function called below. 
	$req['signature'] = createSignature($req, $key);
	echo "<br>".$req['signature'];
	
	echo '<form action="' . htmlentities($url) . '" method="post">' . PHP_EOL;
	foreach ($req as $field => $value) { 
		echo $field.' <input type="text" name="' . $field . '" value="' . htmlentities($value) . '">' . PHP_EOL . "<br>";
	} 
	echo ' <input type="submit" value="Pay Now">' . PHP_EOL;
	echo '</form>' . PHP_EOL;
} else {
	//  Handle the response posted back 
	$res = $_POST;
 
	//  Extract the return signature as this isn't hashed 
	$signature = null;
	if (isset($res['signature'])) { 
		$signature = $res['signature'];
		unset($res['signature']);
	}
  // Check the return signature 
	if (!$signature || $signature !== createSignature($res, $key)) {
		//  You should exit gracefully 
		die('Sorry, the signature check failed');
	}
	//  Check the response code 
	if ($res['responseCode'] === "0") { 
		echo "<p>Thank you for your payment.</p>";
	} else { 
		echo "<p>Failed to take payment: " . htmlentities($res['responseMessage']) . "</p>";
	}
}

//  Function to create a message signature 
function createSignature(array $data, $key) {
	echo $key;
	//  Sort by field name 
	ksort($data);
	//  Create the URL encoded signature string 
	$ret = http_build_query($data, '', '&');
	//  Normalise all line endings (CRNL|NLCR|NL|CR) to just NL (%0A) 
	$ret = str_replace(array('%0D%0A', '%0A%0D', '%0D'), '%0A', $ret);
	//  Hash the signature string and the key together 
	return hash('SHA512', $ret . $key);
 }
?>