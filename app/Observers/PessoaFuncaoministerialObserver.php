<?php

namespace App\Observers;

use App\Models\PessoaFuncaoministerial;

class PessoaFuncaoministerialObserver
{
    public function creating(PessoaFuncaoministerial $pessoaFuncaoministerial)
    {
        if ($pessoaFuncaoministerial->qtd_prebendas) {
            $pessoaFuncaoministerial->qtd_prebendas = str_replace(',', '.', $pessoaFuncaoministerial->qtd_prebendas);
        }
    }

    public function updating(PessoaFuncaoministerial $pessoaFuncaoministerial)
    {
        if ($pessoaFuncaoministerial->qtd_prebendas) {
            $pessoaFuncaoministerial->qtd_prebendas = str_replace(',', '.', $pessoaFuncaoministerial->qtd_prebendas);
        }
    }
}
