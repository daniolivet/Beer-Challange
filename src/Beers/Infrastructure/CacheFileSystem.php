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
        $this->setCacheItem( $cacheKey );

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
    public function setDataInCache( string $cacheKey, array $responseData ): bool {
        if( empty($this->cacheItem) ) {
            $this->setCacheItem($cacheKey);
        }
        
        $this->cacheItem->set( $responseData );
        $this->cacheItem->expiresAfter( self::EXPIRE_TIME );
        
        return $this->cache->save( $this->cacheItem );
    }

    /**
     * CacheItem Setter
     * 
     * @param string $cacheKey
     * @return \Symfony\Component\Cache\CacheItem
     */
    public function setCacheItem( string $cacheKey ): CacheItem {
        $this->cacheItem = $this->cache->getItem( $cacheKey );

        return $this->cacheItem;
    }
}
