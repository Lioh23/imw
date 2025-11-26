<?php

namespace App\Services\ServiceGCeu;

use App\Models\GCeu;
use App\Models\GCeuCartaPastoral;
use App\Traits\Identifiable;

class StoreGCeuCartaPastoralService
{
    use Identifiable;

    public function execute(array $data): void
    {
        
        $dataGCeuCartaPastoral = [
            'instituicao_id' => Identifiable::fetchSessionIgrejaLocal()->id,
            'pessoa_id' => $data['pessoa_id'],
            'titulo' => $data['titulo'],
            'introducao' => $data['titulo'],
            'conteudo' => $data['conteudo'],
            'data_criacao' => date('Y-m-d')
        ];
        $this->handleStoreGCeuCartaPastoral($dataGCeuCartaPastoral);
    }

    private function handleStoreGCeuCartaPastoral($dataGCeuCartaPastoral)
    {
        GCeuCartaPastoral::create($dataGCeuCartaPastoral);
    }
}
