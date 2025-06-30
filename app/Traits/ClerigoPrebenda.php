<?php

namespace App\Traits;

use App\Models\InstituicoesTipoInstituicao;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

trait ClerigoPrebenda
{
    public static function fetchClerigoAniversarinates($regiao)
    {
        $clerigos = DB::table('pessoas_pessoas as pp')
            ->select(
                'pp.id as id',
                'pp.nome as nome',
                'ii_pai.nome as distrito',
                'ii.nome as igreja',
                'pn.data_nomeacao as inicio_nomeacao',
                'pn.data_termino as fim_nomeacao',
                'pf.funcao as funcao_ministerial'
            )
            ->join('pessoas_nomeacoes as pn', function ($join) {
                $join->on('pp.id', '=', 'pn.pessoa_id')
                    ->whereNull('pn.deleted_at');
            })
            ->join('instituicoes_instituicoes as ii', function ($join) {
                $join->on('pn.instituicao_id', '=', 'ii.id')
                    ->where('ii.ativo', '=', 1);
            })
            ->leftJoin('pessoas_funcaoministerial as pf', 'pf.id', '=', 'pn.funcao_ministerial_id')
            ->leftJoin('instituicoes_instituicoes as ii_pai', 'ii.instituicao_pai_id', '=', 'ii_pai.id')
            ->where(['pp.status_id' => 1, 'pp.regiao_id' => 23])
            ->when(request()->get('situacao'), function ($query) {
                $query->where('pf.titular', request()->get('situacao'));
            })
            ->when(request()->get('ativo'), function ($query) {
                $query->whereNull('pn.data_termino');
            })
            ->orderBy('pp.nome')
            ->orderByDesc('pn.data_nomeacao')
            ->get()
            ->groupBy('id');
        return $clerigos;
    }
}
