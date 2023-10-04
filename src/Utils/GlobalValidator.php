<?php

namespace App\Utils;

use Symfony\Component\Validator\Validator\ValidatorInterface;

final class GlobalValidator
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
