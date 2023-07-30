<?php

declare(strict_types=1);

namespace App\FbaClient;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\RequestOptions;

class ClientFactory
{
    public static function makeDefault(Config $config): Client
    {
        $httpClientConfig = [
            'base_uri'                      => $config->baseUri,
            RequestOptions::CONNECT_TIMEOUT => $config->connectTimeout,
            RequestOptions::DELAY           => 300,
            RequestOptions::HTTP_ERRORS     => false,
            RequestOptions::HEADERS         => [
                'Content-Type' => 'application/json',
                // TODO: update token with TokenService
                'Authorization' => $config->token,
            ],
        ];

        $httpClient = new HttpClient($httpClientConfig);

        return new Client($httpClient);
    }
}
