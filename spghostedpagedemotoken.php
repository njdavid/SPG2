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
	$merchant_trx_id = "912345678";
	$trx_description = 'Auto ' . $merchant_trx_id;
	$amount = "1.23";
	$ROOT_URL = "https://api.qly.sibspayments.com/sibs/spg/v1-1";

	$RequestBody = '
	{
		"merchant":
			{ "terminalId": '.$tpa_id.', "channel": "web", "merchantTransactionId": "'.$merchant_trx_id.'"},
		"transaction":
			{ "transactionTimestamp": "'.getTimestampString().'", "description": "'.$trx_description.'", "moto": false, "paymentType": "PURS",
				"amount": { "value": '.$amount.', "currency": "EUR"},
				"paymentMethod": [ "MBWAY", "CARD", "REFERENCE" ],
				"paymentReference":
					{ "entity": "45361",
						"minAmount": { "value": ' . $amount . ', "currency": "EUR" },
            					"maxAmount": { "value": ' . $amount . ', "currency": "EUR" },
		            			"initialDatetime": "2023-02-06T00:00:00.000Z",
						"finalDatetime": "2023-12-31T00:00:00.000Z"
					}
		        },

		"tokenisation":
			{
				"tokenisationRequest":
					{ "tokeniseCard": true },
				"paymentTokens":
					[
						{
							"tokenType": "Card",
							"value": "qs9lAUPewl9I2IhobOFAGYWDgO4S2KBSZB6LQK02"
						},
						{
							"tokenType": "Card",
							"value": "9P4j6xsIgODnVNCBUhYIiSrFHQyPGEaju8OUA502"
						},
						{
                                                        "tokenType": "Card",
                                                        "value": "JJJ9Wa50tCUv0W4zD9jDBpBskOJFMAum3nTa6h02"
						}
					]
			}

	}';

	$httpClient = new Client();
	$response = $httpClient->post(
		$ROOT_URL."/payments",
		[
			"body" => $RequestBody,
			RequestOptions::HEADERS => [
				"Content-Type" => "application/json",
				"X-IBM-Client-Id" => $clientid,
				"Cache-Control" => "no-cache",
				"Authorization" => "Bearer " . $token,
			],
		]
	);

	$trxid = json_decode($response->getBody())->transactionID;
	$transactionSignature = json_decode($response->getBody())->transactionSignature;
	$formContext = json_decode($response->getBody())->formContext;

	header('Location: https://spg.ndavid.cloudns.ph/spg-form.php?transactionid=' . $trxid . '&spgcontext=' . $formContext);
	exit;

?>


