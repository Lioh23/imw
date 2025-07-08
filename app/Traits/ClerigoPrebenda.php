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
                DB::raw("(SELECT CONCAT(iii.nome) FROM instituicoes_instituicoes iii WHERE iii.id = pp.igreja_id) igreja")
            )
            ->join('pessoas_nomeacoes as pn', function ($join) {
                $join->on('pp.id', '=', 'pn.pessoa_id')
                    ->whereNull('pn.deleted_at');
            })
            ->join('instituicoes_instituicoes as ii', function ($join) {
                $join->on('pn.instituicao_id', '=', 'ii.id')->where('ii.ativo', '=', 1);
            })
            ->when($params['mes'], fn ($query) => $query->whereMonth('data_nascimento', $params['mes']))
            ->where(['pp.status_id' => 1, 'pp.regiao_id' => $regiao])
            ->orderBy('pp.nome')
            ->groupBy('id', 'pp.nome', 'pp.data_nascimento', 'pp.telefone_preferencial', 'pp.telefone_alternativo', 'imwpgahml.pp.igreja_id')
            ->get();
        $clerigosIgrejas = [];
        foreach($clerigos as $clerigo){
            $igrejas = DB::table('pessoas_pessoas as pp')
            ->select(
                'pp.id as id',
                'pp.nome as nome',
                'ii.nome as igreja'
            )
            ->join('pessoas_nomeacoes as pn', function ($join) {
                $join->on('pp.id', '=', 'pn.pessoa_id')
                    ->whereNull('pn.deleted_at');
            })
            ->join('instituicoes_instituicoes as ii', function ($join) {
                $join->on('pn.instituicao_id', '=', 'ii.id')->where('ii.ativo', '=', 1);
            })
            ->where(['pp.status_id' => 1, 'pp.regiao_id' => $regiao, 'pp.id' => $clerigo->id])
            ->orderBy('pp.nome')
            ->get();
            $clerigosIgrejas[] = ['clerigo' => $clerigo, 'igrejas' => $igrejas];
        }        
        return $clerigosIgrejas;
    }
}
