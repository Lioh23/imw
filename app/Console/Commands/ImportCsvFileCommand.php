<?php

namespace App\Console\Commands;

use App\Models\ControleImportacaoCsv;
use App\Services\ServiceImportacao\ImportacaoService;
use App\Services\ServiceImportacao\LeitorCsvService;
use Illuminate\Console\Command;

class ImportCsvFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'csv:import {import_alias}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importação do conteúdo dos arquivos CSV para dentro do banco de dados';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $controle = ControleImportacaoCsv::where('alias', $this->argument('import_alias'))
            // ->where('executed', false)
            ->firstOr(fn () => dd('Controle de importação já realizado ou não localizado!') );

        $collection = app(LeitorCsvService::class)->execute($controle->file);
        $imported = ImportacaoService::{$controle->static_method}($collection, $controle);

        if ($imported)
            $this->info("Importação de {$controle->alias} realizada com sucesso!");
        else
            $this->error("Erro na importação de {$controle->alias}.");
    }
}
