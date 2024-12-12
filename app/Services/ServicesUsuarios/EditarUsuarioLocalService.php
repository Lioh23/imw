<?php

namespace App\Services\ServicesUsuarios;

use App\Models\PerfilUser;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class EditarUsuarioLocalService
{
    public function execute($data, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'cpf'  => preg_replace('/[^0-9]/', '', $data['cpf']),
            'telefone' => preg_replace('/[^0-9]/', '', $data['telefone']),
            'pessoa_id' => $data['pessoa_id'] ?? null
        ]);

        if (isset($data['password']) && !empty($data['password'])) {
            $user->update([
                'password' => Hash::make($data['password']),
            ]);
        }

        $perfilID = $data['perfil_id'];

        PerfilUser::where('user_id', $user->id)
            ->where('instituicao_id', '=', session()->get('session_perfil')->instituicao_id)
            ->delete();

        PerfilUser::create([
                'user_id' => $user->id,
                'perfil_id' => $perfilID,
                'instituicao_id' => session()->get('session_perfil')->instituicao_id,
        ]);

    }
}
