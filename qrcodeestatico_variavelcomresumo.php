<?php

	require_once __DIR__ . "/vendor/autoload.php";

	use GuzzleHttp\Client;
	use GuzzleHttp\RequestOptions;
	use Symfony\Component\Uid\Uuid;


	/* function  declarations */
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

        function _log($text) {
                openlog('phpNJDscripts', LOG_CONS | LOG_NDELAY | LOG_PID, LOG_USER | LOG_PERROR);
                syslog(LOG_ERR, $text);
                closelog();
        }


	/* Main code */

	/*  Log request headers and post body content; check with command:
	   tail -f /var/log/syslog
	*/
        foreach (getallheaders() as $name => $value) {
                _log("$name: $value");
        }
        $body = file_get_contents('php://input');
        _log($body);

	/* Start
	*/


	if ((true) || ((!empty($body)) && (json_decode($body)->terminalCode == "55711")))
	{
		/*
			Doc SIBS versao preliminar:
			status: {"SUCCESS", "TECHNICAL_ERROR", "BAD_REQUEST", "QRCODE_NOT_FOUND", "QRCODE_UNAVAILABLE", "QRCODE_EXPIRED", "QRCODE_OUT_OF_STOCK"}
		*/


		$array = [
				'returnStatus' => [
							'status' => 'SUCCESS',
							'statusCode' => '000',
							'statusMessage' => 'Status Message: Sucesso 000',
							'statusDescription' => 'Status Description: Sucesso 000'
						  ],
				'merchantMessageIdentification' => 'njd_' . Uuid::v4(),
				'merchantMessageDescription' => 'Exemplo de resposta merchant a QR code valor variavel com consulta de mesa',
				'productAmount' => [
							   'amount' => '17.90',
							   'currency' => 'EUR'
						   ],
				'productExpeditionAmount' => [
								 'amount' => '0.31',
								 'currency' => 'EUR'
							     ],
				'purchaseSummaryIndicator' => true,
				'purchaseSummary' => [
							'purchaseSummaryDetail' => [
											[
												'detailOrder' => 1,
												'detailQuantity' => 3,
												'detailDescription' => 'Sopa',
												'detailAmount' => 2.20
											],
											[
												'detailOrder' => 2,
												'detailQuantity' => 2,
												'detailDescription' => 'Prato principal',
												'detailAmount' => 5.00
											],
											[
												'detailOrder' => 3,
												'detailQuantity' => 1,
												'detailDescription' => 'Cafe',
												'detailAmount' => 1.30
											]
										 ]
						    ],
				'purchaseAvailableIndicator' => true
			];

	}
	else
	{
		$array = [
				'returnStatus' => [
							'status' => 'QRCODE_OUT_OF_STOCK',
							'statusCode' => '002',
							'statusMessage' => 'Status Message: QRCODE_NOT_FOUND 001',
							'statusDescription' => 'Status Description: QRCODE_NOT_FOUND 001'
						  ]
			];
	}

	header('Content-Type: application/json; charset=utf-8');
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Allow-Origin: *');
	header('Cache-Control: no-cache');
	header('Content-Length:' . strlen(json_encode($array)));

	echo json_encode($array);

	http_response_code(200);

	_log( "****Resposta json ao PMS MB WAY");
	_log(json_encode($array));

?>
