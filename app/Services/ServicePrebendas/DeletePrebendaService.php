<?php

namespace App\Services\ServicePrebendas;

use App\Models\PessoasPrebenda;

class DeletePrebendaService
{

    public function execute($id)
    {

        $prebenda = PessoasPrebenda::findOrFail($id);

        if ($prebenda) {
            $prebenda->delete();
        }
    }
}
