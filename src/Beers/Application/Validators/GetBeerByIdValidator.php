<?php

namespace App\Beers\Application\Validators;

use Symfony\Component\Validator\Constraints as Assert;

final class GetBeerByIdValidator {
    
    #[Assert\NotBlank() ]
    #[Assert\NoSuspiciousCharacters ]
    #[Assert\Length(min: 1) ]
    #[Assert\Type(
        type: 'integer',
        message: 'The value {{ value }} is not a valid {{ type }}.',
    ) ]
    public string $id;

    public function __construct( string $id )
    {
        $this->id = $id;
    }
}
