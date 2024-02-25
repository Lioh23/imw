<?php

namespace Database\Seeders;

use App\Models\ControleImportacaoCsv;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class ImportacoesCsvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $controles = ControleImportacaoCsv::all()
            ->each(fn ($c) => Artisan::call('csv:import', ['import_alias' => $c->alias]) );
    }
}
