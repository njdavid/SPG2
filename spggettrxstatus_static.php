<?php

require_once __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$token = '0276b80f950fb446c6addaccd121abfbbb.eyJlIjoiMTk4ODQ2NDA4MDk0NiIsInJvbGVzIjoiU1BHX09QRVJBVE9SIiwidG9rZW5BcHBEYXRhIjoie1wibWNcIjpcIjg3ODgyXCIsXCJ0Y1wiOlwiNTU3MTFcIn0iLCJpIjoiMTY3Mjg0NDg4MDk0NiIsImlzIjoiaHR0cHM6Ly9xbHkuc2l0ZTEuc3NvLnN5cy5zaWJzLnB0L2F1dGgvcmVhbG1zL1FMWS5NRVJDSC5QT1JUMSIsInR5cCI6IkJlYXJlciIsImlkIjoiYXlaWmV2eVp3azkzODIwNmZlYjM2MzRhMjk4Mjg2N2QxZjczMWY3YTcyIn0=.666de764046550ebf9cab3042e831a6c8f427f42f4162de3e04e73dabcd8968551a1de19bbcdfbb46f626dbc658b58b524b503a1e5acbb085805e97dccdec2b0';
$clientid = 'd0b06805-8371-47e2-80c8-946eaa083f2e';

$httpClient = new Client();

$response = $httpClient->get(
    'https://api.qly.sibspayments.com/sibs/spg/v1-1/payments/dVDm7dtMy3PNtKM1QpU6/status',
    [
        RequestOptions::HEADERS => [
            'Content-Type' => 'application/json',
	    'X-IBM-Client-Id' => $clientid,
	    'Cache-Control' => 'no-cache',
            'Authorization' => 'Bearer ' . $token,
        ]
    ]
);

print_r($response->getBody()->getContents());

?>
