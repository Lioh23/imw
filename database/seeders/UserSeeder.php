<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Perfil;
use App\Models\Regra;

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
            'email' => 'prnarcosbatista1@gmail.com',
            'password' => Hash::make('Kadosh1957*'),
        ]);

        // IDs das instituições específicas
        $instituicaoIds = [2215];

        // Atribuição do perfil Administrador aos usuários e vinculação com as instituições
        $perfilAdmin = Perfil::where('nome', 'Administrador Local')->first();
        
        if ($perfilAdmin) {
            // Vinculando todas as regras ao perfil Administrador
            $regras = Regra::all();
            foreach ($regras as $regra) {
                $perfilAdmin->regras()->attach($regra->id);
            }

            // Associando cada instituição ao perfil de administrador para cada usuário
            foreach ($instituicaoIds as $instituicaoId) {
                $admin->perfils()->attach($perfilAdmin->id, ['instituicao_id' => $instituicaoId]);
                $marcos->perfils()->attach($perfilAdmin->id, ['instituicao_id' => $instituicaoId]);
            }
        }
    }
}
