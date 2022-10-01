<?php

namespace App\Exceptions;

class ParameterNotFound extends Failure
{
    public function __construct($message = 'Parametro não informado')
    {
        parent::__construct($message, 400);
    }
}
