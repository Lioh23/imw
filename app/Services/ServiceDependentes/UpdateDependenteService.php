<?php

namespace App\Services\ServiceDependentes;

use App\Models\PessoasDependente;

class UpdateDependenteService
{
    public function execute(PessoasDependente $dependente, array $params)
    {
        $dependente->update($params);
    }
}
