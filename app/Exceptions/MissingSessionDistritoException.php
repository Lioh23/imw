<?php

namespace App\Exceptions;

use Exception;

class MissingSessionDistritoException extends Exception
{
    protected $message = 'Distrito não localizado pela sessão do usuário.';

    public function __construct()
    {
        parent::__construct($this->message, 400);
    }
}
