<?php

namespace App\Services\ServicePrebendas;

use App\Models\PessoasPrebenda;


class UpdatePrebendaService
{
    public function execute($request, $id)
    {
        $prebenda = PessoasPrebenda::findOrFail( $id);

        $prebenda->update([
            'ano' => $request->input('ano'),
            'valor' => $request->input('valor'),
        ]);
    }
}
