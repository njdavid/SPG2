<?php

        require_once __DIR__ . "/vendor/autoload.php";

        use GuzzleHttp\Client;
        use GuzzleHttp\RequestOptions;
	use Symfony\Component\Uid\Uuid;

	header('Content-Type: application/json; charset=utf-8');
        $array = [ 'returnStatus' => [
                                       'status' => 'SUCCESS',
				       'statusCode' => '000',
                                       'statusMessage' => 'Status Message: Sucesso 000',
                                       'statusDescription' => 'Status Description: Sucesso 000'
                                     ],
                   'merchantMessageIdentification' => 'njd_' . Uuid::v4(),
                   'merchantMessageDescription' => 'expt OTA',
                   'productAmount' => [
                                       'amount' => '11.00',
                                       'currency' => 'EUR'
                                      ],
                   'productExpeditionAmount' => [
                                                 'amount' => '2.30',
                                                 'currency' => 'EUR'
                                                ]
/*
		   ,'purchaseSummaryIndicator': false,
		   'purchaseAvailableIndicator': false
*/
                  ];

	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Allow-Origin: *');
	header('Cache-Control: no-cache');
	header('Content-Length:' . strlen(json_encode($array)));

        echo json_encode($array);

	http_response_code(200);
?>
