<?php

namespace App\Services\ServiceNomeacoes;

use App\Models\PessoaNomeacao;


class StoreNomeacoesClerigos
{
    public function execute($request)
    {
        PessoaNomeacao::create([
            'data_nomeacao' => $request['data_nomeacao'],
            'instituicao_id' => $request['instituicao_id'],
            'pessoa_id' => $request['pessoa_id'],
            'funcao_ministerial_id' => $request['funcao_ministerial_id'],
        ]);
    }
}
