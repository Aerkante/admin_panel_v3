<?php

namespace App\Exceptions;

class RegisterNotFound extends Failure
{
    public function __construct($message = 'Registro não encontrado')
    {
        parent::__construct($message, 404);
    }
}
