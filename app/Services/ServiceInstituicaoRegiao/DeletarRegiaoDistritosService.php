<?php

namespace App\Services\ServiceInstituicaoRegiao;

use App\Models\InstituicoesInstituicao;

class DeletarRegiaoDistritosService
{
    public function execute($id)
    {
        $distrito = InstituicoesInstituicao::findOrFail($id);
        $distrito->delete(); // Soft delete
    }
}
