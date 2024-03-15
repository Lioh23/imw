<?php

namespace App\Services\ServicePerfil;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ListPerfilService
{
    public function execute()
    {
        $usuario = Auth::user();
        if (!$usuario) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar essa página.');
        }
        return $usuario;
    }
}


