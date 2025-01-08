<?php

namespace App\Services\ServicePrebendas;

use App\Models\PessoaFuncaoministerial;
use App\Models\Prebenda;

class BuscarDadosPrebendasService
{
    public function execute(): array
    {
        $funcoes = PessoaFuncaoministerial::orderBy('ordem', 'desc')->get();
        $prebendas = Prebenda::where('ativo', 1)->orderBy('ano', 'desc')->get();
        $prebenda_anos = Prebenda::all();

        return [
            'funcoes' => $funcoes,
            'prebendas' => $prebendas,
            'prebenda_anos' => $prebenda_anos
        ];
    }
}
