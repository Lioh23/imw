<?php

namespace Database\Seeders;

use App\Models\InstituicoesInstituicao;
use App\Models\Perfil;
use App\Models\Regra;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
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
        $admin = User::create([
            'name' => 'Usuário Administrador',
            'email' => 'admin@brasmid.com.br',
            'password' => Hash::make('sk8namao'), // Utilize uma senha segura
        ]);

        $marcos = User::create([
            'name' => 'Marcos Batista',
            'email' => 'prnarcosbatista1@gmail.com',
            'password' => Hash::make('Kadosh1957*'), 
        ]);


         UserInstituicao::create(['user_id' => $admin->id, 'instituicao_id' => 13]); // regiao
         UserInstituicao::create(['user_id' => $admin->id, 'instituicao_id' => 1758]); // distrito
         UserInstituicao::create(['user_id' => $admin->id, 'instituicao_id' => 2215]); // igreja

         UserInstituicao::create(['user_id' => $marcos->id, 'instituicao_id' => 13]); // regiao
         UserInstituicao::create(['user_id' => $marcos->id, 'instituicao_id' => 1758]); // distrito
         UserInstituicao::create(['user_id' => $marcos->id, 'instituicao_id' => 2215]); // igreja
   
         //Segurança
         $perfilAdmin = Perfil::where('nome', 'Administrador')->first();
         if ($perfilAdmin) {
            // Atribuindo o perfil de Administrador aos usuários
            $admin->perfils()->attach($perfilAdmin->id);
            $marcos->perfils()->attach($perfilAdmin->id);

            // Vinculando todas as regras ao perfil de Administrador
            $regras = Regra::all();
            foreach ($regras as $regra) {
                $perfilAdmin->regras()->attach($regra->id);
            }
        }

    }
}
