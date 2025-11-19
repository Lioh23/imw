<?php

namespace App\Services\ServiceGCeu;

use App\Models\GCeuCartaPastoral;
use App\Traits\Identifiable;

class VisualizarGCeuCartaPastoralService 
{
    public function findOne($id)
    {
        $cartaPastoral = GCeuCartaPastoral::select('gceu_cartas_pastorais.*', 'pessoas_pessoas.nome as pastor', 'igreja.nome as nome_igreja')
                ->join('pessoas_pessoas', 'pessoas_pessoas.id', 'gceu_cartas_pastorais.pessoa_id')
                ->join('instituicoes_instituicoes as igreja', function ($join) {
                    $join->on('igreja.id', '=', 'gceu_cartas_pastorais.instituicao_id');
                })
                ->where(['gceu_cartas_pastorais.status' => 'A', 'gceu_cartas_pastorais.id' => $id])->first();
        return $cartaPastoral;
    }
}
