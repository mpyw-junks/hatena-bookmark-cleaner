<?php

use Mpyw\HatenaBookmarkCleaner\HatenaOAuthClient;
use Mpyw\HatenaBookmarkCleaner\IO;
use Mpyw\HatenaBookmarkCleaner\OAuth\Credential;

require_once __DIR__ . '/vendor/autoload.php';

$client = new HatenaOAuthClient(new Credential(
    IO::input('Consumer Key: '),
    IO::input('Consumer Secret: '),
    IO::input('Access Token: '),
    IO::input('Access Token Secret: ')
));

// ...
