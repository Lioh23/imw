<?php

namespace App\Services\ServiceInstituicaoRegiao;

use App\Models\InstituicoesInstituicao;

class DeletarRegiaoService
{
    public function execute($id)
    {
        $instituicao = InstituicoesInstituicao::findOrFail($id);
        $instituicao->delete(); // Soft delete
    }
}
