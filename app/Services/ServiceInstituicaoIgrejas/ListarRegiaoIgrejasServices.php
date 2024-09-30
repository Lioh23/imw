<?php

namespace App\Services\ServiceInstituicaoIgrejas;

use App\Models\InstituicoesInstituicao;

class ListarRegiaoIgrejasServices
{
    public function execute($parameters = null)
    {
        $igrejas = InstituicoesInstituicao::withTrashed() // Incluir registros deletados
            ->when(isset($parameters['search']), function ($query) use ($parameters) {
                $searchTerm = $parameters['search'];
                $query->where(function($query) use ($searchTerm) {
                    $query->where('nome', 'like', "%$searchTerm%")
                          ->orWhere('cnpj', 'like', "%$searchTerm%")
                          ->orWhere('cidade', 'like', "%$searchTerm%")
                          ->orWhere('telefone', 'like', "%$searchTerm%");
                });
            })
            ->whereIn('instituicao_pai_id', function($query) {
                $query->select('id')
                      ->from('instituicoes_instituicoes')
                      ->where('instituicao_pai_id', session()->get('session_perfil')->instituicao_id);
            })
            ->orderBy('id', 'desc')
            ->paginate(50);
    
        return $igrejas;
    }
}
