<?php

namespace App\Tests\Unit\Infrastructure\Repository;

use App\Beers\Domain\Exceptions\BeersException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Beers\Domain\Exceptions\BeersNotFoundException;
use App\Beers\Infrastructure\Repository\PunkApiRepository;

final class PunkApiRepositoryTest extends KernelTestCase
{

    public function testShouldGetAllBeersFilterByFood()
    {
        // Assert
        $dataExpected = [ 
            [ 
                "id"                => 2,
                "name"              => "Trashy Blonde",
                "tagline"           => "You Know You Shouldn't",
                "first_brewed"      => "04/2008",
                "description"       => "A titillating, neurotic, peroxide punk of a Pale Ale. Combining attitude, style, substance, and a little bit of low self esteem for good measure; what would your mother say? The seductive lure of the sassy passion fruit hop proves too much to resist. All that is even before we get onto the fact that there are no additives, preservatives, pasteurization or strings attached. All wrapped up with the customary BrewDog bite and imaginative twist.",
                "image_url"         => "https=>//images.punkapi.com/v2/2.png",
                "abv"               => 4.1,
                "ibu"               => 41.5,
                "target_fg"         => 1010,
                "target_og"         => 1041.7,
                "ebc"               => 15,
                "srm"               => 15,
                "ph"                => 4.4,
                "attenuation_level" => 76,
                "volume"            => [ 
                    "value" => 20,
                    "unit"  => "litres"
                ],
                "boil_volume"       => [ 
                    "value" => 25,
                    "unit"  => "litres"
                ],
                "method"            => [ 
                    "mash_temp"    => [ 
                        [ 
                            "temp"     => [ 
                                "value" => 69,
                                "unit"  => "celsius"
                            ],
                            "duration" => null
                        ]
                    ],
                    "fermentation" => [ 
                        "temp" => [ 
                            "value" => 18,
                            "unit"  => "celsius"
                        ]
                    ],
                    "twist"        => null
                ],
                "ingredients"       => [ 
                    "malt"  => [ 
                        [ 
                            "name"   => "Maris Otter Extra Pale",
                            "amount" => [ 
                                "value" => 3.25,
                                "unit"  => "kilograms"
                            ]
                        ],
                    ],
                    "hops"  => [ 
                        [ 
                            "name"      => "Amarillo",
                            "amount"    => [ 
                                "value" => 13.8,
                                "unit"  => "grams"
                            ],
                            "add"       => "start",
                            "attribute" => "bitter"
                        ],
                    ],
                    "yeast" => "Wyeast 1056 - American Ale™"
                ],
                "food_pairing"      => [ 
                    "Fresh crab with lemon",
                    "Garlic butter dipping sauce",
                    "Goats cheese salad",
                    "Creamy lemon bar doused in powdered sugar"
                ],
                "brewers_tips"      => "Be careful not to collect too much wort from the mash. Once the sugars are all washed out there are some very unpleasant grainy tasting compounds that can be extracted into the wort.",
                "contributed_by"    => "Sam Mason <samjbmason>"
            ],
            [ 
                "id"                => 3,
                "name"              => "Trashy Blonde test",
                "tagline"           => "You Know You Shouldn't",
                "first_brewed"      => "04/2008",
                "description"       => "A titillating, neurotic, peroxide punk of a Pale Ale. Combining attitude, style, substance, and a little bit of low self esteem for good measure; what would your mother say? The seductive lure of the sassy passion fruit hop proves too much to resist. All that is even before we get onto the fact that there are no additives, preservatives, pasteurization or strings attached. All wrapped up with the customary BrewDog bite and imaginative twist.",
                "image_url"         => "https=>//images.punkapi.com/v2/2.png",
                "abv"               => 4.1,
                "ibu"               => 41.5,
                "target_fg"         => 1010,
                "target_og"         => 1041.7,
                "ebc"               => 15,
                "srm"               => 15,
                "ph"                => 4.4,
                "attenuation_level" => 76,
                "volume"            => [ 
                    "value" => 20,
                    "unit"  => "litres"
                ],
                "boil_volume"       => [ 
                    "value" => 25,
                    "unit"  => "litres"
                ],
                "method"            => [ 
                    "mash_temp"    => [ 
                        [ 
                            "temp"     => [ 
                                "value" => 69,
                                "unit"  => "celsius"
                            ],
                            "duration" => null
                        ]
                    ],
                    "fermentation" => [ 
                        "temp" => [ 
                            "value" => 18,
                            "unit"  => "celsius"
                        ]
                    ],
                    "twist"        => null
                ],
                "ingredients"       => [ 
                    "malt"  => [ 
                        [ 
                            "name"   => "Maris Otter Extra Pale",
                            "amount" => [ 
                                "value" => 3.25,
                                "unit"  => "kilograms"
                            ]
                        ],
                    ],
                    "hops"  => [ 
                        [ 
                            "name"      => "Amarillo",
                            "amount"    => [ 
                                "value" => 13.8,
                                "unit"  => "grams"
                            ],
                            "add"       => "start",
                            "attribute" => "bitter"
                        ],
                    ],
                    "yeast" => "Wyeast 1056 - American Ale™"
                ],
                "food_pairing"      => [ 
                    "Fresh crab with lemon",
                    "Garlic butter dipping sauce",
                    "Goats cheese salad",
                    "Creamy lemon bar doused in powdered sugar"
                ],
                "brewers_tips"      => "Be careful not to collect too much wort from the mash. Once the sugars are all washed out there are some very unpleasant grainy tasting compounds that can be extracted into the wort.",
                "contributed_by"    => "Sam Mason <samjbmason>"
            ],
        ];
        $httpClient   = new MockHttpClient( [ 
            new MockResponse( json_encode( $dataExpected ), [ 'http_code' => Response::HTTP_OK ] ),
        ] );
        $repository   = new PunkApiRepository( $httpClient );

        // Arrage
        $result = $repository->getBeerByFood( 'cheese' );

        // Assert
        $this->assertNotEmpty( $result );
        $this->assertEquals( $dataExpected, $result );
    }

    public function testShouldThrowBeersNotFoundExceptionInFilterByFood()
    {
        // Assert
        $httpClient = new MockHttpClient( [ 
            new MockResponse( json_encode( [] ), [ 'http_code' => Response::HTTP_NOT_FOUND ] ),
        ] );
        $repository = new PunkApiRepository( $httpClient );

        // Assert
        $this->expectException( BeersNotFoundException::class);
        $this->expectExceptionMessage( "No beers found." );
        $this->expectExceptionCode( 404 );

        // Arrage
        $repository->getBeerByFood( 'queso' );
    }

    public function testShouldThrowBeersExceptionInFilterByFood()
    {
        // Assert
        $dataExpected = [ 
            "statusCode" => 400,
            "error"      => "Bad Request",
            "message"    => "Invalid query params",
            "data"       => [ 
                [ 
                    "location" => "query",
                    "param"    => "food",
                    "msg"      => "Must have a value and if you are using multiple words use underscores to separate",
                    "value"    => ""
                ]
            ]
        ];
        $httpClient   = new MockHttpClient( [ 
            new MockResponse( json_encode( $dataExpected ), [ 'http_code' => Response::HTTP_BAD_REQUEST ] ),
        ] );
        $repository   = new PunkApiRepository( $httpClient );

        try {
            // Arrage      
            $repository->getBeerByFood( '' );
            
        } catch ( BeersException $e ) {
            // Assert 
            $this->assertSame( 'Unexpected error occurred, try again', $e->getMessage() );
            $this->assertSame( 400, $e->getCode() );
            $this->assertSame( $dataExpected, $e->getExceptionData() );
        }

    }

    public function testShouldGetJsonResponseWithWrongUrl()
    {
        // Assert
        $dataExpected         = [ 
            "statusCode" => 404,
            "error"      => "Not Found",
            "message"    => "No endpoint found that matches '/v4/beers?food='"
        ];
        $_ENV['PUNK_API_URL'] = "https://api.punkapi.com/v4/";
        $httpClient           = new MockHttpClient( [ 
            new MockResponse( json_encode( $dataExpected ), [ 'http_code' => Response::HTTP_NOT_FOUND ] ),
        ] );
        $repository           = new PunkApiRepository( $httpClient );

        try {
            // Arrage      
            $repository->getBeerByFood( 'cheese' );

        } catch ( BeersException $e ) {
            // Assert 
            $this->assertSame( 'Unexpected error occurred, try again', $e->getMessage() );
            $this->assertSame( 404, $e->getCode() );
            $this->assertSame( $dataExpected, $e->getExceptionData() );
        }
    }

    public function testShouldGetBeerById()
    {

        // Assert
        $dataExpected = [ 
            [ 
                "id"                => 2,
                "name"              => "Trashy Blonde",
                "tagline"           => "You Know You Shouldn't",
                "first_brewed"      => "04/2008",
                "description"       => "A titillating, neurotic, peroxide punk of a Pale Ale. Combining attitude, style, substance, and a little bit of low self esteem for good measure; what would your mother say? The seductive lure of the sassy passion fruit hop proves too much to resist. All that is even before we get onto the fact that there are no additives, preservatives, pasteurization or strings attached. All wrapped up with the customary BrewDog bite and imaginative twist.",
                "image_url"         => "https=>//images.punkapi.com/v2/2.png",
                "abv"               => 4.1,
                "ibu"               => 41.5,
                "target_fg"         => 1010,
                "target_og"         => 1041.7,
                "ebc"               => 15,
                "srm"               => 15,
                "ph"                => 4.4,
                "attenuation_level" => 76,
                "volume"            => [ 
                    "value" => 20,
                    "unit"  => "litres"
                ],
                "boil_volume"       => [ 
                    "value" => 25,
                    "unit"  => "litres"
                ],
                "method"            => [ 
                    "mash_temp"    => [ 
                        [ 
                            "temp"     => [ 
                                "value" => 69,
                                "unit"  => "celsius"
                            ],
                            "duration" => null
                        ]
                    ],
                    "fermentation" => [ 
                        "temp" => [ 
                            "value" => 18,
                            "unit"  => "celsius"
                        ]
                    ],
                    "twist"        => null
                ],
                "ingredients"       => [ 
                    "malt"  => [ 
                        [ 
                            "name"   => "Maris Otter Extra Pale",
                            "amount" => [ 
                                "value" => 3.25,
                                "unit"  => "kilograms"
                            ]
                        ],
                    ],
                    "hops"  => [ 
                        [ 
                            "name"      => "Amarillo",
                            "amount"    => [ 
                                "value" => 13.8,
                                "unit"  => "grams"
                            ],
                            "add"       => "start",
                            "attribute" => "bitter"
                        ],
                    ],
                    "yeast" => "Wyeast 1056 - American Ale™"
                ],
                "food_pairing"      => [ 
                    "Fresh crab with lemon",
                    "Garlic butter dipping sauce",
                    "Goats cheese salad",
                    "Creamy lemon bar doused in powdered sugar"
                ],
                "brewers_tips"      => "Be careful not to collect too much wort from the mash. Once the sugars are all washed out there are some very unpleasant grainy tasting compounds that can be extracted into the wort.",
                "contributed_by"    => "Sam Mason <samjbmason>"
            ],
        ];
        $httpClient   = new MockHttpClient( [ 
            new MockResponse( json_encode( $dataExpected ), [ 'http_code' => Response::HTTP_OK ] ),
        ] );
        $repository   = new PunkApiRepository( $httpClient );

        // Arrage
        $result = $repository->getBeerById( 2 );

        // Assert
        $this->assertNotEmpty( $result );
        $this->assertEquals( $dataExpected, $result );
    }

    public function testShouldThrowBeersNotFoundExceptionInGetBeerById()
    {
        // Assert
        $httpClient = new MockHttpClient( [ 
            new MockResponse( json_encode( [] ), [ 'http_code' => Response::HTTP_NOT_FOUND ] ),
        ] );
        $repository = new PunkApiRepository( $httpClient );

        // Assert
        $this->expectException( BeersNotFoundException::class);
        $this->expectExceptionMessage( "No beers found." );
        $this->expectExceptionCode( 404 );

        // Arrage
        $repository->getBeerById( 999 );
    }

    public function testShouldReturnNotFoundMessageInGetBeerById()
    {
        // Assert
        $dataExpected = [ 
            "statusCode" => 404,
            "error"      => "Not Found",
            "message"    => "No beer found that matches the ID 999"
        ];
        $httpClient   = new MockHttpClient( [ 
            new MockResponse( json_encode( $dataExpected ), [ 'http_code' => Response::HTTP_NOT_FOUND ] ),
        ] );
        $repository   = new PunkApiRepository( $httpClient );

        try {
            // Arrage
            $repository->getBeerById( 999 );

        }catch( BeersException $e ) {
            // Assert
            $this->assertSame( 'Unexpected error occurred, try again', $e->getMessage() );
            $this->assertSame( 404, $e->getCode() );
            $this->assertSame( $dataExpected, $e->getExceptionData() );
        }
    }

}