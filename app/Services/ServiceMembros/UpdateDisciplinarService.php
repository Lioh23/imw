<?php

namespace App\Services\ServiceMembros;

use App\Exceptions\DisciplinaNotFoundException;
use App\Models\MembresiaDisciplina;

class UpdateDisciplinarService
{
    public function execute($dataTermino, $id)
    {
        MembresiaDisciplina::findOr($id, fn() => throw new DisciplinaNotFoundException())
            ->update(['dt_termino' => $dataTermino]);
    }
}
