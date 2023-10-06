<?php

namespace App\Beers\Infrastructure;

use Symfony\Component\Cache\CacheItem;
use App\Beers\Domain\Interface\ICacheFileSystem;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

final class CacheFileSystem implements ICacheFileSystem {

    private const EXPIRE_TIME = 21600;

    private CacheItem $cacheItem;

    public function __construct(
        private readonly FilesystemAdapter $cache
    ){}

    /**
     * Check if cacheKey exists and return a value
     * 
     * @param string $cacheKey
     * @return array
     */
    public function getDataCached( string $cacheKey ): array {
        $this->cacheItem = $this->cache->getItem( $cacheKey );

        if ( $this->cacheItem->isHit() ) {
            return $this->cacheItem->get();
        }

        return [];
    }

    /**
     * Set Data in cache
     * 
     * @param array $responseData
     * @return bool
     */
    public function setDataInCache( array $responseData ): bool {
        $this->cacheItem->set( $responseData );
        $this->cacheItem->expiresAfter( self::EXPIRE_TIME );
        
        return $this->cache->save( $this->cacheItem );
    }
}
