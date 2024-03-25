<?php 
namespace App\Services\ServicesUsuarios;

use App\Models\PerfilUser;
use App\Models\User;

class DeletarUsuarioService
{
    public function execute($id)
    {
        $user = User::findOrFail($id);

        // Deletar perfis associados ao usuário
        PerfilUser::where('user_id', $user->id)->delete();

        // Deletar o usuário
        $user->delete();
    }
}
