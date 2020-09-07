<?php

namespace Mpyw\HatenaBookmarkCleaner\OAuth;

class Credential
{
    public string $consumerKey;
    public string $consumerSecret;
    public string $token;
    public string $tokenSecret;

    public function __construct(string $consumerKey, string $consumerSecret, string $token = '', string $tokenSecret = '')
    {
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
        $this->token = $token;
        $this->tokenSecret = $tokenSecret;
    }
}
