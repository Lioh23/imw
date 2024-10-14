<?php

namespace App\Services\ServiceInstituicaoSecretarias;

use App\Models\InstituicoesInstituicao;

class ListarRegiaoSecretariasServices
{
    public function execute($parameters = null)
    {
        $secretarias = InstituicoesInstituicao::withTrashed() // Incluir registros deletados
            ->when(isset($parameters['search']), function ($query) use ($parameters) {
                $searchTerm = $parameters['search'];
                $query->where(function ($query) use ($searchTerm) {
                    $query->where('nome', 'like', "%$searchTerm%")
                        ->orWhere('cnpj', 'like', "%$searchTerm%")
                        ->orWhere('cidade', 'like', "%$searchTerm%")
                        ->orWhere('telefone', 'like', "%$searchTerm%");
                });
            })
            ->where(function ($query) {
                $query->where('tipo_instituicao_id', 9);
            })
            ->where('instituicao_pai_id', session()->get('session_perfil')->instituicao_id)
            ->orderBy('nome', 'asc')
            ->paginate(50);

        return $secretarias;
    }
}
