<?php

namespace App\Services\ServiceFinanceiroRelatorios;

use App\Traits\BalanceteUtils;
use App\Traits\Identifiable;
use Carbon\Carbon;

class BalanceteRegiaoService
{
    use BalanceteUtils, Identifiable;

    public function execute($dataInicial, $dataFinal, $caixaId, $regiao, $instituicaoId)
    {
        //if($instituicaoId != 'all'){
        //$instituicaoId = session()->get('session_perfil')->instituicao_id;
            $instituicaoId = $instituicaoId;
            if (empty($dataInicial)) {
                $dataInicial = Carbon::now()->format('m/Y');
            }

            if (empty($dataFinal)) {
                $dataFinal = Carbon::now()->format('m/Y');
            }
            $igreja = Identifiable::fetchIgreja($instituicaoId);
            $tituloNome = 'Discriminação dos Lançamentos por Conta: ';
            return [
                'instituicao'   => $instituicaoId,
                'caixas'        => BalanceteUtils::handleCaixasRegiao($dataInicial, $dataFinal, $caixaId, $instituicaoId),
                'caixasSelect'  => BalanceteUtils::handleListaCaixas($instituicaoId),
                'lancamentos'   => BalanceteUtils::handleLancamentosRegiao($dataInicial, $dataFinal, $caixaId, $instituicaoId),
                'igrejas'       => BalanceteUtils::handleListaIgrejasByRegiao($regiao->id),
                'titulo'        => isset($igreja->nome) ? $tituloNome.$igreja->nome : $tituloNome.'Todas',
            ];
        /*}else{
            $totasIgrejas = BalanceteUtils::handleListaIgrejasByRegiao($regiao->id);
            foreach($totasIgrejas as $igreja){
                $instituicaoId = $igreja->id;
                if (empty($dataInicial)) {
                    $dataInicial = Carbon::now()->format('m/Y');
                }

                if (empty($dataFinal)) {
                    $dataFinal = Carbon::now()->format('m/Y');
                }
                $caixas = BalanceteUtils::handleCaixas($dataInicial, $dataFinal, $caixaId, $instituicaoId);
                if(count($caixas) > 0){
                    $conteudoIgrejas [] = [
                        'instituicao'   => $instituicaoId,
                        'caixas'        => $caixas,
                        'caixasSelect'  => BalanceteUtils::handleListaCaixas($instituicaoId),
                        'lancamentos'   => BalanceteUtils::handleLancamentos($dataInicial, $dataFinal, $caixaId, $instituicaoId),
                        'igrejas'       => BalanceteUtils::handleListaIgrejasByRegiao($regiao->id),
                        'igrejaNome'    => $igreja->descricao,
                    ];
                }
            }
            return [
                'igrejas'   => BalanceteUtils::handleListaIgrejasByRegiao($regiao->id),
                'conteudos' => $conteudoIgrejas,
                'igrejaNome'    => 'Todas Igrejas', 
            ];
        }*/
    }
}
