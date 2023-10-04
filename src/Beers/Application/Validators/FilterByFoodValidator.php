<?php

namespace App\Beers\Application\Validators;

use Symfony\Component\Validator\Constraints as Assert;

final class FilterByFoodValidator {

    #[Assert\NotBlank()]
    #[Assert\NoSuspiciousCharacters ]
    #[Assert\Length(
        min: 1,
        max: 70,
        minMessage: 'Your food name must be at least {{ limit }} characters long',
        maxMessage: 'Your food name cannot be longer than {{ limit }} characters',
    ) ]
    public string $name;

    public function __construct( string $name ) {
        $this->name = $name;
    }

}
