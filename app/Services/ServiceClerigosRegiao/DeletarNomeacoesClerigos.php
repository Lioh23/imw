<?php

namespace App\Services\ServiceClerigosRegiao;

use App\Models\PessoaNomeacao;
use Carbon\Carbon;

class DeletarNomeacoesClerigos
{
    public function execute($id)
    {
        $nomeacao = PessoaNomeacao::findOrFail($id);
        if ($nomeacao) {
            $data_termino = Carbon::now();
            $nomeacao->data_termino = $data_termino;
            $nomeacao->save();
        }
    }
}
