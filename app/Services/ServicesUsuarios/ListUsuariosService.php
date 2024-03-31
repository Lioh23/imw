<?php 

namespace App\Services\ServicesUsuarios;

use App\Models\User;

class ListUsuariosService
{
    public function execute($parameters = null)
    {
        return [
            'usuarios' => $this->handleListaMembros($parameters),
        ];
    }

    private function handleListaMembros($parameters = null)
    {
        return User::with(['perfilUser.perfil', 'perfilUser.instituicao'])
        ->whereHas('instituicoes', function ($query) {
            $query->where('instituicoes_instituicoes.id', session()->get('session_perfil')->instituicao_id)
                  ->orWhere('instituicoes_instituicoes.instituicao_pai_id', session()->get('session_perfil')->instituicao_id);
        })
        ->when(isset($parameters['search']), function ($query) use ($parameters) {
            $searchTerm = $parameters['search'];
            $query->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%$searchTerm%")
                      ->orWhere('email', 'like', "%$searchTerm%");
            });
        })
        ->paginate(100);
    }
}