<?php

namespace App\Services\ServiceInstituicaoRegiao;

use App\Models\InstituicoesInstituicao;

class DetalhesRegiaoService
{
    public function execute($id)
    {
        // Busca o instituicao pelo ID
        $instituicao = InstituicoesInstituicao::findOrFail($id);
        
        return $instituicao;
    }
}
