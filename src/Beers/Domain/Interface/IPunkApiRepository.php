<?php

namespace App\Beers\Domain\Interface;

interface IPunkApiRepository {
    public function getBeerByFood( string $food ) : array;

    public function getBeerById( int $id ) : array;
}
