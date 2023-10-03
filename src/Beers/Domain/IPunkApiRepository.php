<?php

namespace App\Beers\Domain;

interface IPunkApiRepository {
    public function getBeerByFood( string $food );
}
