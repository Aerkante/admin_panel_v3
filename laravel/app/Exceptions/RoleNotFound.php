<?php

namespace App\Exceptions;


class RoleNotFound extends Failure
{
    public function __construct($message = 'Permissão requirida não encontrada.')
    {
        parent::__construct($message, 422);
    }
}
