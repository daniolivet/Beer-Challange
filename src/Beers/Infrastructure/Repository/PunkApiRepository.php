<?php

namespace App\Beers\Infrastructure\Repository;

use App\Beers\Domain\Interface\IPunkApiRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Beers\Domain\Exceptions\BeersException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Beers\Domain\Exceptions\BeersNotFoundException;

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
     * @throws \App\Beers\Domain\Exceptions\BeersException
     * @throws \App\Beers\Domain\Exceptions\BeersNotFoundException
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
     * @throws \App\Beers\Domain\Exceptions\BeersException
     * @throws \App\Beers\Domain\Exceptions\BeersNotFoundException
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
