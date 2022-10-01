<?php

namespace App\Exceptions;

class InvalidPasswordConfirmation extends Failure
{
    public function __construct($message = 'Senha de confirmação inválida')
    {
        parent::__construct($message, 403);
    }
}
