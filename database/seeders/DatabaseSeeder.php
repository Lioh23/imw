<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MembresiaTipoAtuacaoSeeder::class);
        $this->call(MembresiaSituacaoSeeder::class);
        $this->call(MembresiaSetorSeeder::class);
        $this->call(MembresiaFuncaoEclesiasticaSeeder::class);
        $this->call(MembresiaCursoSeeder::class);
        $this->call(InstituicoesTipoInstituicaoSeeder::class);
        $this->call(InstituicoesInstituicaoSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MembresiaFormacaoSeeder::class);
    }
}
