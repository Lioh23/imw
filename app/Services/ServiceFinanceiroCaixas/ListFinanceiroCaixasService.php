<?php

namespace App\Services\ServiceFinanceiroCaixas;

use App\Models\FinanceiroCaixa;

class ListFinanceiroCaixasService
{
    public function execute($parameters = null)
    {
        return [
            'caixas' => $this->handleListaCaixas($parameters),
        ];
    }

    private function handleListaCaixas($parameters = null)
    {
        return FinanceiroCaixa::when(isset($parameters['search']), function ($query) use ($parameters) {
            $searchTerm = $parameters['search'];
            $query->where(function($query) use ($searchTerm) {
                $query->where('descricao', 'like', "%$searchTerm%")
                      ->orWhere('tipo', 'like', "%$searchTerm%");
            });
        })
        ->where('instituicao_id', session()->get('session_perfil')->instituicao_id)
        ->orderBy('id', 'asc') 
        ->paginate(30);
    
    }
}
