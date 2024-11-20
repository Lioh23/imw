<?php

namespace App\Services\ServiceClerigosRegiao;

use App\Models\PessoaNomeacao;
use App\Models\PessoasPessoa;
use Carbon\Carbon;

class ListarNomeacoesClerigos
{
    public function execute($request)
    {

        $id = $request->route('id');
        $search = $request->input('search');
        $status = $request->input('status');
        $nomeacoes = PessoaNomeacao::with(['funcaoMinisterial', 'instituicao' => function ($query) {
            $query->join('instituicoes_instituicoes as ii', 'instituicoes_instituicoes.instituicao_pai_id', '=', 'ii.id')
            ->select('instituicoes_instituicoes.*', 'ii.nome as pai_nome');
        }])->where('pessoa_id', $id);

        if (!empty($status)) {
            if ($status == 1) {
                $nomeacoes = $nomeacoes->whereNull('data_termino');
            } else if ($status == 2) {
                $nomeacoes = $nomeacoes->whereNotNull('data_termino');
            }
        }

        $nomeacoes = $nomeacoes->get();
    }
}
