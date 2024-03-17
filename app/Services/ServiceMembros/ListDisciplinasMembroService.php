<?php

namespace App\Services\ServiceMembros;

use App\Models\MembresiaDisciplina;

class ListDisciplinasMembroService
{
    public function execute ($id)
    {
        return MembresiaDisciplina::where('membro_id', $id)->get();
    }
}