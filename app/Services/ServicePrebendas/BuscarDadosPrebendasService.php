<?php

namespace App\Services\ServicePrebendas;

use App\Models\PessoaFuncaoministerial;
use App\Models\Prebenda;

class BuscarDadosPrebendasService
{
    public function execute(): array
    {
        $funcoes = PessoaFuncaoministerial::whereNotNull('qtd_prebendas')
            ->where('qtd_prebendas', '>', 0)
            ->orderBy('ordem', 'desc')
            ->get();
        $prebendas = Prebenda::where('ativo', 1)->orderBy('ano', 'desc')->get();

        return [
            'funcoes' => $funcoes,
            'prebendas' => $prebendas,
        ];
    }
}
