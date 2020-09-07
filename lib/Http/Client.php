<?php

namespace Mpyw\HatenaBookmarkCleaner\Http;

class Client
{
    public function get(string $url, array $params, array $headers): string
    {
        $ch = \curl_init();
        \curl_setopt_array($ch, [
            CURLOPT_URL => $url . '?' . \http_build_query($params, '', '&'),
            CURLOPT_HTTPHEADER => $headers,
        ]);

        return $this->run($ch);
    }

    public function post(string $url, array $params, array $headers): string
    {
        $ch = \curl_init();
        \curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => \http_build_query($params, '', '&'),
            CURLOPT_HTTPHEADER => \array_merge([
                'Content-Type: application/x-www-form-urlencoded',
            ], $headers),
        ]);

        return $this->run($ch);
    }

    protected function run($ch): string
    {
        \curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => 'gzip',
        ]);

        if (!$response = \curl_exec($ch)) {
            throw new \RuntimeException(\sprintf(
                'cURL Error(%s): %s',
                \curl_errno($ch),
                \curl_error($ch)
            ));
        }
        if (($status = \curl_getinfo($ch, CURLINFO_HTTP_CODE)) >= 400) {
            throw new \RuntimeException(\sprintf(
                'HTTP Error(%s): %s',
                $status,
                $response
            ));
        }

        return $response;
    }
}