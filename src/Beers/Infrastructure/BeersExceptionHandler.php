<?php

namespace App\Beers\Infrastructure;

use App\Beers\Domain\Interface\IBeersExceptionHandler;

final class BeersExceptionHandler implements IBeersExceptionHandler {

    /**
     * Handle BeersException & BeersNotFoundException
     * 
     * @param \RuntimeException $exception
     * @return array
     */
    public function beersExceptionHandle( \RuntimeException $exception ) : array
    {
        if ( method_exists( $exception::class, 'getExceptionData' ) ) {
            return $this->getExceptionWithData( $exception );
        }

        return [ 
            'code'    => $exception->getCode(),
            'message' => $exception->getMessage()
        ];
    }

    /**
     * Get response with exception data
     * 
     * @return array
     */
    private function getExceptionWithData( \RuntimeException $exception ) : array {
        $exceptionData = $exception->getExceptionData();
        $response      = [ 
            'code'    => $exceptionData['statusCode'] ?? $exception->getCode(),
            'message' => $exceptionData['message'] ?? $exception->getMessage(),
        ];

        if ( isset( $exceptionData['error'] ) ) {
            $response['error'] = $exceptionData['error'];
        }

        if ( isset( $exceptionData['data'] ) ) {
            $response['data'] = $exceptionData['data'];
        }

        return $response;
    }



}
