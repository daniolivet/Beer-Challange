<?php

namespace App\Beers\Application;

use Symfony\Component\HttpFoundation\Response;
use App\Beers\Domain\Interface\IPunkApiRepository;
use App\Beers\Domain\Interface\IBeersExceptionHandler;

final class GetBeerByIdUseCase
{

    /**
     * @param \App\Beers\Domain\Interface\IPunkApiRepository $repository
     * @param \App\Beers\Domain\Interface\IBeersExceptionHandler $exceptionHandler
     */
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
                'data'    => $this->filterBeer( $beers[0] ?? [] )
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
        if( empty($beer) ) {
            return [];
        }

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
