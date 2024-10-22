<?php

namespace App\Services\ServiceClerigosRegiao;

use App\Models\PessoasPessoa;

class DetalhesRegiaoClerigosService
{
    public function execute($id)
    {
        // Busca o clerigo pelo ID
        $clerigo = PessoasPessoa::findOrFail($id);
        
        return $clerigo;
    }
}
