<?php

namespace App\Observers;

use App\Models\PessoasPrebenda;

class PessoaPrebendasObserver
{
    public function creating(PessoasPrebenda $pessoasPrebenda)
    {
        if ($pessoasPrebenda->valor) {
            $valor = str_replace(['R$', '.'], '', $pessoasPrebenda->valor);
            $pessoasPrebenda->valor = str_replace(',', '.', $valor);
        }
    }

    public function updating(PessoasPrebenda $pessoasPrebenda)
    {
        if ($pessoasPrebenda->valor) {
            $valor = str_replace(['R$', '.'], '', $pessoasPrebenda->valor);
            $pessoasPrebenda->valor = str_replace(',', '.', $valor);
        }
    }
}
