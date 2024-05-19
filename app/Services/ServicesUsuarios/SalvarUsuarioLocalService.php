<?php

namespace App\Services\ServicesUsuarios;

use App\Models\PerfilUser;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SalvarUsuarioLocalService
{

    public function execute($data)
    {

        dd($data);
        if($data['tipo'] == 'cadastro'){
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            PerfilUser::create([
                'user_id' => $user->id,
                'perfil_id' => $data['perfil_id'],
                'instituicao_id' => session()->get('session_perfil')->instituicao_id,
            ]);
        } else if($data['tipo'] == 'vinculo'){
            $user = User::where('email', $data['email'])->first();
            if ($user) {
                $user->perfil_id = $data['perfil_id'];
                $user->save();
            } else {
                throw new \Exception('Usuário não encontrado para vincular perfil');
            }
        } else {
            throw new \Exception('Precisa informar um e-mail');
        }
    }

}
