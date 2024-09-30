<?php

namespace App\Services\ServiceInstituicaoIgrejas;

use App\Models\InstituicoesInstituicao;

class DeletarRegiaoIgrejasService
{
    public function execute($id)
    {
        $igrejas = InstituicoesInstituicao::findOrFail($id);
        $igrejas->delete(); // Soft delete
    }
}
