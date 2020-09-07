<?php

namespace Mpyw\HatenaBookmarkCleaner;

use Mpyw\HatenaBookmarkCleaner\Http\Client;
use Mpyw\HatenaBookmarkCleaner\OAuth\AuthorizationHeaderBuilder;
use Mpyw\HatenaBookmarkCleaner\OAuth\Credential;

class HatenaOAuthClient
{
    public const SCOPE_READ_PUBLIC = 'read_public';
    public const SCOPE_WRITE_PUBLIC = 'write_public';
    public const SCOPE_READ_PRIVATE = 'read_private';
    public const SCOPE_WRITE_PRIVATE = 'write_private';

    public Credential $credential;

    public function __construct(Credential $credential)
    {
        $this->credential = $credential;
    }

    public function acquireRequestToken(array $scopes): Credential
    {
        $endpoint = "https://www.hatena.com/oauth/initiate";

        $response = (new Client())->post($endpoint, [], [
            (new AuthorizationHeaderBuilder($this->credential))
                ->build('POST', $endpoint, ['oauth_callback' => 'oob'], []),
        ]);

        \parse_str($response, $parts);

        return new Credential(
            $this->credential->consumerKey,
            $this->credential->consumerSecret,
            $parts['oauth_token'],
            $parts['oauth_token_secret']
        );
    }

    public function acquireAccessToken(string $verifier): Credential
    {
        $endpoint = "https://www.hatena.com/oauth/token";

        $response = (new Client())->post($endpoint, [], [
            (new AuthorizationHeaderBuilder($this->credential))
                ->build('POST', $endpoint, ['oauth_verifier' => $verifier], []),
        ]);

        \parse_str($response, $parts);

        return new Credential(
            $this->credential->consumerKey,
            $this->credential->consumerSecret,
            $parts['oauth_token'],
            $parts['oauth_token_secret']
        );
    }

    public function useCredential(Credential $credential): void
    {
        $this->credential = $credential;
    }
}
