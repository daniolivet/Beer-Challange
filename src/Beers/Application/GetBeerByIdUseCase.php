<?php

namespace App\Beers\Application;
use App\Beers\Domain\IPunkApiRepository;

final class GetBeerByIdUseCase {
    public function __construct(
        private readonly IPunkApiRepository $repository
    ) {
    }

    public function __invoke( int $id )
    {

        $beers = $this->repository->getBeerById( $id );

        return;

    }
}
