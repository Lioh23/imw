<?php

namespace App\Services\ServiceGCeu;

use App\Models\GCeuCartaPastoral;
use App\Traits\Identifiable;

class VisualizarGCeuCartaPastoralService 
{
    public function findOne($id)
    {
        $cartaPastoral = GCeuCartaPastoral::select('gceu_cartas_pastorais.*', 'pessoas_pessoas.nome as pastor', 'igreja.nome as nome_igreja', 'distrito.nome as nome_distrito')
                ->join('pessoas_pessoas', 'pessoas_pessoas.id', 'gceu_cartas_pastorais.pessoa_id')
                ->join('instituicoes_instituicoes as igreja', function ($join) {
                    $join->on('igreja.id', '=', 'gceu_cartas_pastorais.instituicao_id');
                })
                ->join('instituicoes_instituicoes as distrito', function ($join) {
                    $join->on('distrito.id', '=', 'igreja.instituicao_pai_id');
                })
                ->where(['gceu_cartas_pastorais.status' => 'A', 'gceu_cartas_pastorais.id' => $id])->first();
        return $cartaPastoral;
    }
}
