<?php

namespace Database\Seeders;

use App\Models\InstituicoesInstituicao;
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
        $user = User::create([
            'name' => 'Usuário Administrador',
            'email' => 'admin@brasmid.com.br',
            'password' => Hash::make('sk8namao'), // Utilize uma senha segura
        ]);

        $usertwo = User::create([
            'name' => 'Marcos Batista',
            'email' => 'prnarcosbatista1@gmail.com',
            'password' => Hash::make('Kadosh1957*'), 
        ]);

         UserInstituicao::create(['user_id' => $user->id, 'instituicao_id' => 13]); // regiao
         UserInstituicao::create(['user_id' => $user->id, 'instituicao_id' => 1758]); // distrito
         UserInstituicao::create(['user_id' => $user->id, 'instituicao_id' => 2215]); // igreja

         UserInstituicao::create(['user_id' => $usertwo->id, 'instituicao_id' => 13]); // regiao
         UserInstituicao::create(['user_id' => $usertwo->id, 'instituicao_id' => 1758]); // distrito
         UserInstituicao::create(['user_id' => $usertwo->id, 'instituicao_id' => 2215]); // igreja
    }
}
