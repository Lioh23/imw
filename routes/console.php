<?php

use App\Models\Formacao;
use App\Models\InstituicoesInstituicao;
use App\Models\PessoasPessoa;
use App\Traits\FakerUtils;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Foreach_;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('regiaoId', function () {
    // Obtém todas as instituições
    $instituicoes = InstituicoesInstituicao::withTrashed()->get();
    $hierarquia1 = []; // Array para armazenar as instituições do tipo 2
    $igrejas = []; // Array para armazenar as instituições que tipo 1

    foreach ($instituicoes as $i) {
        // Verifica se o tipo da instituição é 2
        if ($i['tipo_instituicao_id'] == 2 || $i['tipo_instituicao_id'] == 5 || $i['tipo_instituicao_id'] == 15) {
            $hierarquia1[] = $i; // Adiciona à lista de hierarquia1
        } elseif ($i['tipo_instituicao_id'] == 1) {
            $igrejas[] = $i;
        }
        // Imprime o tipo da instituição no console
        // $this->info("Tipo: {$i['tipo_instituicao_id']}");
    }

    // Após o loop, verifica se encontrou instituições do tipo 2
    if (!empty($hierarquia1)) {
        $this->info('Instituições do tipo 2:');
        foreach ($hierarquia1 as $resultado) {
            $resultado->regiao_id = $resultado->instituicao_pai_id;
            $resultado->save();
        }
        $this->info('Instituições ok');
    }
    if (!empty($igrejas)) {
        $this->info('Instituições Igrejas');
        foreach ($igrejas as $igreja) {
            $instituto_pai = $igreja['instituicao_pai_id'];
            $distrito_igreja =  InstituicoesInstituicao::withTrashed()->where('id', $instituto_pai)->first();
            if ($distrito_igreja) {
                $igreja->regiao_id =  $distrito_igreja->instituicao_pai_id;
            }
            $igreja->save();
        }
        $this->info('igrejas ok');
    }
});


Artisan::command('formacao', function () {
    $listaFormacao = [
        'Ensino Fundamental',
        'Ensino Médio',
        'Superior Completo',
        'Superior Incompleto',
        'Pós-Graduação',
        'Mestrado',
        'Doutorado',
        'Pós-Doutorado',
    ];
    foreach($listaFormacao as $formacao){
        Formacao::create(
            [
                'nivel' => $formacao,
            ]
            );
    };

});

Artisan::command('cpf-aleatorio-pessoas', function () {
    $pessoas = PessoasPessoa::all();

    $this->info('Iniciando geração de CPF\'s randômicos para pessoas');

    $this->withProgressBar($pessoas, function (PessoasPessoa $pessoa) {
        $pessoa->cpf = FakerUtils::generateRandomCpf();
        $pessoa->save();
    });

    $this->line('');
    $this->info('CPF\'s randômicos gerados com sucesso');

});


Artisan::command('atualizar-onus', function () {
    $this->info('Iniciando a atualização da coluna "onus" na tabela "pessoas_funçãoministerial"...');

    DB::table('pessoas_funcaoministerial')
        ->where('funcao', 'like', '%sem ônus%')
        ->update(['onus' => false]);


    DB::table('pessoas_funcaoministerial')
        ->where('funcao', 'not like', '%sem ônus%')
        ->update(['onus' => true]);

    $this->info('Coluna "onus" atualizada com sucesso.');
});
