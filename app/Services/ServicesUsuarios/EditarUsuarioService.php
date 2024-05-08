<?php

namespace App\Services\ServicesUsuarios;

use App\Models\PerfilUser;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class EditarUsuarioService
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

        $instituicaoID = $data['instituicao_id'];
        $perfilID = $data['perfil_id'];

        PerfilUser::where('user_id', $user->id)
            ->where('instituicao_id', '=', $instituicaoID)
            ->delete();

        PerfilUser::create([
                'user_id' => $user->id,
                'perfil_id' => $perfilID,
                'instituicao_id' => $instituicaoID,
        ]);

    }
}
