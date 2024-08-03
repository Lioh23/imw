<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CreateViewsCommand extends Command
{
    protected $signature = 'create:views';

    protected $description = 'Este comando pega todas as views documentadas na pasta docs e as cria no banco de dados.';

    public function handle()
    {
        $directory = base_path('docs/sql/views');
        $files = File::allFiles($directory);

        $this->info('Iniciando a criação de views');

        $this->withProgressBar($files, function ($file) {
            $sqlContent = File::get($file->getPathname());

            DB::statement($sqlContent);
        });

        $this->line(''); 
        $this->info('Views criadas com sucesso');

    }
}
