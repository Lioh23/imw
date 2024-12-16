<?php

namespace App\Observers;

use App\Models\PessoasDependente;
use App\Traits\Identifiable;

class PessoasDependenteObserver
{
    use Identifiable;

    public function creating(PessoasDependente $dependente)
    {
        $dependente->cpf = clearFormatNumber($dependente->cpf);
    }

    public function updating(PessoasDependente $dependente)
    {
        $dependente->cpf = clearFormatNumber($dependente->cpf);
    }
}
