<?php

namespace App\Beers\Infrastructure\Controller;

use App\Beers\Application\GetBeerByIdUseCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class GetBeerById extends AbstractController
{

    public function __construct(
        private readonly GetBeerByIdUseCase $useCase
    ) {
    }

    public function __invoke( Request $request )
    {
        $beers = ( $this->useCase )( 1 );

        return $this->json( [] );
    }

}
