<?php

namespace App\Beers\Domain\Interface;

interface IBeersExceptionHandler {

    public function beersExceptionHandle( \RuntimeException $exception ): array;

}
