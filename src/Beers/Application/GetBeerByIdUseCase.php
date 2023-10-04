<?php

namespace App\Beers\Application;

use App\Beers\Domain\Interface\IBeersExceptionHandler;
use App\Beers\Domain\Interface\IPunkApiRepository;

final class GetBeerByIdUseCase
{
    public function __construct(
        private readonly IPunkApiRepository $repository,
        private readonly IBeersExceptionHandler $exceptionHandler
    ) {
    }

    /**
     * 
     * @param int $id
     * @return array
     * 
     */
    public function __invoke( int $id ): array
    {
        try {

            $beers = $this->repository->getBeerById( $id );

            return [ 
                'code'    => Response::HTTP_OK,
                'message' => "Beers successfully found!",
                'data'    => $this->filterBeer( $beers )
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
     * @param array $beer
     * @return array
     */
    private function filterBeer( array $beer ) : array
    {
        return [ 
            'id'           => $beer['id'],
            'name'         => $beer['name'],
            'tagline'      => $beer['tagline'],
            'first_brewed' => $beer['first_brewed'],
            'description'  => $beer['description'],
            'image'        => $beer['image_url']
        ];
    }
}
