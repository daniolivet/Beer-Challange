<?php

namespace App\Beers\Application\Validators;

use Symfony\Component\Validator\Constraints as Assert;

final class FilterByFoodValidator {

    #[Assert\NotBlank(
        message: 'The param food is required.'
    )]
    #[Assert\NoSuspiciousCharacters ]
    #[Assert\Type(
        type: 'string',
        message: 'The value {{ value }} is not a valid {{ type }}.',
    ) ]
    #[Assert\Length(
        min: 1,
        max: 70,
        minMessage: 'Your food name must be at least {{ limit }} characters long',
        maxMessage: 'Your food name cannot be longer than {{ limit }} characters',
    ) ]
    public ?string $food;

    public function __construct( ?string $food ) {
        $this->food = $food;
    }

}
