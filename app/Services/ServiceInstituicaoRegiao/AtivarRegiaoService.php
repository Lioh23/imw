<?php

namespace App\Services\ServiceInstituicaoRegiao;

use App\Models\InstituicoesInstituicao;

class AtivarRegiaoService
{
    public function execute($id)
    {
        $instituicao = InstituicoesInstituicao::withTrashed()->findOrFail($id);
        $instituicao->restore(); // Restaurar o soft delete
    }
}
