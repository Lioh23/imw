<?php

namespace App\Services\ServiceInstituicaoIgrejas;

use App\Models\InstituicoesInstituicao;

class AtivarRegiaoIgrejasService
{
    public function execute($id)
    {
        $igrejas = InstituicoesInstituicao::withTrashed()->findOrFail($id);
        $igrejas->restore(); // Restaurar o soft delete
    }
}
