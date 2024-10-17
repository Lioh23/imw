<?php

namespace App\Services\ServiceInstituicaoRegiao;

use App\Models\InstituicoesInstituicao;

class ListarRegiaoServices
{
    public function execute($parameters = null, $tipoInstituicaoId)
    {
        if ($tipoInstituicaoId == null) {
         
            $instituicoes = InstituicoesInstituicao::withTrashed() // Incluir registros deletados
                ->when(isset($parameters['search']), function ($query) use ($parameters) {
                    $searchTerm = $parameters['search'];
                    $query->where(function ($query) use ($searchTerm) {
                        $query->where('nome', 'like', "%$searchTerm%")
                            ->orWhere('cnpj', 'like', "%$searchTerm%")
                            ->orWhere('cidade', 'like', "%$searchTerm%")
                            ->orWhere('telefone', 'like', "%$searchTerm%");
                    });
                })
                ->where('regiao_id', session()->get('session_perfil')->instituicao_id) //Pega ID Região Logada
                ->orderBy('nome', 'asc')
                ->paginate(50);

            return $instituicoes;
        } else {
            $instituicoes = InstituicoesInstituicao::withTrashed() // Incluir registros deletados
                ->when(isset($parameters['search']), function ($query) use ($parameters) {
                    $searchTerm = $parameters['search'];
                    $query->where(function ($query) use ($searchTerm) {
                        $query->where('nome', 'like', "%$searchTerm%")
                            ->orWhere('cnpj', 'like', "%$searchTerm%")
                            ->orWhere('cidade', 'like', "%$searchTerm%")
                            ->orWhere('telefone', 'like', "%$searchTerm%");
                    });
                })
                ->where('regiao_id', session()->get('session_perfil')->instituicao_id)
                ->where('tipo_instituicao_id',$tipoInstituicaoId) //Pega ID Região Logada
                ->orderBy('nome', 'asc')
                ->paginate(50);

            return $instituicoes;
        }
    }
}
