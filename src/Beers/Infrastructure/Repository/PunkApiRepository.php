<?php

namespace App\Beers\Infrastructure\Repository;

use App\Beers\Domain\IPunkApiRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class PunkApiRepository implements IPunkApiRepository
{

    public function __construct(
        private readonly HttpClientInterface $httpClient
    ) {
    }

    public function getBeerByFood( string $food )
    {

        $response = $this->httpClient->request( 'GET', $_ENV['PUNK_API_URL'] . "beers/?food=$food" );
        $data     = $response->toArray();

        return $data;
    }

}
