<?php

namespace App\Services\ServiceGCeu;
use App\Models\GCeuMembros;

class GCeuUpdateMembroService
{

    public function execute(array $data, $id): void
    {
        $dataGceu = $this->prepareGceuData($data);
        $membroID = $id;
        $this->handleUpdateGceu($dataGceu, $membroID);
    }

    private function prepareGceuData(array $data): array
    {
        $dataGceuMembro = [];
        if (isset($data['gceu'])) {
            foreach ($data['gceu'] as $index => $gceu) {
                if($gceu != null){                
                    $dataGceuMembro[] = [
                        'gceu_cadastro_id' => $gceu,
                        'gceu_funcao_id' => $data['gceu-funcao'][$index] ?? null,
                    ];
                }
            }
        }
        return $dataGceuMembro;
    }

    private function handleUpdateGCeu(array $dataGceu, $membroId): void
    {
        $updatedGceuIds = [];

        foreach ($dataGceu as $gceu) {
            if (!empty($gceu['gceu_cadastro_id']) && !empty($gceu['gceu_funcao_id'])) {
                $gceu['membro_id'] = $membroId;
                $gceuMembrosModel = GCeuMembros::updateOrCreate(
                    [
                        'membro_id' => $membroId,
                        'gceu_cadastro_id' => $gceu['gceu_cadastro_id'],
                        'gceu_funcao_id' => $gceu['gceu_funcao_id'],
                    ],
                    $gceu
                );

                $updatedGceuIds[] = $gceuMembrosModel->id;
            }
        }

        GCeuMembros::where('membro_id', $membroId)
            ->whereNotIn('id', $updatedGceuIds)
            ->delete();
    }

}
