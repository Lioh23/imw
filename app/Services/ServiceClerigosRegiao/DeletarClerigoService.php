<?php
namespace App\Services\ServiceClerigosRegiao;

use App\Models\PessoasPessoa;

class DeletarClerigoService
{
    public function execute($id)
    {
        $clerigo = PessoasPessoa::findOrFail($id);
        if($clerigo){
            $clerigo->delete(); // Soft delete
        }

    }
}
