<?php
$FROM = $_REQUEST['from'];
$TO = $_REQUEST['to'];

if ( $FROM == $TO ) {
			echo 1;
} else {

			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "http://api.fixer.io/latest?base=".$FROM,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"cache-control: no-cache"
				),
			));
			
			$response = curl_exec($curl);
			$err = curl_error($curl);
			
			curl_close($curl);
			
			$response = json_decode($response, true); //because of true, it's in an array
			echo $response['rates'][$TO];
}