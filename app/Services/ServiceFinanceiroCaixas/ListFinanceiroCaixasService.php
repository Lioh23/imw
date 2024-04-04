<?php

namespace App\Services\ServiceFinanceiroCaixas;

use App\Models\FinanceiroCaixa;
use App\Models\FinanceiroPlanoConta;
use App\Models\User;

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
        ->orderBy('id', 'asc') 
        ->paginate(30);
    }
}
