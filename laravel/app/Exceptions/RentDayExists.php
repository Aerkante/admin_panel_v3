<?php

namespace App\Exceptions;

class RentDayExists extends Failure
{
    public function __construct($message = 'Horarios escolhidos já estão reservados.')
    {
        parent::__construct($message, 422);
    }
}
