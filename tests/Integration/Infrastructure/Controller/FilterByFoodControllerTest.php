<?php

namespace App\Tests\Integration\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpClient\HttpClient;

final class FilterByFoodControllerTest extends KernelTestCase {

    public function testShouldReturnAllBeersWithFoodEqualTo() {
        // Arrange
        $client = HttpClient::createForBaseUri($_SERVER['API_BASE_URL']);
        
        // Act
        $response = $client->request( 'GET',  '/api/beers/filterByFood?food=blue cheese' );
        $responseData = $response->toArray(false);

        // Assert
        $this->assertEquals( 200, $response->getStatusCode() );
        $this->assertNotEmpty($responseData);
        $this->assertTrue($responseData['response']);
        $this->assertSame( "Beers successfully found!", $responseData['message']);
        $this->assertNotEmpty( $responseData['data'] );
    }

    public function testShouldReturnNotFoundBeer() {
        // Arrange
        $client = HttpClient::createForBaseUri( $_SERVER['API_BASE_URL'] );

        // Act
        $response     = $client->request( 'GET', '/api/beers/filterByFood?food=test' );
        $responseData = $response->toArray( false );

        // Assert
        $this->assertEquals( 404, $response->getStatusCode() );
        $this->assertNotEmpty( $responseData );
        $this->assertFalse( $responseData['response'] );
        $this->assertSame( "No beers found.", $responseData['message']);
    }

    public function testShouldReturnErrorWithBadParam() {
        // Arrange
        $client = HttpClient::createForBaseUri( $_SERVER['API_BASE_URL'] );

        // Act
        $response     = $client->request( 'GET', '/api/beers/filterByFood?food=' );
        $responseData = $response->toArray( false );

        // Assert
        $this->assertEquals( 400, $response->getStatusCode() );
        $this->assertNotEmpty( $responseData );
        $this->assertFalse( $responseData['response'] );
        $this->assertSame( "Bad request.", $responseData['message'] );
        $this->assertNotEmpty( $responseData['errors'] );
        $this->assertSame([
            'food' => "Your food name must be at least 1 characters long"
        ], $responseData['errors']);
    }

    public function testShouldReturnErrorWithNotFoodParam() {
        // Arrange
        $client = HttpClient::createForBaseUri( $_SERVER['API_BASE_URL'] );

        // Act
        $response     = $client->request( 'GET', '/api/beers/filterByFood' );
        $responseData = $response->toArray( false );

        // Assert
        $this->assertEquals( 400, $response->getStatusCode() );
        $this->assertNotEmpty( $responseData );
        $this->assertFalse( $responseData['response'] );
        $this->assertSame( "Bad request.", $responseData['message'] );
        $this->assertNotEmpty( $responseData['errors'] );
        $this->assertSame( [ 
            'food' => "The param food is required."
        ], $responseData['errors'] );
    }
}
