<?php

namespace App\Beers\Domain\Exception;

use Symfony\Component\HttpFoundation\Response;

final class BeersNotFoundException extends \RuntimeException {

    public function __construct() {
        parent::__construct( "No beers found.", Response::HTTP_NOT_FOUND );
    }

}
