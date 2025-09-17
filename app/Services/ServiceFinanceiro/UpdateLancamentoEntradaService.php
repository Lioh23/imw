<?php

namespace App\Services\ServiceFinanceiro;

use App\Models\FinanceiroFornecedores;
use App\Models\FinanceiroGrade;
use App\Models\FinanceiroLancamento;
use App\Models\MembresiaMembro;
use App\Models\PessoasPessoa;
use Carbon\Carbon;

class UpdateLancamentoEntradaService
{
    public function execute(array $data, $id)
    {
        $lancamento = FinanceiroLancamento::findOrFail($id);

        /* 
            tipo_pagante_favorecido_id 
            1 = MEMBRO
            2 = FORNECEDOR
            3 = CLERIGO
        */
        $ano = isset($data['ano']) ? $data['ano'] : '';
        $mes = isset($data['mes']) ? $data['mes'] : '';
        if($ano){
            $anoMes = $mes.'/'.$ano;
        }else{
            $anoMes = '';
        }
        $tipoPaganteFavorecidoId = $data['tipo_pagante_favorecido_id'];
        $paganteFavorecido = $data['pagante_favorecido'] ?? null;
        $lancamento->data_lancamento = Carbon::now()->format('Y-m-d');
        $lancamento->valor = str_replace(',', '.', str_replace('.', '', $data['valor']));
        $lancamento->descricao = $data['descricao'];
        $lancamento->tipo_lancamento = FinanceiroLancamento::TP_LANCAMENTO_ENTRADA;
        $lancamento->plano_conta_id = $data['plano_conta_id'];
        $lancamento->data_movimento = $data['data_movimento'];
        $lancamento->data_ano_mes = $ano ? formatMesAnoDizimo($anoMes) : null;
        $lancamento->caixa_id = $data['caixa_id'];
        $lancamento->instituicao_id = session()->get('session_perfil')->instituicao_id;
        $lancamento->decimo_terceiro = $mes == 13 ? 1 : 0;
        $dataAnoMes = formatMesAnoDizimo($anoMes);

        switch ($tipoPaganteFavorecidoId) {
            case 1:
                $paganteFavorecidoModel = MembresiaMembro::find($paganteFavorecido);
                $campoId = 'membro_id';
                $planoContaIds = [3, 4, 5, 6, 110172, 110173, 110174, 110186];
                if ($paganteFavorecidoModel && in_array($data['plano_conta_id'], $planoContaIds)) {
                    $this->handleLivroGrade($paganteFavorecidoModel->id, $lancamento->valor, $lancamento->data_movimento, $lancamento->id, $dataAnoMes, $mes);
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
                $lancamento->pagante_favorecido = $paganteFavorecido;
                break;
        }

        if (isset($paganteFavorecidoModel)) {
            $lancamento->pagante_favorecido = $paganteFavorecidoModel->nome;
            if ($paganteFavorecido !== null) {
                $lancamento->$campoId = $paganteFavorecido;
            }
        }
        $lancamento->save();
    }

    private function handleLivroGrade($membroId, $valor, $dataMovimento, $lancamentoID, $dataAnoMes, $mes)
    {
        if($mes == 13){
            $decimoTerceiro = 13;
        }else{
            $decimoTerceiro = 0;
        }
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
        $mesBase = strtolower($monthsMap[$mes]);

        $data = [
            'lancamento_id' => $lancamentoID,
            'ano' => $ano,
            'membro_id' => $membroId,
            'mes' => $mesBase,
            'valor' => $valor,
            'dt' => $date,
            'data_ano_mes' => $dataAnoMes
        ];
        $mes = $decimoTerceiro ? $decimoTerceiro : $mesBase;
        $this->handleLancamento($data, $mes);
    }

    private function handleLancamento($data, $mes)
    {
        // Encontrar o lançamento antigo
        $lancamento = FinanceiroLancamento::findOrFail($data['lancamento_id']);
        FinanceiroLancamento::findOrFail($data['lancamento_id'])->update(['data_ano_mes' => $data['data_ano_mes']]);
        // Extrair o ano e o mês da data de lançamento antigo
        $ano = Carbon::parse($lancamento->data_ano_mes)->year;
        $dtold = Carbon::parse($lancamento->data_ano_mes);
        $dtnow = Carbon::parse($data['data_ano_mes']);
        if($mes == 13){
            $mes = 'o13';
        }else{
            $mes = strtolower(Carbon::parse($lancamento->data_ano_mes)->format('M'));

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
        }
        
        // Verificar se já existe um registro para o membro_id, ano e mês específico
        $existingLancamentoOld = FinanceiroGrade::where('membro_id', $data['membro_id'])
            ->where('ano', $ano)
            ->where('igreja_id', session()->get('session_perfil')->instituicao_id)
            ->where(function ($query) use ($mes) {
                $query->where($mes, '!=', null)
                    ->orWhere($mes, '!=', '0');
            })
            ->first();
        if (!$existingLancamentoOld) {
            FinanceiroGrade::create([
                'membro_id' => $data['membro_id'],
                'ano' => $ano,
                $mes => $data['valor'],
                'distrito_id' => session()->get('session_perfil')->instituicoes->distrito->id,
                'igreja_id' => session()->get('session_perfil')->instituicoes->igrejaLocal->id,
                'regiao_id' => session()->get('session_perfil')->instituicoes->regiao->id
            ]);
        } else {
            //ATENÇÃO! MESMA DATA
            if ($dtold->format('Y-m') === $dtnow->format('Y-m')) {

                if ($existingLancamentoOld->$mes == 0) {
                    $total = $data['valor'];
                } else {
                    $total = $existingLancamentoOld->$mes - $lancamento->valor + $data['valor'];
                }
                // ZERAR VALOR
                if ($existingLancamentoOld) {
                    $existingLancamentoOld->update([$mes => $total]);
                }
                //ATENÇÃO! DATAS DIFERENTES
            } else {
                // Diminuir no mês anterior.
                $total = $existingLancamentoOld->$mes - $lancamento->valor;
                $existingLancamentoOld->update([$mes => $total]);

                $existingLancamento = FinanceiroGrade::where('membro_id', $data['membro_id'])
                    ->where('ano', $data['ano'])
                    ->where('igreja_id', session()->get('session_perfil')->instituicao_id)
                    ->where(function ($query) use ($data) {
                        $query->where($data['mes'], '!=', null)
                            ->orWhere($data['mes'], '!=', '0.00');
                    })
                    ->first();
                // Se o registro já existe, atualize.
                if ($existingLancamento) {
                    $mes = $data['mes'];
                    $valorTotal = floatval($existingLancamento->$mes) + floatval($data['valor']);
                    $existingLancamento->update([$data['mes'] => $valorTotal]);
                } else {
                    FinanceiroGrade::create([
                        'membro_id' => $data['membro_id'],
                        'ano' => $data['ano'],
                        $data['mes'] => $data['valor'],
                        'distrito_id' => session()->get('session_perfil')->instituicoes->distrito->id,
                        'igreja_id' => session()->get('session_perfil')->instituicoes->igrejaLocal->id,
                        'regiao_id' => session()->get('session_perfil')->instituicoes->regiao->id
                    ]);
                }
            }
        }
    }
}
