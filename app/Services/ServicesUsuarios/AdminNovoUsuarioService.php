<?php

namespace App\Services\ServicesUsuarios;

use App\Models\Perfil;

class AdminNovoUsuarioService
{

    public function execute()
    {
        $perfils = Perfil::orderBy('nome', 'asc')->get();
        return $perfils;
    }
}
