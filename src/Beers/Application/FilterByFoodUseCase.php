<?php

namespace App\Beers\Application;

use Symfony\Component\HttpFoundation\Response;
use App\Beers\Domain\Interface\IPunkApiRepository;
use App\Beers\Domain\Interface\IBeersExceptionHandler;

final class FilterByFoodUseCase
{

    public function __construct(
        private readonly IPunkApiRepository $repository,
        private readonly IBeersExceptionHandler $exceptionHandler
    ) {
    }

    /**
     * @param string $food
     * @return array
     */
    public function __invoke( string $food ): array
    {
        try {
            $food = str_replace( ' ', '_', $food );

            $beers = $this->repository->getBeerByFood( $food );

            return [ 
                'code'    => Response::HTTP_OK,
                'message' => "Beers successfully found!",
                'data'    => $this->filterBeers( $beers )
            ];

        } catch ( \RuntimeException $e ) {

            return $this->exceptionHandler->beersExceptionHandle( $e );

        } catch ( \Exception $e ) {
            return [ 
                'code'    => $e->getCode(),
                'message' => $e->getMessage()
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

}
