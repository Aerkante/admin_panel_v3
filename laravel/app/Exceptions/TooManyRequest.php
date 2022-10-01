<?php

namespace App\Exceptions;


class TooManyRequest extends Failure
{
    public function __construct($message = 'O usuário enviou muitas solicitações.')
    {
        parent::__construct($message, 429);
    }
}
