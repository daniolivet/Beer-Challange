<?php

namespace App\Tests\Unit\Infrastructure;

use App\Beers\Domain\Exceptions\BeersException;
use App\Beers\Domain\Exceptions\BeersNotFoundException;
use App\Beers\Infrastructure\BeersExceptionHandler;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class BeersExceptionHandlerTest extends KernelTestCase
{

    public function testShouldReturnDataException()
    {

        // Arrange
        $dataExpected = [ 
            'code'    => 200,
            'message' => "Unexpected error occurred, try again",
            'error'   => 'this is a test'
        ];
        $exception    = new BeersException( ['error' => 'this is a test'], 200 );

        // Act
        $exceptionHandler = new BeersExceptionHandler();
        $data             = $exceptionHandler->beersExceptionHandle( $exception );

        // Assert
        $this->assertNotEmpty( $data );
        $this->assertIsArray($data);
        $this->assertSame( $dataExpected, $data );
    }

    public function testShouldReturnNotFoundData() {
        // Arrange 
        $dataExpected = [
            'code' => 404,
            'message' => 'No beers found.'
        ];
        $exception = new BeersNotFoundException();

        // Act
        $exceptionHandler = new BeersExceptionHandler();
        $data             = $exceptionHandler->beersExceptionHandle($exception);

        // Assert 
        $this->assertNotEmpty($data);
        $this->assertIsArray($data);
        $this->assertSame($dataExpected, $data);
    }

}
