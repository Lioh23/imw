<?php

namespace App\Services\ServiceFinanceiroPlanoConta;

use App\Models\FinanceiroPlanoConta;
use App\Models\User;

class ListFinanceiroPlanoContaService
{
    public function execute($parameters = null)
    {
        return [
            'planocontas' => $this->handleListaPlanoContas($parameters),
        ];
    }

    private function handleListaPlanoContas($parameters = null)
    {
        return FinanceiroPlanoConta::when(isset($parameters['search']), function ($query) use ($parameters) {
            $searchTerm = $parameters['search'];
            $query->where(function($query) use ($searchTerm) {
                $query->where('nome', 'like', "%$searchTerm%")
                      ->orWhere('id', 'like', "%$searchTerm%")
                      ->orWhere('numeracao', 'like', "%$searchTerm%")
                      ->orWhere('posicao', 'like', "%$searchTerm%");
            });
        })
        ->orderByRaw("CAST(SUBSTRING_INDEX(numeracao, '.', 1) AS UNSIGNED) ASC")
        ->orderByRaw("CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(numeracao, '.', 2), '.', -1) AS UNSIGNED) ASC")
        ->orderBy('id', 'asc')
        ->paginate(30);
    }
}
