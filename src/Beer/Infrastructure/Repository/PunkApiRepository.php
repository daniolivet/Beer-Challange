<?php

namespace App\Beer\Infrastructure\Repository;

use Symfony\Component\HttpClient\HttpClientInterface;

final class PunkApiRepository {

    public function __construct(
        private readonly HttpClientInterface $httpClientInterface
    ) {}

}

