<?php

namespace App\Exceptions;


class Forbidden extends Failure
{
    public function __construct($message = 'Ação não permitida')
    {
        parent::__construct($message, 403);
    }
}
