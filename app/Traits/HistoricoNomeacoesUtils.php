<?php

namespace App\Traits;

use App\Models\InstituicoesTipoInstituicao;
use Illuminate\Support\Facades\DB;

trait HistoricoNomeacoesUtils
{
    public static function fetchHistoricoNomeacoes($regiao, $visao)
    {

        if ($visao == 1) {
            $clerigos = DB::table('pessoas_pessoas as pp')
                ->select(
                    'pp.id as id',
                    'pp.nome as nome',
                    'ii_pai.nome as distrito',
                    'ii.nome as igreja',
                    'pn.data_nomeacao as inicio_nomeacao',
                    'pn.data_termino as fim_nomeacao'
                )
                ->join('pessoas_nomeacoes as pn', function ($join) {
                    $join->on('pp.id', '=', 'pn.pessoa_id')
                        ->whereNull('pn.deleted_at');
                })
                ->join('instituicoes_instituicoes as ii', function ($join) {
                    $join->on('pn.instituicao_id', '=', 'ii.id')
                        ->where('ii.ativo', '=', 1);
                })
                ->leftJoin('instituicoes_instituicoes as ii_pai', 'ii.instituicao_pai_id', '=', 'ii_pai.id')
                ->where('pp.status', 0)
                ->orderBy('pp.nome')
                ->orderByDesc('pn.data_nomeacao')
                ->get()
                ->groupBy('id');
            return $clerigos;
        } else {
            $igrejas = DB::table('pessoas_pessoas as pp')
                ->select(
                    'ii.id as id',
                    'ii.nome as nome',
                    'ii_pai.nome as distrito',
                    'pn.data_nomeacao as inicio_nomeacao',
                    'pn.data_termino as fim_nomeacao',
                    'pp.id as clerigo_id',
                    'pp.nome as clerigo'
                )
                ->join('pessoas_nomeacoes as pn', function ($join) {
                    $join->on('pp.id', '=', 'pn.pessoa_id')
                        ->whereNull('pn.deleted_at');
                })
                ->join('instituicoes_instituicoes as ii', function ($join) {
                    $join->on('pn.instituicao_id', '=', 'ii.id')
                        ->where('ii.ativo', '=', 1)
                        ->where('ii.tipo_instituicao_id', '=', InstituicoesTipoInstituicao::IGREJA_LOCAL);
                })
                ->leftJoin('instituicoes_instituicoes as ii_pai', 'ii.instituicao_pai_id', '=', 'ii_pai.id')
                ->where('pp.status', 0)

                ->orderBy('ii.nome') // Ordena pelo nome da igreja
                ->orderByDesc('pn.data_nomeacao') // Ordena por data de nomeação (mais recente primeiro)
                ->get()
                ->groupBy('id'); // Agrupa os dados pela igreja
            return $igrejas;
        }
    }
}
