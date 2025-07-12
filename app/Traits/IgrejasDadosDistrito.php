<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

trait IgrejasDadosDistrito
{
    public static function fetchCongregacoesPorIgrejas($params)
    {
        $distritoId = $params['distritoId'];
        $igrejas = DB::table('instituicoes_instituicoes as igreja')
            ->select(
                'distrito.id',
                'distrito.nome as distrito_nome',
                'igreja.id as id_igreja',
                'igreja.nome as igreja_nome',
            )->join('instituicoes_instituicoes as distrito', function ($join) {
                $join->on('distrito.id', '=', 'igreja.instituicao_pai_id');
            })
            ->where(['distrito.id' => $distritoId])
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
}
