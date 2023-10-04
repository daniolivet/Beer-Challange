<?php

namespace App\Beers\Infrastructure\Repository;

use App\Beers\Domain\IPunkApiRepository;
use App\Beers\Domain\Exception\BeersException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Beers\Domain\Exception\BeersNotFoundException;

final class PunkApiRepository implements IPunkApiRepository
{

    public function __construct(
        private readonly HttpClientInterface $httpClient
    ) {
    }

    public function getBeerByFood( string $food )
    {
        $response = $this->httpClient->request( 'GET', $_ENV['PUNK_API_URL'] . "beers?food=$food" );
        $statusCode = $response->getStatusCode();
        $responseData = $response->toArray(false);

        if( Response::HTTP_OK !== $statusCode ) {
            throw new BeersException( $responseData, $statusCode );
        }

        if( empty($responseData) ) {
            throw new BeersNotFoundException();
        }

        return $responseData;
    }

    public function getBeerById( int $id ) {
        
        $response = $this->httpClient->request( 'GET', $_ENV['PUNK_API_URL'] . "beers/$id" );
        $data = $response->toArray();

        return $data;
    }

}
