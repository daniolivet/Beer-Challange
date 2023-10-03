<?php

namespace App\Beer\Infrastructure\Repository;

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClientInterface;

final class PunkApiRepository {

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly Dotenv $dotEnv
    ) {

    }

    public function getBeerByFood() {

        $response = $this->httpClient->request( 'GET', $_ENV['PUNK_API_URL'] . 'beers/?food=' );
        $data     = $response->toArray();

        return $data;
    }

}

