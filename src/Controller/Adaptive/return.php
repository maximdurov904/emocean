<?php require_once ("paypalplatform.php");
	$pay_key									=	$_SESSION['PAY_KEY'];	
	$request_array  							= 	array ("payKey"=>$pay_key,"requestEnvelope.errorLanguage"=>"en_US");
	$nvpStr										=	"&".http_build_query($request_array, '', '&');
	$resArray									=	hash_call("PaymentDetails",$nvpStr);
	echo "<pre>";
	print_r($resArray);
	die;

?>