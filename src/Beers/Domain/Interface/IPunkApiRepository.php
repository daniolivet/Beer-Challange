<?php

namespace App\Beers\Domain\Interface;

interface IPunkApiRepository {
    public function getBeerByFood( string $food );

    public function getBeerById( int $id );
}
