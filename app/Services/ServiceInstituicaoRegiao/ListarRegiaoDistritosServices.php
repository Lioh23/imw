<?php

namespace App\Services\ServiceInstituicaoRegiao;

use App\Models\InstituicoesInstituicao;

class ListarRegiaoDistritosServices
{
    public function execute($parameters = null)
    {
        $distritos = InstituicoesInstituicao::withTrashed() // Incluir registros deletados
            ->when(isset($parameters['search']), function ($query) use ($parameters) {
                $searchTerm = $parameters['search'];
                $query->where(function($query) use ($searchTerm) {
                    $query->where('nome', 'like', "%$searchTerm%")
                          ->orWhere('cnpj', 'like', "%$searchTerm%")
                          ->orWhere('cidade', 'like', "%$searchTerm%")
                          ->orWhere('telefone', 'like', "%$searchTerm%");
                });
            })
            ->where('tipo_instituicao_id', 2) //Tipo DISTRITO
            ->where('instituicao_pai_id', session()->get('session_perfil')->instituicao_id) //Pega ID Região Logada
            ->orderBy('id', 'asc') 
            ->paginate(50);
    
        return  $distritos;
    }
    
}


