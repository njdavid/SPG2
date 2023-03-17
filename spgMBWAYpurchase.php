<?php

	require_once __DIR__ . "/vendor/autoload.php";

	use GuzzleHttp\Client;
	use GuzzleHttp\RequestOptions;

	function getTimestampString() {
		$milliseconds = microtime(true);
		// Round to integer 
		$timestamp = floor($milliseconds);
		// Get number after dots
		$uuuu = preg_replace("/\d+\./", "", "$milliseconds");
		// Get last 3 number decimal place
		$u = substr($uuuu, 0, 3);
		// Print date by the timestamp timestamp
		return date("Y-m-d\TH:i:s", $timestamp). ".{$u}Z";
    }


	$token =
		"0276b80f950fb446c6addaccd121abfbbb.eyJlIjoiMTk4ODQ2NDA4MDk0NiIsInJvbGVzIjoiU1BHX09QRVJBVE9SIiwidG9rZW5BcHBEYXRhIjoie1wibWNcIjpcIjg3ODgyXCIsXCJ0Y1wiOlwiNTU3MTFcIn0iLCJpIjoiMTY3Mjg0NDg4MDk0NiIsImlzIjoiaHR0cHM6Ly9xbHkuc2l0ZTEuc3NvLnN5cy5zaWJzLnB0L2F1dGgvcmVhbG1zL1FMWS5NRVJDSC5QT1JUMSIsInR5cCI6IkJlYXJlciIsImlkIjoiYXlaWmV2eVp3azkzODIwNmZlYjM2MzRhMjk4Mjg2N2QxZjczMWY3YTcyIn0=.666de764046550ebf9cab3042e831a6c8f427f42f4162de3e04e73dabcd8968551a1de19bbcdfbb46f626dbc658b58b524b503a1e5acbb085805e97dccdec2b0";
	$clientid = "d0b06805-8371-47e2-80c8-946eaa083f2e";
	
	$tpa_id = "55711";
	$merchant_trx_id = "912345679";
	$trx_description = "ANSR - Pagamento de notificacao";
	$amount = "0.05";
	$ROOT_URL = "https://api.qly.sibspayments.com/sibs/spg/v1-1/";
	$MBWAY_ALIAS = "351#910542593";

	$RequestBody = '
	{
		"merchant": 
			{ "terminalId": '.$tpa_id.', "channel": "web", "merchantTransactionId": "'.$merchant_trx_id.'"},
		"transaction": 
			{ "transactionTimestamp": "'.getTimestampString().'", "description": "'.$trx_description.'", "moto": false, "paymentType": "PURS",
				"amount": { "value": '.$amount.', "currency": "EUR"},
				"paymentMethod": [ "MBWAY" ]
			}
	}';

	echo "<<< body";
	echo $RequestBody;
	echo ">>> body";

	$httpClient = new Client();
	$response = $httpClient->post(
		$ROOT_URL."payments",
		[
			"debug" => true,
			"body" => $RequestBody,
			RequestOptions::HEADERS => [
				"Content-Type" => "application/json",
				"X-IBM-Client-Id" => $clientid,
				"Cache-Control" => "no-cache",
				"Authorization" => "Bearer " . $token,
			],
		]
	);

	/*print_r($response->getBody()->getContents());*/

	$trxid = json_decode($response->getBody())->transactionID;
	$transactionSignature = json_decode($response->getBody())->transactionSignature;	
	
	print_r($trxid);

	/*echo getTimestampString();*/

	if (json_decode($response->getBody())->returnStatus->statusCode == "000")
	{
		echo "OK: statuscode igual a 000; avancar com MB WAY purchase";
		
		$RequestBody = '
		{
			"customerPhone": "'.$MBWAY_ALIAS.'"
		}';
		
		echo "<<< body";
		echo $RequestBody;
		echo ">>> body";
		$response = $httpClient->post(
			$ROOT_URL."payments/".$trxid."/mbway-id/purchase",
			[
				"debug" => true,
				"body" => $RequestBody,
				RequestOptions::HEADERS => [
					"Content-Type" => "application/json",
					"X-IBM-Client-Id" => $clientid,
					"Cache-Control" => "no-cache",
					"Authorization" => "Digest " . $transactionSignature,
				],
			]
		);
	}
	else
	{
		echo "ERROR: statuscode diferente de 000";
	}



?>

