<?php

namespace App\Beers\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Beers\Application\FilterByFoodUseCase;
use App\Beers\Domain\Interface\IGlobalValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Beers\Application\Validators\FilterByFoodValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class FilterByFoodController extends AbstractController
{

    public function __construct(
        private readonly FilterByFoodUseCase $useCase,
        private readonly IGlobalValidator $globalValidator
    ) {
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return JsonResponse
     */
    public function __invoke( Request $request ): JsonResponse
    {
        $foodName = $request->query->get( 'food' );

        $validateObj = new FilterByFoodValidator( $foodName );

        $errors = $this->globalValidator->validate( $validateObj );
        if ( ! empty( $errors ) ) {
            return $this->json( [ 
                'response' => false,
                'message'  => 'Bad request.',
                'errors'   => $errors
            ], Response::HTTP_BAD_REQUEST );
        }

        $beersData = ( $this->useCase )( $foodName );

        if ( Response::HTTP_OK !== $beersData['code'] ) {
            return $this->badResponseHandler( $beersData );
        }

        return $this->json( [ 
            'response' => true,
            'message'  => $beersData['message'],
            'data'     => $beersData['data']
        ] );
    }

    /**
     * Handle all response with http code different to 200
     * 
     * @param array $beersData
     * @return JsonResponse
     */
    private function badResponseHandler( array $beersData ): JsonResponse
    {
        $response = [ 
            'response' => false,
            'message'  => $beersData['message']
        ];

        if ( isset( $beersData['data'] ) ) {
            $response['data'] = $beersData['data'];
        }

        return $this->json( $response, $beersData['code'] );
    }

}
