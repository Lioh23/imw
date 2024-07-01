<?php

namespace App\Services\ServiceFinanceiro;

use App\Models\FinanceiroGrade;
use App\Models\FinanceiroLancamento;
use Carbon\Carbon;

class DeletarLancamentoService
{

    public function execute($id)
    {
        $lancamento = FinanceiroLancamento::findOrFail($id);
        
        // Verificar se $lancamento->membro_id existe e se o plano_conta_id está na lista permitida
        $planoContaIds = [3, 4, 5, 6, 110172, 110173, 110174, 110186];
        if ($lancamento->membro_id && in_array($lancamento->plano_conta_id, $planoContaIds)) {
            $this->handleLivroGrade($lancamento->membro_id, $lancamento->valor, $lancamento->data_movimento, $lancamento->id);
            $lancamento->delete();
        } else {
            // Verificar permissão para excluir o lançamento baseado na instituicao_id da sessão
            if ($lancamento->instituicao_id == session()->get('session_perfil')->instituicao_id) {
                $lancamento->delete();
            } else {
                throw new \Exception('Permissão negada para excluir este lançamento.');
            }
        }
    }

    private function handleLivroGrade($membroId, $valor, $dataMovimento, $lancamentoID)
    {
        $date = Carbon::parse($dataMovimento);
        $ano = $date->year;
        $mes = $date->format('M');

        $monthsMap = [
            'Jan' => 'JAN',
            'Feb' => 'FEV',
            'Mar' => 'MAR',
            'Apr' => 'ABR',
            'May' => 'MAI',
            'Jun' => 'JUN',
            'Jul' => 'JUL',
            'Aug' => 'AGO',
            'Sep' => 'SET',
            'Oct' => 'OUT',
            'Nov' => 'NOV',
            'Dec' => 'DEZ'
        ];

        $data = [
            'lancamento_id' => $lancamentoID,
            'ano' => $ano,
            'membro_id' => $membroId,
            'mes' => strtolower($monthsMap[$mes]),
            'valor' => $valor,
            'dt' => $date
        ];

        $this->handleLancamento($data);
    }

    private function handleLancamento($data)
    {
        // Encontrar o lançamento antigo
        $lancamento = FinanceiroLancamento::findOrFail($data['lancamento_id']);
        // Extrair o ano e o mês da data de lançamento antigo
        $ano = Carbon::parse($lancamento->data_movimento)->year;
        $mes = strtolower(Carbon::parse($lancamento->data_movimento)->format('M'));
        // Mapeamento dos meses para abreviações em português
        $monthsMap = [
            'jan' => 'jan',
            'feb' => 'fev',
            'mar' => 'mar',
            'apr' => 'abr',
            'may' => 'mai',
            'jun' => 'jun',
            'jul' => 'jul',
            'aug' => 'ago',
            'sep' => 'set',
            'oct' => 'out',
            'nov' => 'nov',
            'dec' => 'dez'
        ];

        // Converter o mês para a abreviação em português
        $mes = $monthsMap[$mes] ?? $mes;

        // Verificar se já existe um registro para o membro_id, ano e mês específico
        $existingLancamentoOld = FinanceiroGrade::where('membro_id', $data['membro_id'])
            ->where('ano', $ano)
            ->where('igreja_id', session()->get('session_perfil')->instituicao_id)
            ->where(function ($query) use ($mes) {
                $query->where($mes, '!=', null)
                    ->orWhere($mes, '!=', '0');
            })
            ->first();
       
        if ($existingLancamentoOld) {
            $total = $existingLancamentoOld->$mes - $data['valor'];
            $existingLancamentoOld->update([$mes => $total]);
        }
    }
}
