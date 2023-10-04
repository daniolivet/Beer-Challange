<?php

namespace App\Beers\Application\Validators;

use Symfony\Component\Validator\Constraints as Assert;

final class GetBeerByIdValidator {
    
    #[Assert\NotBlank(
        message: 'The param id is required.'
    ) ]
    #[Assert\NoSuspiciousCharacters ]
    #[Assert\Length(min: 1) ]
    #[Assert\Type(
        type: 'integer',
        message: 'The value {{ value }} is not a valid {{ type }}.',
    ) ]
    public int $id;

    public function __construct( int $id )
    {
        $this->id = $id;
    }
}
