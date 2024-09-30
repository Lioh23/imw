<?php

namespace App\Services\ServiceInstituicaoSecretarias;

use App\Models\InstituicoesInstituicao;

class DetalhesRegiaoSecretariasService
{
    public function execute($id)
    {
        // Busca o secretarias pelo ID
        $secretarias = InstituicoesInstituicao::findOrFail($id);
        
        return $secretarias;
    }
}
