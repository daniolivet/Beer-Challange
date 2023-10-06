<?php

namespace App\Beers\Infrastructure\Repository;

use App\Beers\Infrastructure\CacheFileSystem;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Response;
use App\Beers\Domain\Exceptions\BeersException;
use App\Beers\Domain\Interface\IPunkApiRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Beers\Domain\Exceptions\BeersNotFoundException;

final class PunkApiRepository implements IPunkApiRepository
{

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly CacheFileSystem $cache
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
    public function getBeerByFood( string $food, bool $useCache = true ): array
    {

        $cacheKey      = "beers_by_food_$food";
        $cacheResponse = $this->cache->getDataCached( $cacheKey );

        if ( ! empty( $cacheResponse ) && $useCache ) {
            return $cacheResponse;
        }

        $response     = $this->httpClient->request( 'GET', $_ENV['PUNK_API_URL'] . "beers?food=$food" );
        $statusCode   = $response->getStatusCode();
        $responseData = $response->toArray( false );

        if ( empty( $responseData ) ) {
            throw new BeersNotFoundException();
        }

        if ( Response::HTTP_OK !== $statusCode ) {
            throw new BeersException( $responseData, $statusCode );
        }

        if( $useCache ) {
            $this->cache->setDataInCache( $cacheKey, $responseData );
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
    public function getBeerById( int $id, bool $useCache = true ): array
    {
        $cacheKey      = "beers_by_id_$id";
        $cacheResponse = $this->cache->getDataCached( $cacheKey );

        if ( ! empty( $cacheResponse ) && $useCache ) {
            return $cacheResponse;
        }

        $response     = $this->httpClient->request( 'GET', $_ENV['PUNK_API_URL'] . "beers/$id" );
        $statusCode   = $response->getStatusCode();
        $responseData = $response->toArray( false );

        if ( empty( $responseData ) ) {
            throw new BeersNotFoundException();
        }

        if ( Response::HTTP_OK !== $statusCode ) {
            throw new BeersException( $responseData, $statusCode );
        }

        if( $useCache ) {
            $this->cache->setDataInCache( $cacheKey, $responseData );
        }

        return $responseData;
    }

}
