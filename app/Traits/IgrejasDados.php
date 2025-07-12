<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

trait IgrejasDados
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

    public static function fetchClerigoDados($regiao, $params)
    {
        $clerigos = DB::table('pessoas_pessoas as pp')
            ->select(
                'pp.id',
                'pp.nome',
                'pp.email',
                'pp.identidade',
                'pp.orgao_emissor',
                DB::raw("DATE_FORMAT(pp.data_emissao, '%d/%m/%Y') data_emissao"),
                'pp.cpf',
                DB::raw("DATE_FORMAT(pp.data_nascimento, '%d/%m/%Y') data_nascimento"),
                DB::raw("TIMESTAMPDIFF(YEAR, data_nascimento, curdate()) idade"),
                DB::raw("CASE WHEN telefone_preferencial IS NOT NULL AND telefone_preferencial <> '' THEN telefone_preferencial
                              WHEN telefone_alternativo IS NOT NULL AND telefone_alternativo <> '' THEN telefone_alternativo
                              ELSE '' END contato"),
                DB::raw("(SELECT CONCAT(iii.nome) FROM instituicoes_instituicoes iii WHERE iii.id = pp.igreja_id) igreja"),
                'pp.pais',
                'pp.uf',
                'pp.cep',
                'pp.cidade',
                'pp.bairro',
                'pp.endereco',
                'pp.numero',
                'pp.complemento',
            )
            ->join('pessoas_nomeacoes as pn', function ($join) {
                $join->on('pp.id', '=', 'pn.pessoa_id')
                    ->whereNull('pn.data_termino');
            })
            ->join('instituicoes_instituicoes as ii', function ($join) {
                $join->on('pn.instituicao_id', '=', 'ii.id');//*->where('ii.ativo', '=', 1);*/
            })
            ->when($params['status'] === '0' || $params['status'] === '1', fn ($query) => $query->where('ii.ativo', $params['status']))
            ->where(['pp.status_id' => 1, 'pp.regiao_id' => $regiao])
            ->orderBy('pp.nome')
            ->groupBy('id', 'pp.nome', 'pp.data_nascimento', 'pp.telefone_preferencial', 'pp.telefone_alternativo', 'pp.igreja_id','pp.email', 'pp.identidade', 'pp.orgao_emissor', 'pp.data_emissao', 'pp.cpf','pp.pais', 'pp.uf', 'pp.cep', 'pp.cidade', 'pp.bairro', 'pp.endereco', 'pp.numero','pp.complemento')
            ->get();
        return $clerigos;
    }
}
