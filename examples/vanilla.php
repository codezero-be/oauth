<?php

require_once __DIR__.'/../vendor/autoload.php';

$credentials = [
    'facebook' => [
        'key' => '',
        'secret' => '',
    ],
];

use CodeZero\OAuth\Authenticator;
use CodeZero\OAuth\ProviderFactory;

$providerFactory = new ProviderFactory($credentials);
$auth = new Authenticator($providerFactory);

$details = $auth->request('facebook');

if ($details) {
    $email = $details->getEmail();
    $firstName = $details->getFirstName();
    $lastName = $details->getLastName();
    // ...
} else {
    // User canceled!
}