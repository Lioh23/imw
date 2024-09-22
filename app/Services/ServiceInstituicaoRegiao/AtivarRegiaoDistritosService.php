<?php

namespace App\Services\ServiceInstituicaoRegiao;

use App\Models\InstituicoesInstituicao;

class AtivarRegiaoDistritosService
{
    public function execute($id)
    {
        $distrito = InstituicoesInstituicao::withTrashed()->findOrFail($id);
        $distrito->restore(); // Restaurar o soft delete
    }
}
