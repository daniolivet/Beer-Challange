<?php

namespace App\Beers\Infrastructure\Controller;

use App\Beers\Application\FilterByFoodUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

final class FilterByFoodController extends AbstractController {

    public function __construct( 
        private readonly FilterByFoodUseCase $useCase
    ) {}

    public function __invoke( Request $request ) {
        $foodName = $request->query->get('food');

        

        $beers = ( $this->useCase )( $foodName );        

        return $this->json([]);
    }

}
