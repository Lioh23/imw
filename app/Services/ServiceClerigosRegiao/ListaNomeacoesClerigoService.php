<?php

namespace App\Services\ServiceClerigosRegiao;

use App\Models\PessoaNomeacao;

class ListaNomeacoesClerigoService
{
    public function execute($clerigoId, $status = null): array 
    {
        $nomeacoes = PessoaNomeacao::with(['funcaoMinisterial', 'instituicao.instituicaoPai'])
            ->where('pessoa_id', $clerigoId)
            ->when($status == 'ativo', fn ($query) => $query->whereNull('data_termino'))
            ->when($status == 'inativo', fn ($query) => $query->whereNotNull('data_termino'))
            ->orderBy('data_termino')
            ->get();

        return [
            'nomeacoes' => $nomeacoes,
            'status'    => $status
        ];
    }
}
