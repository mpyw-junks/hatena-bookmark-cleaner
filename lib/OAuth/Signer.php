<?php

namespace Mpyw\HatenaBookmarkCleaner\OAuth;

class Signer
{
    protected Credential $credential;

    public function __construct(Credential $credential)
    {
        $this->credential = $credential;
    }

    public function sign(string $method, string $endpoint, array $oauthParams, array $params): string
    {
        $base = $oauthParams + $params;
        $key = [$this->credential->consumerSecret, $this->credential->tokenSecret];
        \ksort($base);

        return \base64_encode(\hash_hmac(
            'sha1',
            \implode('&', \array_map('rawurlencode', [
                $method,
                $endpoint,
                \http_build_query($base, '', '&', \PHP_QUERY_RFC3986)
            ])),
            \implode('&', \array_map('rawurlencode', $key)),
            true
        ));
    }
}

