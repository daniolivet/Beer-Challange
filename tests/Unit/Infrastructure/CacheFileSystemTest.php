<?php

namespace App\Tests\Unit\Infrastructure;

use App\Beers\Infrastructure\CacheFileSystem;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

final class CacheFileSystemTest extends KernelTestCase {

    public function testShouldReturnEmptyArrayWhenCachePoolNotExists() {

        // Arrange 
        $cacheFileSystem = new CacheFileSystem(
            new FilesystemAdapter
        );
        
        // Act
        $result = $cacheFileSystem->getDataCached( 'test' );

        // Asssert
        $this->assertIsArray( $result );
        $this->assertEmpty($result);
    }

    public function testShouldReturnArrayWithDataCached() {
        // Arrange 
        $cacheFileSystem = new CacheFileSystem(
            new FilesystemAdapter
        );
        $cacheKey        = 'testKey';
        $dataExpected    = [ 'test' => 'this is a test' ];
        $cacheFileSystem->setDataInCache( $cacheKey, $dataExpected);

        // Act
        $result = $cacheFileSystem->getDataCached( $cacheKey );

        // Assert
        $this->assertIsArray($result);
        $this->assertNotEmpty( $result );
        $this->assertSame($dataExpected, $result);
    }

}
