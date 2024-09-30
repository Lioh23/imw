<?php

namespace App\Services\ServiceInstituicaoSecretarias;

use App\Models\InstituicoesInstituicao;

class AtivarRegiaoSecretariasService
{
    public function execute($id)
    {
        $secretarias = InstituicoesInstituicao::withTrashed()->findOrFail($id);
        $secretarias->restore(); // Restaurar o soft delete
    }
}
