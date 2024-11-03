<?php

namespace App\Services\ServiceClerigosRegiao;


use App\Models\PessoasPessoa;

class AtivarClerigoService
{
    public function execute($id)
    {
        $clerigo = PessoasPessoa::withTrashed()->findOrFail($id);
        $clerigo->restore(); // Restaurar o soft delete
    }
}
