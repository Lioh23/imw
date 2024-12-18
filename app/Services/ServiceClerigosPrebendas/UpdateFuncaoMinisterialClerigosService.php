<?php

namespace App\Services\ServiceClerigosPrebendas;

use App\Models\PessoaFuncaoMinisterial;
use App\Models\Prebenda;

class UpdateFuncaoMinisterialClerigosService
{
    public function execute($request, $id)
    {
        $funcao = PessoaFuncaoMinisterial::findOrFail($id);

        $funcao->update([
            'qtd_prebendas' => $request->input('qtd_prebendas'),
        ]);
    }
}
