<?php 

namespace App\Services\ServicesUsuarios;

use App\Models\User;

class ListUsuariosService
{
    public function execute($parameters = null)
    {
        return [
            'usuarios'         => $this->handleListaMembros($parameters),
        ];
    }

    private function handleListaMembros($parameters = null)
    {
        return User::with(['perfilUser.perfil', 'perfilUser.instituicao'])
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