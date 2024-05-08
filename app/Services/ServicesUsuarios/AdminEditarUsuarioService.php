<?php

namespace App\Services\ServicesUsuarios;

use App\Models\PerfilUser;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminEditarUsuarioService
{
    public function execute($data, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        if (isset($data['password']) && !empty($data['password'])) {
            $user->update([
                'password' => Hash::make($data['password']),
            ]);
        }

        PerfilUser::where('user_id', $user->id)->delete();

        foreach ($data['perfil_id'] as $key => $perfilId) {
            PerfilUser::create([
                'user_id' => $user->id,
                'perfil_id' => $perfilId,
                'instituicao_id' => $data['instituicao_id'][$key],
            ]);
        }
    }
}
