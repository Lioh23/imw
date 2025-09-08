<?php

namespace App\Services\ServicePerfil;
use App\Models\MembresiaSetor;
use App\Models\PessoasPessoa;
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

    public function carteiraDigital()
    {
        $usuario = Auth::user();
        $membro = PessoasPessoa::where('cpf', $usuario->cpf)->first();

       // dd($membro);
        if (!$usuario) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar essa página.');
        }
        return $usuario;
    }
}


