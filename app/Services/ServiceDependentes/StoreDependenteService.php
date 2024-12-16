<?php

namespace App\Services\ServiceDependentes;

use App\Models\PessoasDependente;

class StoreDependenteService
{
    public function execute($pessoaId, $params)
    {
        $payload = collect($params)
            ->merge(['pessoa_id' => $pessoaId])
            ->toArray();

        PessoasDependente::create($payload);
    }
}
