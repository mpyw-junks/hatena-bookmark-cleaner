<?php

use Mpyw\HatenaBookmarkCleaner\HatenaOAuthClient;
use Mpyw\HatenaBookmarkCleaner\IO;
use Mpyw\HatenaBookmarkCleaner\OAuth\Credential;

require_once __DIR__ . '/vendor/autoload.php';
\error_reporting(-1);

$client = new HatenaOAuthClient(new Credential(
    IO::input('Consumer Key: '),
    IO::input('Consumer Secret: ')
));

$client->useCredential($client->acquireRequestToken([
    HatenaOAuthClient::SCOPE_READ_PUBLIC,
    HatenaOAuthClient::SCOPE_WRITE_PUBLIC,
    HatenaOAuthClient::SCOPE_READ_PRIVATE,
    HatenaOAuthClient::SCOPE_WRITE_PRIVATE,
]));

echo 'Access https://www.hatena.ne.jp/oauth/authorize?oauth_token=' . \urlencode($client->credential->token) . "\n";
$verifier = IO::input('PIN: ');

$client->useCredential($client->acquireAccessToken($verifier));

echo \json_encode($client->credential, JSON_PRETTY_PRINT) . "\n";
