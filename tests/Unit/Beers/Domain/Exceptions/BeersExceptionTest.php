<?php

namespace App\Tests\Unit\Beers\Domain\Exceptions;

use App\Beers\Domain\Exceptions\BeersException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class BeersExceptionTest extends KernelTestCase
{

    public function testShoudlReturnBeersExceptionInstance()
    {
        // Act
        $exception = new BeersException( [], 200 );

        // Assert
        $this->assertInstanceOf( BeersException::class, $exception );
        $this->assertNotEmpty( $exception->getMessage() );
        $this->assertNotEmpty( $exception->getCode() );
    }

    public function testShouldSaveExceptionData()
    {
        // Arrange
        $data = [ 'test' => 'this is a test' ];

        // Act
        $exception = new BeersException( $data, 200 );

        // Assert
        $this->assertNotEmpty( $exception->getExceptionData() );
        $this->assertSame( $data, $exception->getExceptionData() );
    }

}
