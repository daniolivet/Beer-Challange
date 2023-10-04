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

    /**
     * Get beer by food
     * 
     * @param string $food
     * @throws \App\Beers\Domain\Exception\BeersException
     * @throws \App\Beers\Domain\Exception\BeersNotFoundException
     * @return array
     */
    public function getBeerByFood( string $food ) : array
    {
        $response     = $this->httpClient->request( 'GET', $_ENV['PUNK_API_URL'] . "beers?food=$food" );
        $statusCode   = $response->getStatusCode();
        $responseData = $response->toArray( false );

        if ( Response::HTTP_OK !== $statusCode ) {
            throw new BeersException( $responseData, $statusCode );
        }

        if ( empty( $responseData ) ) {
            throw new BeersNotFoundException();
        }

        return $responseData;
    }

    /**
     * Get beer by id
     * 
     * @param int $id
     * @throws \App\Beers\Domain\Exception\BeersException
     * @throws \App\Beers\Domain\Exception\BeersNotFoundException
     * @return array
     */
    public function getBeerById( int $id ) : array
    {

        $response     = $this->httpClient->request( 'GET', $_ENV['PUNK_API_URL'] . "beers/$id" );
        $statusCode   = $response->getStatusCode();
        $responseData = $response->toArray( false );

        if ( Response::HTTP_OK !== $statusCode ) {
            throw new BeersException( $responseData, $statusCode );
        }

        if ( empty( $responseData ) ) {
            throw new BeersNotFoundException();
        }

        return $responseData;
    }

}
