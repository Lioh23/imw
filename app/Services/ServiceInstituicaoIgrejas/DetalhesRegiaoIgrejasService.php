<?php

namespace App\Services\ServiceInstituicaoIgrejas;

use App\Models\InstituicoesInstituicao;

class DetalhesRegiaoIgrejasService
{
    public function execute($id)
    {
        // Busca o igrejas pelo ID
        $igrejas = InstituicoesInstituicao::findOrFail($id);
        
        return $igrejas;
    }
}
