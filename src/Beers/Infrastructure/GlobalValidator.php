<?php

namespace App\Beers\Infrastructure;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Beers\Domain\Interface\IGlobalValidator;

final class GlobalValidator implements IGlobalValidator
{

    public function __construct(
        private readonly ValidatorInterface $validator,
    ) {
    }

    public function validate( object $objValidator )
    {
        $requestErrors = [];

        $errors = $this->validator->validate( $objValidator );

        foreach ( $errors as $error ) {
            $requestErrors[ $error->getPropertyPath() ] = $error->getMessage();
        }

        return $requestErrors;
    }

}
