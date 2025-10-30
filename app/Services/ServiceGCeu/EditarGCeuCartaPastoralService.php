<?php

namespace App\Services\ServiceGCeu;

use App\Models\GCeu;
use App\Models\GCeuCartaPastoral;
use App\Traits\Identifiable;

class EditarGCeuCartaPastoralService
{
    public function execute($id, array $data): void
    {
        $cartaPastoral = GCeuCartaPastoral::findOrFail($id);
        $cartaPastoral->update([
            'instituicao_id' => Identifiable::fetchSessionIgrejaLocal()->id,
            'pessoa_id' => auth()->user()->pessoa_id,
            'titulo' => $data['titulo'],
            'introducao' => $data['titulo'],
            'conteudo' => $data['conteudo']
        ]);
    }

    public function findOne($id): ?GCeuCartaPastoral
    {
        $cartaPastoral = GCeuCartaPastoral::where('id', $id)->first();

        return $cartaPastoral;
    }
}
