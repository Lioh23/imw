<?php

namespace App\Services\ServiceClerigosRegiao;

use App\Models\InstituicoesInstituicao;
use App\Models\PessoaNomeacao;

class ListaNomeacoesClerigoService
{
    public function execute($clerigoId, $status = null): array
    {
        $nomeacoes = PessoaNomeacao::withTrashed(['funcaoMinisterial', 'instituicao.instituicaoPai'])
            ->where('pessoa_id', $clerigoId)
            ->when($status == 'ativo', fn($query) => $query->whereNull('data_termino'))
            ->when($status == 'inativo', fn($query) => $query->whereNotNull('data_termino'))
            ->orderByRaw('data_termino IS NULL DESC')
            ->orderBy('data_nomeacao', 'desc')
            ->orderBy(
                InstituicoesInstituicao::select('nome')
                    ->whereColumn('instituicoes_instituicoes.id', 'pessoas_nomeacoes.instituicao_id')
                    ->limit(1),
                'asc'
            )
            ->get();

        return [
            'nomeacoes' => $nomeacoes,
            'status'    => $status,
            'id'        => $clerigoId
        ];
    }
}
