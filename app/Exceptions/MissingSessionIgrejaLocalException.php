<?php

namespace App\Exceptions;

use Exception;

class MissingSessionIgrejaLocalException extends Exception 
{
    protected $message = 'É preciso estar autenticado com um usuário com perfil de igreja local para realizar esta ação.';

    public function __construct()
    {
        parent::__construct($this->message);
    }
}
