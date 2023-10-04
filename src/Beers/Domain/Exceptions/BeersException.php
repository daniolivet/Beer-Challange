<?php

namespace App\Beers\Domain\Exception;

final class BeersException extends \RuntimeException {

    private array $exceptionData;

    public function __construct( array $exceptionData, int $statusCode ) {
        parent::__construct('Unexpected error occurred, try again', $statusCode);

        $this->exceptionData = $exceptionData;
    }

    /**
     * Get Exception Data
     * 
     * @return array
     */
    public function getExceptionData(): array {
        return $this->exceptionData;
    }

}
