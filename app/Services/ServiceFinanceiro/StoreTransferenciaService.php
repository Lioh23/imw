<?php

namespace App\Services\ServiceFinanceiro;

use App\Models\FinanceiroLancamento;
use Carbon\Carbon;

class StoreTransferenciaService
{
    public function execute(array $data)
    {
        $this->lancamentoSaida($data);
        $this->lancamentoEntrada($data);
    }

    public function lancamentoSaida($data) {
      
        $lancamento = [
            'caixa_id' => $data['caixa_origem_id'],
            'plano_conta_id' => $data['plano_conta_id'],
            'valor' => str_replace(',', '.', str_replace('.', '', $data['valor'])),
            'data_movimento' => $data['data_movimento'],
            'descricao' => $data['descricao'],
            'instituicao_id' => session()->get('session_perfil')->instituicao_id,
            'tipo_lancamento' => FinanceiroLancamento::TP_LANCAMENTO_SAIDA,
            'pagante_favorecido' => $data['descricao'],
            'data_lancamento' => Carbon::now()->format('Y-m-d'),
        ];

        FinanceiroLancamento::create($lancamento);
    }

    public function lancamentoEntrada($data) {
        $lancamento = [
            'caixa_id' => $data['caixa_destino_id'],
            'plano_conta_id' => $data['plano_conta_id'],
            'valor' => str_replace(',', '.', str_replace('.', '', $data['valor'])),
            'data_movimento' => $data['data_movimento'],
            'descricao' => $data['descricao'],
            'instituicao_id' => session()->get('session_perfil')->instituicao_id,
            'tipo_lancamento' => FinanceiroLancamento::TP_LANCAMENTO_ENTRADA,
            'pagante_favorecido' => $data['descricao'],
            'data_lancamento' => Carbon::now()->format('Y-m-d'),
        ];

        FinanceiroLancamento::create($lancamento);
    }
} 