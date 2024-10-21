<?php

namespace App\Services\ServiceClerigosRegiao;

use App\Models\PessoasPessoa;

class ListaClerigosService
{
    public function execute($searchTerm = null)
    {
        $regiao_id = (int) session()->get('session_perfil')->instituicao_id;

        $clerigos = PessoasPessoa::query()->withTrashed()->where('regiao_id', $regiao_id)
            ->when(isset($searchTerm), function ($query) {
                $query->where('nome', 'like', "%{$this->searchTerm}%");
            })
            ->orderBy('nome', 'asc')
            ->paginate(50);
        return $clerigos;
    }
}
