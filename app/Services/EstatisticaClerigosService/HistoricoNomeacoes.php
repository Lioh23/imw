<?php

namespace App\Services\EstatisticaClerigosService;


use App\Traits\HistoricoNomeacoesUtils;
use App\Traits\Identifiable;
use App\Traits\TotalClerigosUtils;


class HistoricoNomeacoes
{
    use Identifiable;


    public function execute($visao)
    {
        $situacao = request()->get('situacao');
        $regiao = Identifiable::fetchtSessionRegiao();
        return [
            'lancamentos' => HistoricoNomeacoesUtils::fetchHistoricoNomeacoes($regiao->id, $visao, $situacao),
            'distritos'   => Identifiable::fetchDistritosByRegiao($regiao->id),
            'regiao'      => $regiao
        ];
    }
}
