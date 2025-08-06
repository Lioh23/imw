<?php

namespace App\Services\ServiceFinanceiroRelatorios;

use App\Traits\Identifiable;
use App\Traits\MovimentoBancario;

class MovimentoBancarioService
{
    public function execute($dataInicial, $dataFinal)
    {
        $instituicaoId = session()->get('session_perfil')->instituicao_id;
        $instituicao = session('session_perfil')->instituicao_nome;
        $dt_inicial = \Carbon\Carbon::parse($dataInicial)->format('d/m/Y');
        $dt_final = \Carbon\Carbon::parse($dataFinal)->format('d/m/Y');
        return [
            'movimentosBancarios' => MovimentoBancario::getMovimentosBancarios($dataInicial, $dataFinal, $instituicaoId),
            'instituicao' => $instituicaoId,
            'titulo' => "Relatório Movimento Bancário -  {$instituicao} - Período de {$dt_inicial} a {$dt_final}",
        ];
    }
}
