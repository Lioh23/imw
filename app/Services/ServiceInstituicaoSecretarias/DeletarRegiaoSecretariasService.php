<?php

namespace App\Services\ServiceInstituicaoSecretarias;

use App\Models\InstituicoesInstituicao;

class DeletarRegiaoSecretariasService
{
    public function execute($id)
    {
        $secretarias = InstituicoesInstituicao::findOrFail($id);
        $secretarias->delete(); // Soft delete
    }
}
