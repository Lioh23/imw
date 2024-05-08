<?php
namespace App\Services\ServicesUsuarios;

use App\Models\PerfilUser;
use App\Models\User;

class DeletarUsuarioService
{
    public function execute($id)
    {
        $user = User::findOrFail($id);
        PerfilUser::where('user_id', $user->id)
        ->where('instituicao_id', session()->get('session_perfil')->instituicao_id)
        ->delete();
    }
}
