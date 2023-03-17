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

        $ROOT_URL = "https://api.qly.sibspayments.com/sibs/spg/v1-1";

	$RequestBody = "";

        $httpClient = new Client();
        $response = $httpClient->get(
                $ROOT_URL . "/payments/" . $_GET['transactionid'] . "/status",
                [
                        "debug" => false,
                        "body" => $RequestBody,
                        RequestOptions::HEADERS => [
                                "Content-Type" => "application/json",
                                "X-IBM-Client-Id" => $clientid,
                                "Cache-Control" => "no-cache",
                                "Authorization" => "Bearer " . $token,
                        ],
                ]
        );


/*
        echo nl2br($response->getBody() . "\n");
	echo nl2br($response->getStatusCode());
*/
        if (($response->getStatusCode() == 200) && (json_decode($response->getBody())->returnStatus->statusCode == "000"))
        {
                echo nl2br("OK: statuscode igual a 000" . "\n"); 
		echo nl2br("Estado: " . json_decode($response->getBody())->paymentStatus . "\n");
                echo nl2br("TPA: " . json_decode($response->getBody())->merchant->terminalId . "\n");
                echo nl2br("Transaction Id: " . json_decode($response->getBody())->transactionID . "\n");
                echo nl2br("Merchant Transaction Id: " . json_decode($response->getBody())->merchant->merchantTransactionId . "\n");

		/* "MBWAY", "CARD", "REFERENCE", "QRCODE", "TOKEN", "STATIC_QRCODE", "MANDATE" */
		switch (json_decode($response->getBody())->paymentMethod)
        	{
			case "REFERENCE":
				echo nl2br("Entidade: " . json_decode($response->getBody())->paymentReference->entity . "\n");
				echo nl2br("Referencia: " . json_decode($response->getBody())->paymentReference->reference . "\n");
				echo nl2br("Montante: " . json_decode($response->getBody())->amount->value . " " .  json_decode($response->getBody())->amount->currency . "\n");
				break;
			case "MBWAY":
				echo nl2br("Alias: " . json_decode($response->getBody())->token->value . "\n");
				break;
			case "CARD":
				echo nl2br("Pagamento com cartao" . "\n");
				break;
			default:
				echo nl2br("Montante: " . json_decode($response->getBody())->amount->value . " " .  json_decode($response->getBody())->amount->currency . "\n"); 
		}
	}
        else
        {
		echo nl2br("Http status code: " . $response->getStatusCode() . "\n");
                echo nl2br("ERROR: statuscode diferente de 000" + "\n");
        }

	echo nl2br("\n\n\n");
	echo nl2br(json_encode(json_decode($response->getBody()), JSON_PRETTY_PRINT) . "\n");
?>

