<?php

namespace App\Beers\Infrastructure\Controller;

use App\Beers\Application\GetBeerByIdUseCase;
use App\Beers\Domain\Interface\IGlobalValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Beers\Application\Validators\GetBeerByIdValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class GetBeerByIdController extends AbstractController
{

    /**
     * @param \App\Beers\Application\GetBeerByIdUseCase $useCase
     * @param \App\Beers\Domain\Interface\IGlobalValidator $globalValidator
     */
    public function __construct(
        private readonly GetBeerByIdUseCase $useCase,
        private readonly IGlobalValidator $globalValidator
    ) {
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function __invoke( int $id ) : JsonResponse
    {
        $validateObj = new GetBeerByIdValidator( $id );

        $errors = $this->globalValidator->validate( $validateObj );
        if ( ! empty( $errors ) ) {
            return $this->json( [ 
                'response' => false,
                'message'  => 'Bad request.',
                'errors'   => $errors,
            ], Response::HTTP_BAD_REQUEST );
        }

        $beersData = ( $this->useCase )( $id );

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
