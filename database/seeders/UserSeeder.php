<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Perfil;
use App\Models\Regra;
use App\Models\UserInstituicao;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Criação de usuários
        $admin = User::create([
            'name' => 'Usuário Administrador',
            'email' => 'admin@brasmid.com.br',
            'password' => Hash::make('sk8namao'),
        ]);

        $marcos = User::create([
            'name' => 'Marcos Batista',
            'email' => 'prmarcosbatista1@gmail.com',
            'password' => Hash::make('Kadosh1957*'),
        ]);

        // Vinculando o perfil Administrador aos usuários
        $perfilAdmin = Perfil::where('nome', 'Administrador - Igreja')->first();
        $perfilAdminDistrito = Perfil::where('nome', 'Administrador - Distrito')->first();
        $perfilAdminRegiao = Perfil::where('nome', 'Administrador - Região')->first();

        //Regra comuns de tela de usuário
        function attachRegras($perfil, $regras) {
            foreach ($regras as $regra) {
                $perfil->regras()->attach($regra);
            }
        }
        
        $regrasComuns = [4, 5, 6, 7, 8, 9];
        
        if ($perfilAdminDistrito) {
            attachRegras($perfilAdminDistrito, $regrasComuns);
        }
        
        if ($perfilAdminRegiao) {
            attachRegras($perfilAdminRegiao, $regrasComuns);
        }
        //Fim das regras comuns

        if ($perfilAdmin) {
            $admin->perfis()->attach($perfilAdmin->id, ['instituicao_id' => 2215]);
            $admin->perfis()->attach($perfilAdmin->id, ['instituicao_id' => 2275]);

            $marcos->perfis()->attach($perfilAdmin->id, ['instituicao_id' => 13]);

            // Vinculando todas as regras ao perfil Administrador
            $regras = Regra::all();
            foreach ($regras as $regra) {
                $perfilAdmin->regras()->attach($regra->id);
            }
        }

        // Vinculando as instituições aos usuários
        UserInstituicao::create(['user_id' => $admin->id, 'instituicao_id' => 13]); // região
        UserInstituicao::create(['user_id' => $admin->id, 'instituicao_id' => 2275]); // distrito
        UserInstituicao::create(['user_id' => $admin->id, 'instituicao_id' => 2215]); // igreja

        UserInstituicao::create(['user_id' => $marcos->id, 'instituicao_id' => 13]); // região
    }
}


