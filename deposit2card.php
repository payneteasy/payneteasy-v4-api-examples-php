<?php
/*
 * Copyright 2017 PaynetEasy
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * This is an example of PaynetEasy transfer-by-ref v4 API usage.
 *
 * This API uses OAuth 1.0a to sign merchant requests.
 *
 * The only signature method supported by this API is RSA-SHA256.
 * This signature method is non-standard, but after sha1 was successfully
 * attacked in real life, we need a more secure algorithm, hence RSA-SHA256.
 * It is supported by the included library (tmhOAuth). The latest version of
 * this library may be obtained at https://github.com/themattharris/tmhOAuth
 *
 * Note that to work with https URLs, tmhOAuth requires cacert.pem to be present
 * in the current directory (and PaynetEasy servers are only accessible using
 * https). We ship cacert.pem file with our examples, but it may get outdated.
 * You can always obtain actual cacert.pem from
 * http://curl.haxx.se/ca/cacert.pem
 * If you're getting HTTP 0 responses, please check that cacert.pem exists,
 * readable and is not outdated.
 *
 * Private key is expected to be stored in a file; it must be in PEM format.
 * The strength of this RSA key must be at least 2048 bits.
 * An example of such a file is in test-private-key.pem
 *
 */

include 'tmhOAuth.php';

/*
 * Endpoint config follows
 */
$serverHost = 'sandbox.payneteasy.com';
$endpointId = 1; // *replace with your endpointId*
$merchantLogin = '<your-merchant-login>';
$private_key_pem = file_get_contents('test-private-key.pem');

$oauth = new tmhOAuth();
$oauth->reconfigure(array(
	'consumer_key' => $merchantLogin,
	'oauth_signature_method' => 'RSA-SHA256',
	'private_key_pem' => $private_key_pem
));

// uncomment the following line to see the configuration before the request

//print_r($oauth);
//echo "\n";

$params = array(
        'client-order-id' => 'transfer-' . uniqid(),
	'amount' => '100',
	'currency' => 'RUB',
        'order_desc' => 'Consumer credit',
        'destination-card-no' => '4444333322221111'
);

$status = $oauth->request('POST', "https://$serverHost/paynet/api/v4/transfer-by-ref/$endpointId", $params);
//echo($status . "\n");

// Uncomment the following line to see logs and response

//print_r($oauth);
//echo "\n";

if ($status == 0) {
 	throw new Exception('Could not make an HTTP request; please inspect $oauth object to see what happened');
} else if ($status != 200) {
	throw new Exception('Non-successful HTTP status ' . $status . '; please inspect $oauth object to see what happened');
}

echo "OAuth successful\n";

// TODO: now the response has to be parsed, handled, and if it's
// 'async-response', /status has to be polled

?>
