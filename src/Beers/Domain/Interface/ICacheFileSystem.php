<?php

namespace App\Beers\Domain\Interface;

interface ICacheFileSystem {

    public function getDataCached( string $cacheKey ): array;

    public function setDataInCache( string $cacheKey, array $responseData ): bool;

}
