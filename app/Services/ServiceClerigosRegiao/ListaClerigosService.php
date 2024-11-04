<?php

namespace App\Services\ServiceClerigosRegiao;

use App\Models\PessoasPessoa;

class ListaClerigosService
{
    public function execute($parameters = null,)
    {

        
        $regiao_id = (int) session()->get('session_perfil')->instituicao_id;
        $searchTerm = is_array($parameters) && isset($parameters['searchTerm']) ? $parameters['searchTerm'] : null;
        dd($parameters);
        $clerigos = PessoasPessoa::query()->withTrashed()->where('regiao_id', $regiao_id)
            ->when($searchTerm, function ($query, $searchTerm) {
                $query->where('nome', 'like', "%{$searchTerm}%");
            })
            ->orderBy('nome', 'asc')
            ->paginate(50);
        return $clerigos;
    }
}
