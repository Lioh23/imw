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

        $regiao = Identifiable::fetchtSessionRegiao();

        return [
            'lancamentos' => HistoricoNomeacoesUtils::fetchHistoricoNomeacoes($regiao->id, $visao),
            'distritos'   => Identifiable::fetchDistritosByRegiao($regiao->id),
            'regiao'      => $regiao
        ];
    }
}
