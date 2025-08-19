<?php

namespace App\Services\ServiceFinanceiro;

use App\Models\FinanceiroFornecedores;
use App\Models\FinanceiroLancamento;
use App\Models\MembresiaMembro;
use App\Models\PessoasPessoa;
use App\Models\FinanceiroGrade;
use Carbon\Carbon;

class StoreLancamentoEntradaService
{
    public function execute(array $data)
    {
        /* 
            tipo_pagante_favorecido_id 
            1 = MEMBRO
            2 = FORNECEDOR
            3 = CLERIGO
        */
       
        $tipoPaganteFavorecidoId = $data['tipo_pagante_favorecido_id'];
        $paganteFavorecido = $data['pagante_favorecido'];
        $lancamentos = [
            'data_lancamento' => Carbon::now()->format('Y-m-d'),
            'valor' => str_replace(',', '.', str_replace('.', '', $data['valor'])),
            'tipo_pagante_favorecido_id' => $tipoPaganteFavorecidoId,
            'descricao' => $data['descricao'],
            'tipo_lancamento' => FinanceiroLancamento::TP_LANCAMENTO_ENTRADA, 
            'plano_conta_id' => $data['plano_conta_id'],
            'data_movimento' => $data['data_movimento'],
            'data_ano_mes' => formatMesAnoDizimo($data['ano_mes']),
            'caixa_id' => $data['caixa_id'],
            'instituicao_id' => session()->get('session_perfil')->instituicao_id
        ];
        $paganteFavorecidoModel = null;
        $campoId = null;
        switch ($tipoPaganteFavorecidoId) {
            
            case 1:
                $paganteFavorecidoModel = MembresiaMembro::find($paganteFavorecido);
                $campoId = 'membro_id';
                if ($paganteFavorecidoModel) {
                    $planoContaIds = [3, 4, 5, 6, 110172, 110173, 110174, 110186];
                    if ($paganteFavorecidoModel && in_array($lancamentos['plano_conta_id'], $planoContaIds)) {
                        $this->handleLivroGrade($paganteFavorecidoModel->id, $lancamentos['valor'], $lancamentos['data_movimento'], $lancamentos['data_ano_mes']);
                    }
                }
                break;
            case 2:
                $paganteFavorecidoModel = FinanceiroFornecedores::find($paganteFavorecido);
                $campoId = 'fornecedores_id';
                break;
            case 3:
                $paganteFavorecidoModel = PessoasPessoa::find($paganteFavorecido);
                $campoId = 'clerigo_id';
                break;
            default:
                $lancamentos['pagante_favorecido'] = $paganteFavorecido;
                break;
        }

        if ($paganteFavorecidoModel) {
            $lancamentos['pagante_favorecido'] = $paganteFavorecidoModel->nome;
            $lancamentos[$campoId] = $paganteFavorecido;
        }
        //unset($lancamentos['ano_mes']);
        FinanceiroLancamento::create($lancamentos);

    }

    private function handleLivroGrade($membroId, $valor, $dataMovimento, $dataAnoMes){
        //$date = Carbon::parse($dataMovimento);
        $date = Carbon::parse($dataAnoMes);
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
            'ano' => $ano,
            'membro_id' => $membroId,
            'mes' => strtolower($monthsMap[$mes]),
            'valor' => $valor,
            'data_ano_mes' => $dataAnoMes
        ];

        $this->handleLancamento($data);

    }

    private function handleLancamento($data) {
        // Verificar se já existe um registro para o membro_id, ano e mês específico
        $existingLancamento = FinanceiroGrade::where('membro_id', $data['membro_id'])
            ->where('ano', $data['ano'])
            ->where(function ($query) use ($data) {
                $query->where($data['mes'], '!=', null)
                    ->orWhere($data['mes'], '!=', '0.00');
            })
            ->first();
            
        if ($existingLancamento) {
            // Se o registro já existe, atualize-o
            $mes = $data['mes'];
            $valorTotal = floatval($existingLancamento->$mes) + floatval($data['valor']); 
            $existingLancamento->update([$data['mes'] => $valorTotal]);
            return $existingLancamento;
        } else {
            // Se não existir, crie um novo registro
            return FinanceiroGrade::create([
                'membro_id' => $data['membro_id'],
                'ano' => $data['ano'],
                $data['mes'] => $data['valor'],
                'distrito_id' => session()->get('session_perfil')->instituicoes->distrito->id,
                'igreja_id' => session()->get('session_perfil')->instituicoes->igrejaLocal->id,
                'regiao_id' => session()->get('session_perfil')->instituicoes->regiao->id,
                'data_ano_mes' => $data['data_ano_mes'],
            ]);
        }
    }
} 
