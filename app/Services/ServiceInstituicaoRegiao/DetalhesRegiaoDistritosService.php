<?php

namespace App\Services\ServiceInstituicaoRegiao;

use App\Models\InstituicoesInstituicao;

class DetalhesRegiaoDistritosService
{
    public function execute($id)
    {
        // Busca o distrito pelo ID
        $distrito = InstituicoesInstituicao::findOrFail($id);
        
        return $distrito;
    }
}
