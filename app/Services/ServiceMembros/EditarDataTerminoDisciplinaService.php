<?php

namespace App\Services\ServiceMembros;

use App\Models\MembresiaDisciplina;

class EditarDataTerminoDisciplinaService
{
    public function execute($dataTermino, $id)
    {
        $disciplina = MembresiaDisciplina::find($id);

        if ($disciplina) {
            $disciplina->update([
                'dt_termino' => $dataTermino,
            ]);
            return "Campo atualizado com sucesso!";
        } else {
            return "Disciplina não encontrada";
        }
    }
}
