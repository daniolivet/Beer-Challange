<?php

namespace App\Beers\Application;

use App\Beers\Domain\Exception\BeersException;
use App\Beers\Domain\IPunkApiRepository;

final class FilterByFoodUseCase
{

    public function __construct(
        private readonly IPunkApiRepository $repository
    ) {
    }

    public function __invoke( string $food ): array
    {
        try {
            $food = str_replace( ' ', '_', $food );

            $beers = $this->repository->getBeerByFood( $food );

            return $this->filterBeers( $beers );

        } catch ( \RuntimeException $e ) {

            return $this->beersExceptionHandle( $e );

        } catch ( \Exception $e ) {
            return [ 
                'message' => $e->getMessage(),
                'code'    => $e->getCode()
            ];
        }

    }

    /**
     * Filter beer params
     * 
     * @param array $beers
     * @return array
     */
    private function filterBeers( array $beers ): array
    {

        return array_map( fn( $beer ) => [ 
            'id'           => $beer['id'],
            'name'         => $beer['name'],
            'tagline'      => $beer['tagline'],
            'first_brewed' => $beer['first_brewed'],
            'description'  => $beer['description'],
            'image'        => $beer['image_url']
        ], $beers );

    }

    private function beersExceptionHandle( \RuntimeException $e )
    {
        if ( method_exists( $e::class, 'getExceptionData' ) ) {
            $exceptionData = $e->getExceptionData();
            $response      = [ 
                'code'    => $exceptionData['statusCode'] ?? $e->getCode(),
                'message' => $exceptionData['message'] ?? $e->getMessage(),
            ];

            if( isset( $exceptionData['error'] ) ) {
                $response['error'] = $exceptionData['error'];
            }

            if ( isset( $exceptionData['data'] ) ) {
                $response['data'] = $exceptionData['data'];
            }

            return $response;
        }

        return [ 
            'code'    => $e->getCode(),
            'message' => $e->getMessage()
        ];
    }

}
