<?php

namespace Database\Seeders;

use App\Models\Perfil;
use App\Models\Regra;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerfilRegraTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $perfilAdmin = Perfil::where('nome', 'Administrador - Igreja')->first();
        $regras = Regra::all();

        if ($perfilAdmin) {
            foreach ($regras as $regra) {
                // Insere o relacionamento na tabela pivot
                DB::table('perfil_regra')->insert([
                    'perfil_id' => $perfilAdmin->id,
                    'regra_id' => $regra->id
                ]);
            }
        }
    }
}
