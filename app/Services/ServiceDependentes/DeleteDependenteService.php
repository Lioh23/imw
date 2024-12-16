<?php

namespace App\Services\ServiceDependentes;

use App\Models\PessoasDependente;

class DeleteDependenteService
{
    public function execute(PessoasDependente $dependente)
    {
        $dependente->delete();
    }
}
