<?php

// Run on console:
// php -f .\sample\address-api\AddressEndpoint.php

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
$address = $addressClient->get('1E4ryZV94JVKMCbCvs9pS2xL8e1YSMrvMv');

ResultPrinter::printResult("Get Address", "Address", $address->getAddress(), null, $address);