<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

trait AnoEclesiastico
{
    public static function fetchCongregacoesPorIgrejas($regiao, $params)
    {
        $igrejas = DB::table('instituicoes_instituicoes as igreja')
            ->select(
                'distrito.id',
                'distrito.nome as distrito_nome',
                'igreja.id as id_igreja',
                'igreja.nome as igreja_nome',
            )->join('instituicoes_instituicoes as distrito', function ($join) {
                $join->on('distrito.id', '=', 'igreja.instituicao_pai_id');
            })
            ->where(['distrito.instituicao_pai_id' => $regiao])
            ->orderBy('distrito.nome')
            ->orderBy('igreja.id')
            ->get();
        $congregacoesIgrejas = [];
        foreach($igrejas as $item){
            $congregacao = DB::table('congregacoes_congregacoes as cc')->where(['cc.instituicao_id' => $item->id_igreja, 'cc.ativo' => 1])->first();
            if($params['congregacao'] == 1){
                if($congregacao){
                    $congregacoes = DB::table('congregacoes_congregacoes as cc')
                    ->select(
                        'cc.nome as congregacao',
                    )
                    ->where(['cc.instituicao_id' => $item->id_igreja, 'cc.ativo' => 1])
                    ->orderBy('cc.nome')
                    ->get();
                    $congregacoesIgrejas[] = (object)['igreja' => $item, 'congregacoes' => $congregacoes];
                }
            }else{
                if(!$congregacao){
                    $congregacoes = [];
                    $congregacoesIgrejas[] = (object)['igreja' => $item, 'congregacoes' => $congregacoes];
                }
            }
            
        }
        return $congregacoesIgrejas;
    }

    public static function fetchCnpjIgrejas($regiao, $params)
    {
        $igrejas = DB::table('instituicoes_instituicoes as igreja')
            ->select(
                'distrito.id',
                'distrito.nome as distrito_nome',
                'igreja.id as id_igreja',
                'igreja.nome as igreja_nome',
                'igreja.cnpj',
            )->join('instituicoes_instituicoes as distrito', function ($join) {
                $join->on('distrito.id', '=', 'igreja.instituicao_pai_id');
            })
            ->where(['distrito.instituicao_pai_id' => $regiao])
            ->orderBy('distrito.nome')
            ->orderBy('igreja.id')
            ->get();
        return $igrejas;
    }

    public static function fetchContatoIgrejas($regiao, $params)
    {
        $igrejas = DB::table('instituicoes_instituicoes as igreja')
            ->select(
                'distrito.id',
                'distrito.nome as distrito_nome',
                'igreja.id as id_igreja',
                'igreja.nome as igreja_nome',
                'igreja.email',
                'igreja.ddd', 
                'igreja.telefone',
            )->join('instituicoes_instituicoes as distrito', function ($join) {
                $join->on('distrito.id', '=', 'igreja.instituicao_pai_id');
            })
            ->where(['distrito.instituicao_pai_id' => $regiao])
            ->orderBy('distrito.nome')
            ->orderBy('igreja.id')
            ->get();
        return $igrejas;
    }

    public static function fetchContaBancariaIgreja($regiao, $params)
    {
        $igrejas = DB::table('instituicoes_instituicoes as igreja')
            ->select(
                'distrito.id',
                'distrito.nome as distrito_nome',
                'igreja.id as id_igreja',
                'igreja.nome as igreja_nome',
                'fc.descricao as conta_bancaria',
            )->join('instituicoes_instituicoes as distrito', function ($join) {
                $join->on('distrito.id', '=', 'igreja.instituicao_pai_id');
            })->join('financeiro_caixas as fc', function ($join) {
                $join->on('igreja.id', '=', 'fc.instituicao_id');
            })
            ->where(['distrito.instituicao_pai_id' => $regiao, 'fc.tipo' => 'B'])
            ->orderBy('distrito.nome')
            ->orderBy('igreja.id')
            ->get();
        return $igrejas;
    }
}
