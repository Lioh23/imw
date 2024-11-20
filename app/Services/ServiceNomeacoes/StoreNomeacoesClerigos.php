<?php

namespace App\Services\ServiceNomeacoes;

use App\Models\PessoaNomeacao;
use App\Models\PessoasPessoa;
use Carbon\Carbon;

class StoreNomeacoesClerigos
{
    public function execute($request)
    {
        PessoaNomeacao::create($request->validated());
    }
}
