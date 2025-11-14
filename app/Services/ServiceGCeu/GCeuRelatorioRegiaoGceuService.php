<?php

namespace App\Services\ServiceGCeu;

use App\Models\GCeu;
use Illuminate\Support\Facades\DB;

class GCeuRelatorioRegiaoGceuService
{
    public function getList($regiaoId)
    {
        $dados = DB::table('instituicoes_instituicoes as igreja')
            ->select(
                'distrito.id',
                'distrito.nome as distrito_nome',
                'igreja.id as id_igreja',
                'igreja.nome as igreja_nome',
                'gceu.*',
            )->join('instituicoes_instituicoes as distrito', function ($join) {
                $join->on('distrito.id', '=', 'igreja.instituicao_pai_id');
            })->join('instituicoes_instituicoes as regiao', function ($join) {
                $join->on('regiao.id', '=', 'distrito.instituicao_pai_id');
            })
            ->join('gceu_cadastros as gceu', function ($join) {
                $join->on('gceu.instituicao_id', '=', 'igreja.id');
            })
            ->where(['regiao.id' => $regiaoId, 'gceu.status' => 'A'])
            ->when(request()->get('distrito_id'), function ($query) {
                $query->where('distrito.id', request()->get('distrito_id'));
            })
            ->when(request()->get('igreja_id'), function ($query) {
                $query->where('igreja.id', request()->get('igreja_id'));
            })
            ->orderBy('distrito.nome')
            ->orderBy('igreja.id')
            ->get();
        

        $distritos = DB::table('instituicoes_instituicoes as distrito')
            ->select(
                'distrito.id',
                'distrito.nome as distrito_nome',
            )->join('instituicoes_instituicoes as regiao', function ($join) {
                $join->on('regiao.id', '=', 'distrito.instituicao_pai_id');
            })
            ->where(['regiao.id' => $regiaoId, 'distrito.tipo_instituicao_id' => 2])
            ->orderBy('distrito.nome')
            ->get();
        
    
        $igrejas = DB::table('instituicoes_instituicoes as igreja')
        ->select(
            'igreja.id as id_igreja',
            'igreja.nome as igreja_nome',
        )->join('instituicoes_instituicoes as distrito', function ($join) {
            $join->on('distrito.id', '=', 'igreja.instituicao_pai_id');
        })->join('instituicoes_instituicoes as regiao', function ($join) {
            $join->on('regiao.id', '=', 'distrito.instituicao_pai_id');
        })
        ->where(['regiao.id' => $regiaoId, 'igreja.tipo_instituicao_id' => 1])
        ->orderBy('igreja.nome')
        ->get();
        
        // $distritoId = request()->get('distrito_id');
        // if(request()->get('distrito_id')){
        //     $distritoId = request()->get('distrito_id');
        //      $igrejas = DB::table('instituicoes_instituicoes as igreja')
        //         ->select(
        //             'igreja.id as id_igreja',
        //             'igreja.nome as igreja_nome',
        //         )->join('instituicoes_instituicoes as distrito', function ($join) {
        //             $join->on('distrito.id', '=', 'igreja.instituicao_pai_id');
        //         })
        //         ->where(['distrito.id' => $distritoId])
        //         ->orderBy('igreja.nome')
        //         ->get();
        // }else{
        //     $igrejas = [];
        // }
        return ['dados' => $dados, 'distritos' => $distritos, 'igrejas' => $igrejas];
    }
}