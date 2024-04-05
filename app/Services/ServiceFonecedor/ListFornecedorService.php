<?php 

namespace App\Services\ServiceFonecedor;

use App\Models\FinanceiroFornecedores;

class ListFornecedorService
{
    public function execute($parameters = null)
    {
        return [
            'fornecedores' => $this->handleListaFornecedores($parameters),
        ];
    }

    private function handleListaFornecedores($parameters = null)
    {
        return FinanceiroFornecedores::when(isset($parameters['search']), function ($query) use ($parameters) {
            $searchTerm = $parameters['search'];
            $query->where(function($query) use ($searchTerm) {
                $query->where('nome', 'like', "%$searchTerm%")
                      ->orWhere('cpfcnpj', 'like', "%$searchTerm%")
                      ->orWhere('email', 'like', "%$searchTerm%");
            });
        })
        ->where('instituicao_id', session()->get('session_perfil')->instituicao_id)
        ->orderBy('id', 'asc') 
        ->paginate(30);
    
    }
}