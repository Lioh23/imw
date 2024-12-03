<?php

namespace App\Services\ServiceClerigosRegiao;

use App\Models\PessoaNomeacao;


class StoreNomeacoesClerigosService
{
    public function execute($request)
    {
        $data = $request->safe()->only([
            'funcao_ministerial_id',
            'data_nomeacao',
            'instituicao_id',
            'pessoa_id'

        ]);

        PessoaNomeacao::create($data);
    }
}
