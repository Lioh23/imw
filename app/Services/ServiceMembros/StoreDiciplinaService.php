<?php

namespace App\Services\ServiceMembros;

use App\Models\MembresiaDisciplina;
use Illuminate\Support\Facades\Log;


class StoreDiciplinaService 
{
    public function execute (array $data, string $id) 
    {
        $dataLocalidade = app(IdentificaDadosLocalidadeMembroService::class)->execute($id);

        $dataDiciplina = [
            'dt_inicio' => $data['dt_inicio'],
            'dt_termino' => $data['dt_termino'],
            'modo_disciplina_id' => $data['modo_exclusao_id'],
            'pastor_id' => $data['clerigo_id'],
            'observacao' => $data['observacao'],
            'membro_id' => $id,
            'distrito_id' => $dataLocalidade['distrito_id'],
            'igreja_id' => $dataLocalidade['igreja_id'],
            'regiao_id' => $dataLocalidade['regiao_id'],
            'congregacao_id' => $dataLocalidade['congregacao_id'],
        ];

        $this->handleStoreDiciplina($dataDiciplina);
    }


    private function handleStoreDiciplina($data)
    {
        try {
            MembresiaDisciplina::create($data);
            Log::info('Registro de disciplina criado com sucesso:', $data);
        } catch (\Exception $e) {
            Log::error('Erro ao criar registro de disciplina:', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
