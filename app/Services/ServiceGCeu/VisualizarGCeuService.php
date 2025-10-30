<?php

namespace App\Services\ServiceGCeu;

use App\Models\GCeu;
use App\Traits\Identifiable;

class VisualizarGCeuService 
{
    public function findOne($id): ?GCeu
    {
        $gceu = GCeu::select('gceu_cadastros.*', 'congregacoes_congregacoes.nome as congregacao', 'instituicoes_instituicoes.nome as igreja')
            ->leftJoin('congregacoes_congregacoes', 'congregacoes_congregacoes.id', 'gceu_cadastros.congregacao_id')
            ->leftJoin('instituicoes_instituicoes', 'instituicoes_instituicoes.id', 'gceu_cadastros.instituicao_id')
            ->where('gceu_cadastros.id', $id)->first();
        return $gceu;
    }
}
