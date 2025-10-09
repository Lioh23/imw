<?php

namespace App\Traits;

use App\Models\InstituicoesTipoInstituicao;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

trait ClerigoEsposa
{
    public static function fetchClerigoEsposa($regiao, $params)
    {
        $clerigos = DB::table('pessoas_pessoas as pp')
            ->select(
                'pp.id as id',
                'pp.nome as nome',
                DB::raw("DATE_FORMAT(pp.data_nascimento, '%d/%m/%Y') data_nascimento"),
                DB::raw("DATE_FORMAT(pp.data_nascimento, '%d/%m') aniversario"),
                DB::raw("TIMESTAMPDIFF(YEAR, pp.data_nascimento, curdate()) idade"),
                DB::raw("CASE WHEN telefone_preferencial IS NOT NULL AND telefone_preferencial <> '' THEN telefone_preferencial
                              WHEN telefone_alternativo IS NOT NULL AND telefone_alternativo <> '' THEN telefone_alternativo
                              ELSE '' END contato"),
                'pd.nome as nome_esposa',
                DB::raw("(SELECT CONCAT(iii.nome) FROM instituicoes_instituicoes iii WHERE iii.id = pp.igreja_id) igreja")
            )
            ->join('pessoas_nomeacoes as pn', function ($join) {
                $join->on('pp.id', '=', 'pn.pessoa_id')
                    ->whereNull('pn.data_termino');
            })
            ->join('pessoas_dependentes as pd', function ($join) {
                $join->on('pd.pessoa_id', 'pp.id');
            })
            ->join('instituicoes_instituicoes as ii', function ($join) {
                $join->on('pn.instituicao_id', '=', 'ii.id')->where('ii.ativo', '=', 1);
            })
            //->when($params['mes'], fn ($query) => $query->whereMonth('pp.data_nascimento', $params['mes']))
            ->where(['pp.status_id' => 1, 'pp.regiao_id' => $regiao, 'pd.parentesco' => 'Cônjuge'])
            ->orderBy('pp.nome')
            ->groupBy('id', 'pp.nome', 'pp.data_nascimento', 'pp.telefone_preferencial', 'pp.telefone_alternativo', 'pp.igreja_id', 'pd.nome')
            ->get();             
        return $clerigos;
    }
    
}
