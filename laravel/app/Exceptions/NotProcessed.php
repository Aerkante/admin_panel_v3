<?php

namespace App\Exceptions;

class NotProcessed extends Failure
{
  public function __construct($message = 'Não foi possível processar a requisição', $code = 422)
  {
    parent::__construct($message, $code);
  }
}
