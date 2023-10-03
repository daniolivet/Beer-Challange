<?php

namespace App\Beers\Application;
use App\Beers\Domain\IPunkApiRepository;

final class FilterByFoodUseCase {

    public function __construct(
        private readonly IPunkApiRepository $repository
    ){}

    public function __invoke( string $food ) {

        $food = str_replace(' ', '_', $food);

        $beers = $this->repository->getBeerByFood($food);

        return;

    }

}
