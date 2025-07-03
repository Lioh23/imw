<?php

namespace App\Traits;

use App\Models\InstituicoesTipoInstituicao;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

trait ClerigoPrebenda
{
    public static function fetchClerigoAniversarinates($regiao, $params)
    {
        $clerigos = DB::table('pessoas_pessoas as pp')
            ->select(
                'pp.id as id',
                'pp.nome as nome',
                DB::raw("DATE_FORMAT(pp.data_nascimento, '%d/%m/%Y') data_nascimento"),
                DB::raw("DATE_FORMAT(pp.data_nascimento, '%d/%m') aniversario"),
                DB::raw("TIMESTAMPDIFF(YEAR, data_nascimento, curdate()) idade"),
                DB::raw("CASE WHEN telefone_preferencial IS NOT NULL AND telefone_preferencial <> '' THEN telefone_preferencial
                              WHEN telefone_alternativo IS NOT NULL AND telefone_alternativo <> '' THEN telefone_alternativo
                              ELSE '' END contato"),
                DB::raw("(SELECT iii.nome FROM instituicoes_instituicoes iii WHERE iii.id = pp.igreja_id) igreja")
            )
            ->join('instituicoes_instituicoes as ii', function ($join) {
                $join->on('pp.regiao_id', '=', 'ii.id');
            })
            ->when($params['mes'], fn ($query) => $query->whereMonth('data_nascimento', $params['mes']))
            ->where(['pp.status_id' => 1, 'pp.regiao_id' => $regiao])
            ->orderBy('pp.nome')
            ->get();
        return $clerigos;
    }
}
