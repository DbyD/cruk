<?php
////////////////////////////////////////////////////////////////////////////////////
// send email
function sendEmail($content,$emailTo,$subject,$Bcc){
	$strFrom = "From: alec@iceimages.co.za \r\nContent-type: text/html; charset=us-ascii";
	
	$message = '<!DOCTYPE HTML><html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    			<title>CRUK Our Heroes</title>
				<style type=text/css>
					body,div {background:#eaedf2;margin:0px;padding:0px}
					.emailText {font-size:9pt;font-family:Arial;line-height:12pt;color:#2e008b;background:#fff;width:560px;min-height:360px;padding:20px;}
					img{display:block}
				</style></head><body><div align="center"><div class="emailText">';
				
	$message .= $content;
	$message .= "</div></div></body></html>";
	
	if (mail($emailTo, $subject, $message, $strFrom)){
		$reply = "success";
	} else {
		$reply = "fail";
	}
	return $reply;
}
////////////////////////////////////////////////////////////////////////////////////
$sig = 'Color19Trust35Actor';
function createSignature(array $data, $sig) {
	//echo $sig;
	//  Sort by field name 
	ksort($data);
	//  Create the URL encoded signature string 
	$ret = http_build_query($data, '', '&');
	//  Normalise all line endings (CRNL|NLCR|NL|CR) to just NL (%0A) 
	$ret = str_replace(array('%0D%0A', '%0A%0D', '%0D'), '%0A', $ret);
	//  Hash the signature string and the key together 
	return hash('SHA512', $ret . $sig);
 }
 $req = array( 'currencyCode' => 826);
 $mysend = createSignature($req, $sig);
 echo  $mysend;
 
 //$myresult = createSignature($mysend, $sig);
 //print_r($myresult);
 
 
////////////////////////////////////////////////////////////////////////////////////
define('ENCRYPTION_KEY', 'd0a7e7997b6d5fcd55f4b5c32611b87cd923e88837b63bf2941ef819dc8ca282');
// Encrypt Function
function mc_encrypt($encrypt, $key){
    $encrypt = serialize($encrypt);
    $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
    $key = pack('H*', $key);
    $mac = hash_hmac('sha256', $encrypt, substr(bin2hex($key), -32));
    $passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $encrypt.$mac, MCRYPT_MODE_CBC, $iv);
    $encoded = base64_encode($passcrypt).'|'.base64_encode($iv);
    return $encoded;
}
// Decrypt Function
function mc_decrypt($decrypt, $key){
    $decrypt = explode('|', $decrypt.'|');
    $decoded = base64_decode($decrypt[0]);
    $iv = base64_decode($decrypt[1]);
    if(strlen($iv)!==mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)){ return false; }
    $key = pack('H*', $key);
    $decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));
    $mac = substr($decrypted, -64);
    $decrypted = substr($decrypted, 0, -64);
    $calcmac = hash_hmac('sha256', $decrypted, substr(bin2hex($key), -32));
    if($calcmac!==$mac){ return false; }
    $decrypted = unserialize($decrypted);
    return $decrypted;
}
$data = 'alec encryption test';
$encrypted_data = mc_encrypt($data, ENCRYPTION_KEY);
echo '<h2>Example #1: String Data</h2>';
echo 'Data to be Encrypted: ' . $data . '<br/>';
echo 'Encrypted Data: ' . $encrypted_data . '<br/>';
echo 'Decrypted Data: ' . mc_decrypt($encrypted_data, ENCRYPTION_KEY) . '</br>';
$data = array(1, 5, 8, 9, 22, 10, 61);
$encrypted_data = mc_encrypt($data, ENCRYPTION_KEY);
echo '<h2>Example #2: Non-String Data</h2>';
echo 'Data to be Encrypted: <pre>';
print_r($data);
echo '</pre><br/>';
echo 'Encrypted Data: ' . $encrypted_data . '<br/>';
echo 'Decrypted Data: <pre>';
print_r(mc_decrypt($encrypted_data, ENCRYPTION_KEY));
echo '</pre>';
////////////////////////////////////////////////////////////////////////////////////

$string = "alec encryption test";
$secret_key = "xexecrewardsanddigitalbydesign";
// Create the initialization vector for added security.
$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
// Encrypt $string
$encrypted_string = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $secret_key, $string, MCRYPT_MODE_CBC, $iv);
// Decrypt $string
$decrypted_string = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $secret_key, $encrypted_string, MCRYPT_MODE_CBC, $iv);
echo "Original string : " . $string . "<br />\n";
echo "Encrypted string : " . BIN2HEX($encrypted_string) . "<br />\n";
echo "Decrypted string : " . $decrypted_string . "<br />\n";
////////////////////////////////////////////////////////////////////////////////////
$string1 = "alec encryption test";
$secret_key1 = "xexecrewardsanddigitalbydesign";
 // Encryption Algorithm
$etype1 = MCRYPT_RIJNDAEL_256;
 // Create the initialization vector for added security.
$iv1 = mcrypt_create_iv(mcrypt_get_iv_size($etype1, MCRYPT_MODE_ECB), MCRYPT_RAND);
 // Output original string
PRINT "Original string: $string <p>";
 // Encrypt $string
$encrypted_string1 = mcrypt_encrypt($etype1, $secret_key1, $string1, MCRYPT_MODE_CBC, $iv1);
 // Convert to hexadecimal and send to browser
PRINT "Encrypted string: ".BIN2HEX($encrypted_string1)."<p>";
 $decrypted_string1 = mcrypt_decrypt($etype1, $secret_key1, $encrypted_string1, MCRYPT_MODE_CBC, $iv1);
 PRINT "Decrypted string is: $decrypted_string";
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
?>