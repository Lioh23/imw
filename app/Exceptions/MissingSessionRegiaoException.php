<?php

namespace App\Exceptions;

use Exception;

class MissingSessionRegiaoException extends Exception
{
    protected $message = 'Região não localizada pela sessão do usuário.';

    public function __construct()
    {
        parent::__construct($this->message, 400);
    }
}
