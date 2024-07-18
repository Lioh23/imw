<?php

// database/seeders/FinanceiroPlanoContaTipoInstituicaoSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\FinanceiroPlanoContaTipoInstituicao;

class FinanceiroPlanoContaTipoInstituicaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csvFile = base_path('database/data/financeiro_plano_conta_tipo_instituicao.csv');

        if (!File::exists($csvFile)) {
            $this->command->error("CSV file not found at path: $csvFile");
            return;
        }

        $file = fopen($csvFile, 'r');
        $isFirstRow = true;

        while (($row = fgetcsv($file, 1000, ';')) !== FALSE) {
            if ($isFirstRow) {
                $isFirstRow = false;
                continue;
            }

            FinanceiroPlanoContaTipoInstituicao::create([
                'id' => $row[0],
                'plano_conta_id' => $row[1],
                'tipo_instituicao_id' => $row[2],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        fclose($file);
    }
}
