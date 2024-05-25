<?php

namespace App\Services\ServicesUsuarios;

use App\Models\PerfilUser;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SalvarUsuarioLocalService
{

    public function execute($data)
    {


        if($data['tipo'] == 'cadastro'){
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email_hidden'],
                'password' => Hash::make($data['password']),
                'cpf'  => preg_replace('/[^0-9]/', '', $data['cpf']),
                'telefone' => preg_replace('/[^0-9]/', '', $data['telefone']),
            ]);

            PerfilUser::create([
                'user_id' => $user->id,
                'perfil_id' => $data['perfil_id'],
                'instituicao_id' => session()->get('session_perfil')->instituicao_id,
            ]);
        } else if($data['tipo'] == 'vinculo'){
            $user = User::where('email', $data['email_hidden'])->first();
            if ($user) {
                PerfilUser::where('user_id', $user->id)
                    ->where('instituicao_id', '=', session()->get('session_perfil')->instituicao_id)
                    ->delete();

                PerfilUser::create([
                        'user_id' => $user->id,
                        'perfil_id' => $data['perfil_id'],
                        'instituicao_id' => session()->get('session_perfil')->instituicao_id,
                ]);

            } else {
                throw new \Exception('Usuário não encontrado para vincular perfil');
            }
        } else {
            throw new \Exception('Precisa informar um e-mail');
        }
    }

}
