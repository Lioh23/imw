<?php

namespace App\Services\PrebendasClerigosService;

use App\Models\PessoaFuncaoministerial;
use App\Models\Prebenda;

class IdentificaDadosIndexService
{
    public function execute(): array
    {
        $funcoes = PessoaFuncaoministerial::orderBy('ordem', 'desc')->get();

        $prebendas = Prebenda::where('ativo', 1)->orderBy('ano', 'desc')->get();

        return [
            'funcoes' => $funcoes,
            'prebendas' => $prebendas
        ];
    }
}
