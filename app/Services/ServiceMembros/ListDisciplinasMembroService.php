<?php

namespace App\Services\ServiceMembros;

use App\Models\MembresiaDisciplina;

class ListDisciplinasMembroService
{
    public function execute ($id)
    {
        $disciplinas = MembresiaDisciplina::where('membro_id', $id)->get();
        return $disciplinas;
    }
}