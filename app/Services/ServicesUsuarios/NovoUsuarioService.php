<?php

namespace App\Services\ServicesUsuarios;

use App\Models\Perfil;

class NovoUsuarioService
{

    public function execute()
    {
        $perfils = Perfil::where('nivel', Perfil::NIVEL_IGREJA)->orderBy('nome', 'asc')->get();
        return $perfils;
    }
}
