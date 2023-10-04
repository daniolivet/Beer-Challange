<?php

namespace App\Beers\Infrastructure\Controller;

use App\Utils\GlobalValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Beers\Application\FilterByFoodUseCase;
use App\Beers\Application\Validators\FilterByFoodValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class FilterByFoodController extends AbstractController
{

    public function __construct(
        private readonly FilterByFoodUseCase $useCase,
        private readonly GlobalValidator $globalValidator
    ) {
    }

    public function __invoke( Request $request )
    {
        $foodName = $request->query->get( 'food' );

        $validateObj = new FilterByFoodValidator( $foodName );

        $errors = $this->globalValidator->validate( $validateObj );
        if ( ! empty( $errors ) ) {
            return $this->json( [ 
                'response' => false,
                'message'  => 'Bad request.',
                'errors'   => $errors,
            ], Response::HTTP_BAD_REQUEST );
        }

        $beers = ( $this->useCase )( $foodName );

        return $this->json( $beers );
    }

}
