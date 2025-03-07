<?php

namespace App\Traits;

use App\Models\InstituicoesTipoInstituicao;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait TotalizacaoRegiaoUtils
{

    public static function fetchTotalDistroRegiao($regiaoId)
    {
        $result = DB::table('instituicoes_instituicoes as ii')
            ->join('instituicoes_instituicoes as ip', 'ii.instituicao_pai_id', '=', 'ip.id')
            ->selectRaw('COUNT(*) as total, ip.nome')
            ->where('ip.tipo_instituicao_id', InstituicoesTipoInstituicao::REGIAO)
            ->where('ii.tipo_instituicao_id', InstituicoesTipoInstituicao::DISTRITO)
            ->where('ip.id', $regiaoId)
            ->where('ii.ativo', 1)
            ->groupBy('ii.instituicao_pai_id', 'ip.nome')
            ->get();


        return $result;
    }

    public static function fetchTotalIgrejasPorDistrito($regiaoId)
    {
        $result = DB::table('instituicoes_instituicoes as ii')
            ->join('instituicoes_instituicoes as ip', 'ii.instituicao_pai_id', '=', 'ip.id')
            ->selectRaw('COUNT(*) as total, ip.nome')
            ->where('ip.tipo_instituicao_id', InstituicoesTipoInstituicao::DISTRITO)
            ->where('ii.tipo_instituicao_id', InstituicoesTipoInstituicao::IGREJA_GERAL)
            ->orWhere('ii.tipo_instituicao_id', operator: InstituicoesTipoInstituicao::IGREJA_LOCAL)
            ->where('ip.regiao_id', $regiaoId)
            ->where('ii.ativo', 1)
            ->groupBy('ii.instituicao_pai_id', 'ip.nome')
            ->orderByDesc('total')
            ->get();
        $total = $result->sum('total');
        $totalPorcentagem = $result->map(function ($distrito) use ($total) {
            $distrito->percentual = ($total > 0) ? ($distrito->total * 100) / $total : 0;
            return $distrito;
        });
        return $totalPorcentagem;
    }
    public static function fetchTotalCongregacoesPorIgrejas($regiaoId)
    {
        $result = DB::table('instituicoes_instituicoes as ii')
            ->join('congregacoes_congregacoes as cc', 'ii.id', '=', 'cc.instituicao_id')
            ->selectRaw('COUNT(*) as total, ii.nome')
            ->where('ii.tipo_instituicao_id', InstituicoesTipoInstituicao::IGREJA_LOCAL)
            ->where('ii.regiao_id', $regiaoId)
            ->where('ii.ativo', 1)
            ->where('cc.ativo', 1)
            ->groupBy('ii.instituicao_pai_id', 'ii.nome')
            ->orderByDesc('total')
            ->get();

        $total = $result->sum('total');
        $totalPorcentagem = $result->map(function ($igrejas) use ($total) {
            $igrejas->percentual = ($total > 0) ? ($igrejas->total * 100) / $total : 0;
            return $igrejas;
        });
        return $totalPorcentagem;
    }

    public static function fetchTotalCongregacoesPorDistritos($regiaoId)
    {
        $result = DB::table('instituicoes_instituicoes as ii')
            ->join('congregacoes_congregacoes as cc', 'ii.id', '=', 'cc.instituicao_id')
            ->join('instituicoes_instituicoes as ip', 'ip.id', '=', 'ii.instituicao_pai_id')
            ->selectRaw('COUNT(*) as total, ip.nome')
            ->where('ip.tipo_instituicao_id', InstituicoesTipoInstituicao::DISTRITO)
            ->where('ii.ativo', 1)
            ->where('ip.regiao_id', $regiaoId)
            ->where('cc.ativo', 1)
            ->groupBy('ii.instituicao_pai_id', 'ip.nome')
            ->orderByDesc('total')
            ->get();
        $total = $result->sum('total');
        $totalPorcentagem = $result->map(function ($distritos) use ($total) {
            $distritos->percentual = ($total > 0) ? ($distritos->total * 100) / $total : 0;
            return $distritos;
        });
        return $totalPorcentagem;
    }
}
