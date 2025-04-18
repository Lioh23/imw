<?php

namespace App\Services\ServicesUsuarios;

use App\Models\PerfilUser;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SalvarUsuarioService
{

    public function execute($data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'cpf'  => preg_replace('/[^0-9]/', '', $data['cpf']),
            'telefone' => preg_replace('/[^0-9]/', '', $data['telefone']),
            'pessoa_id' => $data['pessoa_id'] ?? null
        ]);

        foreach ($data['perfil_id'] as $key => $perfilId) {
            PerfilUser::create([
                'user_id' => $user->id,
                'perfil_id' => $perfilId,
                'instituicao_id' => $data['instituicao_id'][$key],
            ]);
        }
    }

}
