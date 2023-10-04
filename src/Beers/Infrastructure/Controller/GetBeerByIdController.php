<?php

namespace App\Beers\Infrastructure\Controller;

use App\Beers\Application\Validators\GetBeerByIdValidator;
use App\Beers\Domain\Interface\IGlobalValidator;
use App\Beers\Application\GetBeerByIdUseCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class GetBeerByIdController extends AbstractController
{

    public function __construct(
        private readonly GetBeerByIdUseCase $useCase,
        private readonly IGlobalValidator $globalValidator
    ) {
    }

    public function __invoke( Request $request )
    {
        $beerId = $request->query->get('id');

        $validateObj = new GetBeerByIdValidator( $beerId );

        $errors = $this->globalValidator->validate( $validateObj );
        if ( ! empty( $errors ) ) {
            return $this->json( [ 
                'response' => false,
                'message'  => 'Bad request.',
                'errors'   => $errors,
            ], Response::HTTP_BAD_REQUEST );
        }

        $beer = ( $this->useCase )( $beerId );
        
        return $this->json( $beer );
    }

}
