<?php

namespace App\Tests\Unit\Application;

use App\Beers\Application\FilterByFoodUseCase;
use App\Beers\Domain\Exceptions\BeersException;
use App\Beers\Domain\Exceptions\BeersNotFoundException;
use App\Beers\Domain\Interface\IBeersExceptionHandler;
use App\Beers\Domain\Interface\IPunkApiRepository;
use App\Beers\Infrastructure\BeersExceptionHandler;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class FilterByFoodUseCaseTest extends KernelTestCase
{

    public function testShouldGetResponseWithBeers()
    {
        // Arrage
        $beersExpected             = [ 
            [ 
                "id"                => 2,
                "name"              => "Trashy Blonde",
                "tagline"           => "You Know You Shouldn't",
                "first_brewed"      => "04/2008",
                "description"       => "A titillating, neurotic, peroxide punk of a Pale Ale. Combining attitude, style, substance, and a little bit of low self esteem for good measure; what would your mother say? The seductive lure of the sassy passion fruit hop proves too much to resist. All that is even before we get onto the fact that there are no additives, preservatives, pasteurization or strings attached. All wrapped up with the customary BrewDog bite and imaginative twist.",
                "image_url"         => "https://images.punkapi.com/v2/2.png",
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
                "name"              => "Trashy Blonde tests",
                "tagline"           => "You Know You Shouldn't",
                "first_brewed"      => "04/2008",
                "description"       => "A titillating, neurotic, peroxide punk of a Pale Ale. Combining attitude, style, substance, and a little bit of low self esteem for good measure; what would your mother say? The seductive lure of the sassy passion fruit hop proves too much to resist. All that is even before we get onto the fact that there are no additives, preservatives, pasteurization or strings attached. All wrapped up with the customary BrewDog bite and imaginative twist.",
                "image_url"         => "https://images.punkapi.com/v2/2.png",
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
        $dataExpected              = [ 
            "code"    => 200,
            "message" => "Beers successfully found!",
            "data"    => [ 
                [ 
                    'id'           => 2,
                    'name'         => "Trashy Blonde",
                    'tagline'      => "You Know You Shouldn't",
                    'first_brewed' => "04/2008",
                    'description'  => "A titillating, neurotic, peroxide punk of a Pale Ale. Combining attitude, style, substance, and a little bit of low self esteem for good measure; what would your mother say? The seductive lure of the sassy passion fruit hop proves too much to resist. All that is even before we get onto the fact that there are no additives, preservatives, pasteurization or strings attached. All wrapped up with the customary BrewDog bite and imaginative twist.",
                    'image'        => "https://images.punkapi.com/v2/2.png"
                ],
                [ 
                    'id'           => 3,
                    'name'         => "Trashy Blonde tests",
                    'tagline'      => "You Know You Shouldn't",
                    'first_brewed' => "04/2008",
                    'description'  => "A titillating, neurotic, peroxide punk of a Pale Ale. Combining attitude, style, substance, and a little bit of low self esteem for good measure; what would your mother say? The seductive lure of the sassy passion fruit hop proves too much to resist. All that is even before we get onto the fact that there are no additives, preservatives, pasteurization or strings attached. All wrapped up with the customary BrewDog bite and imaginative twist.",
                    'image'        => "https://images.punkapi.com/v2/2.png"
                ]
            ]
        ];
        $foodName                  = 'cheese';
        $punkApiRepositoryMock     = $this->createMock( IPunkApiRepository::class);
        $beersExceptionHandlerMock = $this->createMock( IBeersExceptionHandler::class);

        $punkApiRepositoryMock->expects( $this->once() )
            ->method( 'getBeerByFood' )
            ->with( $foodName )
            ->willReturn( $beersExpected );

        $useCase = new FilterByFoodUseCase( $punkApiRepositoryMock, $beersExceptionHandlerMock );

        // Arrage
        $result = $useCase->__invoke( $foodName );

        // Assert
        $this->assertNotEmpty( $result );
        $this->assertIsArray( $result );
        $this->assertSame( $dataExpected, $result );
    }

    public function testShouldGetErrorWithParamFood()
    {

        // Arrage
        $dataPunkApiExpected   = [ 
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
        $dataExpected          = [ 
            "code"    => 400,
            "message" => "Invalid query params",
            "error"   => "Bad Request",
            "data"    => [ $dataPunkApiExpected['data'][0] ]
        ];
        $exception             = new BeersException( $dataPunkApiExpected, 400 );
        $punkApiRepositoryMock = $this->createMock( IPunkApiRepository::class);

        $punkApiRepositoryMock->expects( $this->once() )
            ->method( 'getBeerByFood' )
            ->with( '' )
            ->willThrowException( $exception );

        $useCase = new FilterByFoodUseCase(
            $punkApiRepositoryMock,
            new BeersExceptionHandler()
        );

        // Arrage
        $result = $useCase->__invoke( '' );

        // Assert
        $this->assertNotEmpty( $result );
        $this->assertIsArray( $result );
        $this->assertSame( $dataExpected, $result );

    }

    public function testShouldGetErrorWithBadParamFood()
    {
        // Arrage
        $dataExpected = [ 
            "code"    => 404,
            "message" => "No beers found."
        ];
        $exception    = new BeersNotFoundException();

        $punkApiRepositoryMock = $this->createMock( IPunkApiRepository::class);
        $punkApiRepositoryMock->expects( $this->once() )
            ->method( 'getBeerByFood' )
            ->with( 'queso' )
            ->willThrowException( $exception );

        $useCase = new FilterByFoodUseCase(
            $punkApiRepositoryMock,
            new BeersExceptionHandler()
        );

        // Arrage
        $result = $useCase->__invoke( 'queso' );

        // Assert
        $this->assertNotEmpty( $result );
        $this->assertIsArray( $result );
        $this->assertSame( $dataExpected, $result );

    }

}
