<?php 

namespace App\Services\ServiceMembros;

use App\Models\MembresiaDisciplina;

class VerificaMembroDiciplinaService
{
    public function execute ($id)
    {
        return $this->handleHasDiciplina($id);
    }

    private function handleHasDiciplina($id)
    {
        return MembresiaDisciplina::where('membro_id', $id)->count();
    }
}