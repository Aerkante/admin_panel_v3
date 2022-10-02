<?php

namespace App\Exceptions;

class InvalidParameters extends Failure
{
    public function __construct($message = 'Parametros inválidos')
    {
        parent::__construct($message, 403);
    }
}
