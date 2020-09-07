<?php

namespace Mpyw\HatenaBookmarkCleaner\OAuth;

class AuthorizationHeaderBuilder
{
    protected Credential $credential;

    public function __construct(Credential $credential)
    {
        $this->credential = $credential;
    }

    public function build(string $method, string $endpoint, array $oauthParams, array $params): string
    {
        $oauthParams += [
            'oauth_consumer_key' => $this->credential->consumerKey,
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => \time(),
            'oauth_version' => '1.0',
            'oauth_nonce' => \bin2hex(\openssl_random_pseudo_bytes(16)),
        ];

        if ($this->credential->token !== '') {
            $oauthParams['oauth_token'] = $this->credential->token;
        }

        $oauthParams['oauth_signature'] = (new Signer($this->credential))->sign(
            $method,
            $endpoint,
            $oauthParams,
            $params
        );

        return 'Authorization: OAuth ' . \implode(', ', \array_map(
            fn ($name, $value) => \sprintf('%s="%s"', \urlencode($name), \urlencode($value)),
            \array_keys($oauthParams),
            $oauthParams
        ));
    }
}
