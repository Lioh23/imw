<?php

namespace App\Services\ServiceClerigosRegiao;

use App\Models\PessoaNomeacao;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeletarNomeacoesClerigos
{
    public function execute($id)
    {

        $nomeacao = PessoaNomeacao::withTrashed()->findOrFail($id);
        $data_termino = Carbon::now()->format('Y-m-d');
        $nomeacao->data_termino = $data_termino;
        $nomeacao->save();
        return redirect()->back()->with('success', 'Nomeação deletada com sucesso');
    }
}
