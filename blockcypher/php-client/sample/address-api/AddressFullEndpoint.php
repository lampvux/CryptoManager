<?php

// Run on console:
// php -f .\sample\address-api\AddressFullEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Client\AddressClient;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('096305d1e6e34f8890e1b70644ec7e9d'),
    array('mode' => 'sandbox', 'log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

$addressClient = new AddressClient($apiContext);
$fullAddress = $addressClient->getFullAddress('1BoatSLRHtKNngkdXEeobR76b53LETtpyT');

ResultPrinter::printResult("Get Full Address", "Full Address", $fullAddress->getAddress(), null, $fullAddress);