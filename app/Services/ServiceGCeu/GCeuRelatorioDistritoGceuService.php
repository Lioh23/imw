<?php

namespace App\Services\ServiceGCeu;

use App\Models\GCeu;
use Illuminate\Support\Facades\DB;

class GCeuRelatorioDistritoGceuService
{
    public function getList($distritoId)
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
            })
            ->join('gceu_cadastros as gceu', function ($join) {
                $join->on('gceu.instituicao_id', '=', 'igreja.id');
            })
            ->where(['distrito.id' => $distritoId, 'gceu.status' => 'A'])
            ->orderBy('distrito.nome')
            ->orderBy('igreja.id')
            ->get();

        return ['dados' => $dados];
    }
}