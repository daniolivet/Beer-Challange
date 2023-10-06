<?php

namespace App\Tests\Integration\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpClient\HttpClient;

final class GetBeerByIdControllerTest extends KernelTestCase
{

    public function testShouldReturnBeerWithIdEqualTo()
    {
        // Arrange
        $client = HttpClient::createForBaseUri( $_SERVER['API_BASE_URL'] );

        // Act
        $response     = $client->request( 'GET', '/api/beers/4' );
        $responseData = $response->toArray( false );

        // Assert
        $this->assertEquals( 200, $response->getStatusCode() );
        $this->assertNotEmpty( $responseData );
        $this->assertTrue( $responseData['response'] );
        $this->assertSame( "Beers successfully found!", $responseData['message'] );
        $this->assertNotEmpty( $responseData['data'] );
        $this->assertSame( [ 
            "id"           => 4,
            "name"         => "Pilsen Lager",
            "tagline"      => "Unleash the Yeast Series.",
            "first_brewed" => "09/2013",
            "description"  => "Our Unleash the Yeast series was an epic experiment into the differences in aroma and flavour provided by switching up your yeast. We brewed up a wort with a light caramel note and some toasty biscuit flavour, and hopped it with Amarillo and Centennial for a citrusy bitterness. Everything else is down to the yeast. Pilsner yeast ferments with no fruity esters or spicy phenols, although it can add a hint of butterscotch.",
            "image"        => "https://images.punkapi.com/v2/4.png"
        ], $responseData['data'] );
    }

    public function testShouldReturnNotFoundBeer()
    {
        // Arrange
        $client = HttpClient::createForBaseUri( $_SERVER['API_BASE_URL'] );

        // Act
        $response     = $client->request( 'GET', '/api/beers/9999' );
        $responseData = $response->toArray( false );

        // Assert
        $this->assertEquals( 404, $response->getStatusCode() );
        $this->assertNotEmpty( $responseData );
        $this->assertFalse( $responseData['response'] );
        $this->assertSame( "No beer found that matches the ID 9999" , $responseData['message'] );
    }

}
